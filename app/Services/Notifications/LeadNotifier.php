<?php

namespace App\Services\Notifications;

use App\Models\Lead;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\Provider;
use App\Models\SiteSetting;
use App\Services\Sms\SmsoClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadNotifier
{
    public function notifyProviderAssigned(Lead $lead, Provider $provider): void
    {
        $phone = $provider->phone ?: optional($provider->user)->phone;
        $email = $provider->email ?: optional($provider->user)->email;

        $vars = $this->vars($lead, $provider);

        if ($phone) {
            $this->sendSms('lead.provider_sms', $phone, $vars, $lead->id);
        }

        if ($email) {
            $this->sendEmail('lead.provider_email', $email, $vars, $lead->id);
        }
    }

    public function notifyAdminNewLead(Lead $lead): void
    {
        $smtp = (array) SiteSetting::getValue('smtp', []);
        $to = $smtp['admin_notify_to'] ?? $smtp['from_address'] ?? null;
        if (! $to) {
            return;
        }

        $this->sendEmail('lead.admin_email', $to, $this->vars($lead), $lead->id);
    }

    public function notifyCustomerReceived(Lead $lead): void
    {
        if ($lead->phone) {
            $this->sendSms('lead.customer_sms', $lead->phone, $this->vars($lead), $lead->id);
        }
    }

    /** @param  array<string,string>  $vars */
    protected function sendSms(string $templateKey, string $to, array $vars, ?int $leadId): void
    {
        $smso = (array) SiteSetting::getValue('smso', []);
        if (! ($smso['enabled'] ?? false)) {
            $this->log('sms', $templateKey, $to, 'skipped', ['reason' => 'disabled'], $leadId);

            return;
        }

        $tpl = NotificationTemplate::query()->where('key', $templateKey)->where('is_active', true)->first();
        $body = $this->render($tpl?->body ?? 'Cerere {reference} — InlocuireParbriz.ro', $vars);

        $client = new SmsoClient((string) ($smso['api_key'] ?? ''));
        $sender = $smso['sender'] ?? '';
        $result = $client->send($to, $sender, $body, 'transactional');

        $this->log(
            'sms',
            $templateKey,
            $to,
            $result['ok'] ? 'sent' : 'failed',
            $result,
            $leadId
        );
    }

    /** @param  array<string,string>  $vars */
    protected function sendEmail(string $templateKey, string $to, array $vars, ?int $leadId): void
    {
        $smtp = (array) SiteSetting::getValue('smtp', []);
        if (! ($smtp['enabled'] ?? false)) {
            $this->log('email', $templateKey, $to, 'skipped', ['reason' => 'disabled'], $leadId);

            return;
        }

        $tpl = NotificationTemplate::query()->where('key', $templateKey)->where('is_active', true)->first();
        $subject = $this->render($tpl?->subject ?? 'Notificare {reference}', $vars);
        $body = $this->render($tpl?->body ?? 'Cerere {reference}', $vars);

        try {
            Mail::raw($body, function ($message) use ($to, $subject, $smtp) {
                $message->to($to)->subject($subject);
                if (! empty($smtp['from_address'])) {
                    $message->from($smtp['from_address'], $smtp['from_name'] ?? 'InlocuireParbriz');
                }
            });
            $this->log('email', $templateKey, $to, 'sent', [], $leadId);
        } catch (\Throwable $e) {
            Log::warning('Email send failed', ['error' => $e->getMessage()]);
            $this->log('email', $templateKey, $to, 'failed', ['error' => $e->getMessage()], $leadId);
        }
    }

    /** @param  array<string,string>  $vars */
    protected function render(string $template, array $vars): string
    {
        $out = $template;
        foreach ($vars as $key => $value) {
            $out = str_replace('{'.$key.'}', (string) $value, $out);
        }

        return $out;
    }

    /** @return array<string,string> */
    protected function vars(Lead $lead, ?Provider $provider = null): array
    {
        return [
            'reference' => (string) $lead->reference,
            'request_id' => (string) $lead->reference,
            'customer_name' => (string) $lead->customer_name,
            'customer_phone' => (string) $lead->phone,
            'customer_email' => (string) ($lead->email ?? ''),
            'vehicle_brand' => (string) ($lead->vehicle_brand ?? ''),
            'vehicle_model' => (string) ($lead->vehicle_model ?? ''),
            'vehicle_year' => (string) ($lead->vehicle_year ?? ''),
            'vehicle_vin' => (string) ($lead->vehicle_vin ?? ''),
            'glass_type' => (string) ($lead->glass_type ?? ''),
            'glass_features' => is_array($lead->glass_features ?? null) ? implode(', ', $lead->glass_features) : '',
            'service_type' => (string) optional($lead->category)->name,
            'city' => (string) optional($lead->city)->name,
            'sector' => (string) optional($lead->sector)->name,
            'address' => (string) ($lead->address_text ?? ''),
            'description' => (string) ($lead->description ?? ''),
            'preferred_date' => (string) ($lead->preferred_date ?? ''),
            'preferred_time' => (string) ($lead->preferred_time ?? ''),
            'urgency' => $lead->urgency ? 'urgent' : 'normal',
            'provider_name' => (string) ($provider?->company_name ?? $provider?->name ?? ''),
            'category' => (string) optional($lead->category)->name,
            'phone' => (string) $lead->phone,
        ];
    }

    /** @param  array<string,mixed>  $payload */
    protected function log(string $channel, string $templateKey, string $to, string $status, array $payload, ?int $leadId): void
    {
        try {
            NotificationLog::query()->create([
                'channel' => $channel,
                'template_key' => $templateKey,
                'recipient' => $to,
                'status' => $status,
                'payload' => array_merge($payload, ['lead_id' => $leadId]),
                'sent_at' => $status === 'sent' ? now() : null,
                'error' => is_string($payload['error'] ?? null) ? $payload['error'] : null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('notification_log_failed', ['error' => $e->getMessage()]);
        }
    }
}
