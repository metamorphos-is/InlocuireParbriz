<?php

namespace App\Services\DataForSeo;

use App\Models\DataForSeoRequest;
use App\Models\SiteSetting;
use App\Support\SettingSecret;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

/**
 * Client DataForSEO v3 — rulează DOAR pe server.
 *
 * - Credențiale: .env (DATAFORSEO_LOGIN / DATAFORSEO_PASSWORD) sau, ca alternativă,
 *   Setări site → DataForSEO (parola criptată în site_settings). Nu ajung niciodată în frontend.
 * - Cache: un răspuns reușit pentru același endpoint + payload e refolosit N zile (nu plătim de două ori).
 * - Buget: se refuză apelurile când costul lunii curente depășește plafonul.
 * - Jurnal: fiecare apel (inclusiv erorile) e salvat în `dataforseo_requests`.
 */
class DataForSeoClient
{
    public const BASE_URL = 'https://api.dataforseo.com';

    public const ROMANIA = 2642;

    public function __construct(protected ?int $researchRunId = null) {}

    public function forRun(?int $runId): static
    {
        $clone = clone $this;
        $clone->researchRunId = $runId;

        return $clone;
    }

    /** @return array{login:?string,password:?string} */
    public static function credentials(): array
    {
        $login = config('services.dataforseo.login');
        $password = config('services.dataforseo.password');

        if (blank($login) || blank($password)) {
            $stored = (array) SiteSetting::getValue('dataforseo', []);
            $login = $stored['login'] ?? null;
            $password = SettingSecret::reveal($stored['password'] ?? null);
        }

        return ['login' => $login ?: null, 'password' => $password ?: null];
    }

    public static function isConfigured(): bool
    {
        $c = static::credentials();

        return filled($c['login']) && filled($c['password']);
    }

    public static function monthlyBudget(): float
    {
        $stored = (array) SiteSetting::getValue('dataforseo', []);

        return (float) ($stored['monthly_budget'] ?? config('services.dataforseo.monthly_budget', 25));
    }

    public static function spentThisMonth(): float
    {
        return (float) DataForSeoRequest::query()
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('cost');
    }

    /**
     * POST către un endpoint „live”. $tasks = listă de task-uri (fiecare un array).
     * Întoarce `tasks` din răspuns (fiecare cu status_code, result etc.).
     *
     * @param  array<int,array<string,mixed>>  $tasks
     * @return array<int,array<string,mixed>>
     */
    public function post(string $endpoint, array $tasks, ?int $cacheDays = null): array
    {
        return $this->call('POST', $endpoint, $tasks, $cacheDays);
    }

    /** GET (ex. /v3/appendix/user_data — sold cont). Fără cache. */
    public function get(string $endpoint): array
    {
        return $this->call('GET', $endpoint, [], 0);
    }

    protected function call(string $method, string $endpoint, array $tasks, ?int $cacheDays): array
    {
        $endpoint = '/'.ltrim($endpoint, '/');
        $hash = hash('sha256', $method.$endpoint.json_encode($tasks));
        $cacheDays ??= (int) config('services.dataforseo.cache_days', 30);

        if ($cacheDays > 0) {
            $cached = DataForSeoRequest::query()
                ->where('endpoint', $endpoint)
                ->where('payload_hash', $hash)
                ->where('status', 'ok')
                ->where('created_at', '>=', now()->subDays($cacheDays))
                ->latest('id')
                ->first();

            if ($cached && ($decoded = $cached->decodedResponse())) {
                return $decoded['tasks'] ?? [];
            }
        }

        $creds = static::credentials();
        if (blank($creds['login']) || blank($creds['password'])) {
            throw new RuntimeException('DataForSEO nu e configurat (lipsesc DATAFORSEO_LOGIN / DATAFORSEO_PASSWORD).');
        }

        if ($method === 'POST' && static::spentThisMonth() >= static::monthlyBudget()) {
            throw new RuntimeException(sprintf(
                'Plafonul lunar DataForSEO (%.2f USD) a fost atins. Mărește-l din Setări site → DataForSEO.',
                static::monthlyBudget()
            ));
        }

        $log = new DataForSeoRequest([
            'endpoint' => $endpoint,
            'payload_hash' => $hash,
            'payload' => $tasks,
            'research_run_id' => $this->researchRunId,
        ]);

        try {
            $request = Http::withBasicAuth($creds['login'], $creds['password'])
                ->acceptJson()
                ->timeout(120)
                ->retry(2, 2000, throw: false);

            $response = $method === 'GET'
                ? $request->get(self::BASE_URL.$endpoint)
                : $request->post(self::BASE_URL.$endpoint, $tasks);

            $json = $response->json() ?? [];
            $log->fill([
                'http_status' => $response->status(),
                'api_status_code' => $json['status_code'] ?? null,
                'api_status_message' => mb_substr((string) ($json['status_message'] ?? ''), 0, 250),
                'cost' => (float) ($json['cost'] ?? 0),
                'response' => $response->body(),
                'status' => ($response->successful() && ($json['status_code'] ?? 0) === 20000) ? 'ok' : 'error',
            ])->save();

            if ($log->status !== 'ok') {
                throw new RuntimeException('DataForSEO: '.($json['status_message'] ?? 'HTTP '.$response->status()));
            }

            return $json['tasks'] ?? [];
        } catch (RuntimeException $e) {
            throw $e;
        } catch (Throwable $e) {
            $log->fill(['status' => 'error', 'api_status_message' => mb_substr($e->getMessage(), 0, 250)])->save();
            Log::error('DataForSEO request failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);

            throw new RuntimeException('DataForSEO indisponibil: '.$e->getMessage(), previous: $e);
        }
    }

    /**
     * Rezultatele (`result`) ale primului task reușit, sau [] dacă task-ul a eșuat.
     *
     * @param  array<int,array<string,mixed>>  $tasks
     */
    public static function firstResult(array $tasks): array
    {
        $task = $tasks[0] ?? [];
        if (($task['status_code'] ?? 0) !== 20000) {
            return [];
        }

        return $task['result'] ?? [];
    }
}
