<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Official SMSO API adapter — https://api-docs.smso.ro/
 * Auth: X-Authorization header. Sender must be numeric ID from GET /senders.
 */
class SmsoClient
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://app.smso.ro/api/v1',
    ) {}

    /**
     * @return array{ok:bool,status?:int,response_token?:string,transaction_cost?:float|int,body?:mixed,error?:string,http_status?:int}
     */
    public function send(string $to, string|int $senderId, string $body, string $type = 'transactional'): array
    {
        if ($this->apiKey === '') {
            return ['ok' => false, 'error' => 'missing_api_key'];
        }

        try {
            $response = Http::withHeaders([
                'X-Authorization' => $this->apiKey,
                'X-Source-App' => 'InlocuireParbriz/1.0',
            ])
                ->asForm()
                ->timeout(15)
                ->post(rtrim($this->baseUrl, '/').'/send', [
                    'to' => $to,
                    'sender' => (string) $senderId,
                    'body' => $body,
                    'type' => $type,
                    'remove_special_chars' => 1,
                ]);
        } catch (\Throwable $e) {
            Log::warning('SMSO request failed', ['message' => $e->getMessage()]);

            return ['ok' => false, 'error' => 'transport', 'http_status' => 0];
        }

        $json = $response->json();
        $http = $response->status();

        if ($response->successful() && is_array($json) && (int) ($json['status'] ?? 0) === 200) {
            return [
                'ok' => true,
                'status' => 200,
                'response_token' => $json['responseToken'] ?? null,
                'transaction_cost' => $json['transaction_cost'] ?? null,
                'body' => $json,
                'http_status' => $http,
            ];
        }

        return [
            'ok' => false,
            'error' => 'api_error',
            'http_status' => $http,
            'body' => $json,
        ];
    }

    /**
     * @return array{ok:bool,status?:string,body?:mixed,error?:string}
     */
    public function status(string $responseToken): array
    {
        try {
            $response = Http::timeout(10)->get(rtrim($this->baseUrl, '/').'/status', [
                'responseToken' => $responseToken,
            ]);
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => 'transport'];
        }

        return [
            'ok' => $response->successful(),
            'body' => $response->json(),
            'http_status' => $response->status(),
        ];
    }
}
