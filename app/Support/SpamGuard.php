<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Antispam pentru formularul de cerere (fără să-l încurce pe omul real):
 *  1. capcane invizibile (honeypot) — boții completează toate câmpurile;
 *  2. timp minim de completare (token criptat cu ora afișării formularului);
 *  3. token setat din JavaScript (boții simpli nu rulează JS);
 *  4. conținut: linkuri, alfabete străine, nume cu cifre;
 *  5. telefon românesc valid (fără 0700000000, 0712345678 etc.);
 *  6. limită de cereri pe IP și pe telefon, plus duplicate în 30 de minute;
 *  7. opțional: Cloudflare Turnstile (cheile se pun în admin → Setări site → Antispam).
 *
 * check() întoarce null (OK), 'silent:<motiv>' (bot — arătăm „mulțumim”, dar nu salvăm)
 * sau 'error:<câmp>|<mesaj>' (om care a greșit — arătăm eroarea).
 */
final class SpamGuard
{
    public const MIN_SECONDS = 4;

    public const MAX_AGE_SECONDS = 172800; // 2 zile

    public static function token(): string
    {
        return Crypt::encryptString((string) time());
    }

    public static function settings(): array
    {
        try {
            return (array) SiteSetting::getValue('antispam', []);
        } catch (Throwable) {
            return [];
        }
    }

    public static function turnstileSiteKey(): ?string
    {
        $s = self::settings();

        return ! empty($s['turnstile_enabled']) && filled($s['turnstile_site_key'] ?? null) ? (string) $s['turnstile_site_key'] : null;
    }

    public static function normalizePhone(string $phone): ?string
    {
        $d = preg_replace('/\D+/', '', $phone);
        if (str_starts_with($d, '0040')) {
            $d = '0'.substr($d, 4);
        } elseif (str_starts_with($d, '40') && strlen($d) === 11) {
            $d = '0'.substr($d, 2);
        }

        return preg_match('/^0[237]\d{8}$/', $d) ? $d : null;
    }

    public static function isFakePhone(string $normalized): bool
    {
        $rest = substr($normalized, 2);

        return (bool) preg_match('/^(\d)\1{7}$/', $rest)                 // 0700000000, 0711111111
            || str_contains('0123456789012345678', $rest)               // 0712345678
            || str_contains('9876543210987654321', $rest)
            || preg_match('/^(\d\d)\1{3}$/', $rest);                     // 0712121212
    }

    public static function check(Request $request): ?string
    {
        // 1. honeypot
        foreach (['website', 'company_site', 'fax'] as $trap) {
            if (filled($request->input($trap))) {
                return 'silent:honeypot';
            }
        }

        // 2. timp de completare
        try {
            $shownAt = (int) Crypt::decryptString((string) $request->input('_ft'));
        } catch (Throwable) {
            return 'silent:token-lipsa';
        }
        $elapsed = time() - $shownAt;
        if ($elapsed < self::MIN_SECONDS) {
            return 'silent:prea-rapid';
        }
        if ($elapsed > self::MAX_AGE_SECONDS) {
            return 'error:description|Formularul a stat deschis prea mult. Reîncarcă pagina și trimite din nou.';
        }

        // 3. JavaScript
        if ($request->input('_js') !== 'ok-'.substr(hash('sha256', (string) $request->input('_ft')), 0, 12)) {
            return 'silent:fara-js';
        }

        // 4. conținut
        $name = (string) $request->input('name');
        $text = $name.' '.$request->input('description').' '.$request->input('vehicle_brand').' '.$request->input('vehicle_model').' '.$request->input('locality');
        if (preg_match('~(https?://|www\.|\[url|<a\s|\.(com|net|ru|xyz|top|info|biz|online|site|shop)\b)~i', $text)) {
            return 'silent:link';
        }
        if (preg_match('/[\p{Cyrillic}\p{Han}\p{Arabic}\p{Hangul}\p{Thai}]/u', $text)) {
            return 'silent:alfabet';
        }
        if (preg_match('/\d/', $name) || mb_strlen($name) > 60) {
            return 'error:name|Te rugăm să scrii un nume real (fără cifre).';
        }

        // 5. telefon
        $phone = self::normalizePhone((string) $request->input('phone'));
        if (! $phone) {
            return 'error:phone|Scrie un număr de telefon românesc valid, de ex. 0722 123 456.';
        }
        if (self::isFakePhone($phone)) {
            return 'error:phone|Numărul de telefon nu pare real. Te rugăm să verifici.';
        }

        // 6. limite
        $ip = hash('sha256', $request->ip().'|'.config('app.key'));
        if (self::hit('ip:'.$ip, 3600) > 5) {
            return 'silent:limita-ip';
        }
        if (self::hit('phone:'.$phone, 86400) > 3) {
            return 'silent:limita-telefon';
        }

        // 7. Turnstile (opțional)
        $s = self::settings();
        if (! empty($s['turnstile_enabled']) && filled($s['turnstile_secret'] ?? null)) {
            try {
                $ok = Http::asForm()->timeout(6)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => SettingSecret::reveal($s['turnstile_secret']),
                    'response' => (string) $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ])->json('success');
                if (! $ok) {
                    return 'error:description|Verificarea anti-robot nu a reușit. Reîncearcă.';
                }
            } catch (Throwable $e) {
                Log::warning('Turnstile indisponibil', ['error' => $e->getMessage()]); // nu blocăm oamenii dacă pică serviciul
            }
        }

        return null;
    }

    /** Telefonul în format standard, după check(). */
    public static function phone(Request $request): string
    {
        return self::normalizePhone((string) $request->input('phone')) ?? (string) $request->input('phone');
    }

    private static function hit(string $key, int $ttl): int
    {
        $key = 'spam:'.$key;
        Cache::add($key, 0, $ttl);

        return (int) Cache::increment($key);
    }

    public static function record(string $reason, Request $request): void
    {
        Log::info('Cerere blocată (antispam)', ['motiv' => $reason, 'ip' => hash('sha256', $request->ip()), 'nume' => mb_substr((string) $request->input('name'), 0, 40)]);
        $key = 'spam:stats:'.now()->format('Y-m-d');
        Cache::add($key, [], 86400 * 35);
        $stats = (array) Cache::get($key, []);
        $stats[$reason] = ($stats[$reason] ?? 0) + 1;
        Cache::put($key, $stats, 86400 * 35);
    }

    /** Blocări pe ultimele N zile, pentru admin. @return array<string,array<string,int>> */
    public static function stats(int $days = 14): array
    {
        $out = [];
        foreach (range(0, $days - 1) as $i) {
            $d = now()->subDays($i)->format('Y-m-d');
            $s = (array) Cache::get('spam:stats:'.$d, []);
            if ($s) {
                $out[$d] = $s;
            }
        }

        return $out;
    }
}
