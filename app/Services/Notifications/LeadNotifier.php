<?php

namespace App\Services\Notifications;

use App\Models\Lead;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\Provider;
use App\Models\SiteSetting;
use App\Services\Sms\SmsoClient;
use App\Support\SettingSecret;
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
            $this->sendEmail('lead.provider_email', $email, $vars, $lead->id, [
                'kicker' => 'Cerere alocată',
                'title' => 'Ai o cerere nouă de la '.$this->brand(),
                'reference' => $lead->reference,
                'rows' => $this->leadRows($lead, true),
                'buttons' => array_values(array_filter([
                    ['Vezi cererea în portal', $this->url('/portal/leads/'.$lead->id), true],
                    $this->telButton($lead->phone, 'Sună clientul'),
                ])),
                'note' => 'Te rugăm să confirmi în portal dacă preiei lucrarea și să contactezi clientul cât mai curând.',
            ]);
        }
    }

    public const DEFAULT_ADMIN_EMAIL = 'vornicugabi96@gmail.com';

    public ?string $lastError = null;

    /** Email de test din admin (Setări site): un exemplu de „cerere nouă”, cu date fictive. Întoarce adresele la care a plecat. */
    public function sendTestEmail(): array
    {
        $lead = new Lead([
            'reference' => 'TEST-'.now()->format('His'),
            'customer_name' => 'Ion Popescu (exemplu)',
            'phone' => '0722 000 000',
            'email' => 'client@example.com',
            'vehicle_brand' => 'Dacia', 'vehicle_model' => 'Duster', 'vehicle_year' => '2021',
            'glass_type' => 'parbriz', 'glass_features' => ['senzor_ploaie', 'camera_adas'],
            'address_text' => 'Str. Exemplu 1, Brașov', 'service_location_type' => 'domiciliu',
            'description' => 'Fisură de aproximativ 20 cm, pornită de la o ciobitură.',
            'urgency' => true,
        ]);
        $lead->created_at = now();

        $sent = [];
        foreach (self::adminRecipients() as $to) {
            if ($this->sendEmail('lead.admin_email', $to, $this->vars($lead), null, [
                'kicker' => 'Email de test',
                'title' => 'Așa arată notificarea pentru o cerere nouă',
                'reference' => $lead->reference,
                'rows' => $this->leadRows($lead, true),
                'buttons' => array_values(array_filter([
                    ['Deschide adminul', $this->url('/admin/leads'), true],
                    $this->telButton($lead->phone, 'Sună clientul'),
                    $this->whatsappButton($lead->phone),
                ])),
                'note' => 'Acesta este un mesaj de test trimis din admin → Setări site. Datele sunt fictive.',
            ])) {
                $sent[] = $to;
            }
        }

        return $sent;
    }

    /** @return string[] Adresele din admin → Setări site → Email → „Notificări cereri noi” (separate prin virgulă). */
    public static function adminRecipients(): array
    {
        $smtp = (array) SiteSetting::getValue('smtp', []);
        $raw = (string) ($smtp['admin_notify_to'] ?? '');
        $list = array_values(array_filter(array_map('trim', preg_split('/[,;\s]+/', $raw)), fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL)));

        return $list ?: [self::DEFAULT_ADMIN_EMAIL];
    }

    public function notifyAdminNewLead(Lead $lead): void
    {
        $buttons = array_values(array_filter([
            ['Deschide cererea în admin', $this->url('/admin/leads/'.$lead->id.'/edit'), true],
            $this->telButton($lead->phone, 'Sună clientul'),
            $this->whatsappButton($lead->phone),
            $lead->email ? ['Scrie clientului', 'mailto:'.$lead->email.'?subject='.rawurlencode('Cererea '.$lead->reference.' – '.$this->brand()), false] : null,
        ]));

        foreach (self::adminRecipients() as $to) {
            $this->sendEmail('lead.admin_email', $to, $this->vars($lead), $lead->id, [
                'kicker' => $lead->urgency ? 'Cerere nouă · urgentă' : 'Cerere nouă',
                'title' => 'Cerere nouă de la '.($lead->customer_name ?: 'un client'),
                'reference' => $lead->reference,
                'rows' => $this->leadRows($lead, true),
                'buttons' => $buttons,
                'note' => 'Primită '.optional($lead->created_at)->timezone('Europe/Bucharest')?->format('d.m.Y, H:i').($lead->landing_path ? ' · din pagina '.$lead->landing_path : ''),
            ]);
        }
    }

    public function notifyCustomerReceived(Lead $lead): void
    {
        if ($lead->phone) {
            $this->sendSms('lead.customer_sms', $lead->phone, $this->vars($lead), $lead->id);
        }

        if ($lead->email) {
            $phone = \App\Support\Company::display()['phone'] ?? '';
            $this->sendEmail('lead.customer_email', $lead->email, $this->vars($lead), $lead->id, [
                'kicker' => 'Cerere primită',
                'title' => 'Mulțumim, '.(trim(strtok((string) $lead->customer_name, ' ')) ?: 'am primit cererea').'!',
                'reference' => $lead->reference,
                'rows' => $this->leadRows($lead, false),
                'buttons' => array_values(array_filter([
                    ['Vezi cum funcționează', $this->url('/#cum-functioneaza'), true],
                    $phone ? $this->telButton($phone, 'Sună-ne') : null,
                    ['Ghiduri despre parbrize', $this->url('/blog'), false],
                ])),
                'note' => 'Ce urmează: verificăm sticla potrivită mașinii tale și îți confirmăm disponibilitatea unui atelier partener din zona ta, apoi primești oferta. Nu ai nicio obligație să o accepți.',
            ]);
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
        $body = $this->render($tpl?->body ?? 'Cerere {reference} — inlocuireparbriz.ro', $vars);

        $client = new SmsoClient((string) SettingSecret::reveal($smso['api_key'] ?? ''));
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
    protected function sendEmail(string $templateKey, string $to, array $vars, ?int $leadId, array $layout = []): bool
    {
        $smtp = (array) SiteSetting::getValue('smtp', []);
        if (! ($smtp['enabled'] ?? false)) {
            $this->log('email', $templateKey, $to, 'skipped', ['reason' => 'disabled'], $leadId);
            $this->lastError = 'Trimiterea de email este dezactivată (Setări site → Email).';

            return false;
        }

        $tpl = NotificationTemplate::query()->where('key', $templateKey)->where('is_active', true)->first();
        $subject = $this->render($tpl?->subject ?? ($layout['title'] ?? 'Notificare').' – {reference}', $vars);
        $body = $this->render($tpl?->body ?? '', $vars);
        $html = view('emails.notification', array_merge([
            'title' => $subject,
            'preheader' => $subject,
            'intro' => $body,
            'rows' => [],
            'buttons' => [],
            'note' => null,
            'reference' => $vars['reference'] ?? null,
        ], $layout, ['intro' => $body]))->render();
        $text = trim($body."\n\n".collect($layout['rows'] ?? [])->map(fn ($r) => $r[0].': '.$r[1])->implode("\n")
            ."\n\n".collect($layout['buttons'] ?? [])->map(fn ($b) => $b[0].': '.$b[1])->implode("\n"));

        try {
            // Folosim serverul SMTP configurat în admin (Setări site), nu cel din .env.
            config(['mail.mailers.site_smtp' => [
                'transport' => 'smtp',
                'host' => $smtp['host'] ?? null,
                'port' => (int) ($smtp['port'] ?? 465),
                'username' => $smtp['username'] ?? null,
                'password' => SettingSecret::reveal($smtp['password'] ?? null),
                'scheme' => ($smtp['encryption'] ?? '') === 'ssl' ? 'smtps' : null,
                'timeout' => 20,
            ]]);
            $mailer = filled($smtp['host'] ?? null) ? Mail::mailer('site_smtp') : Mail::mailer();

            $mailer->html($html, function ($message) use ($to, $subject, $smtp, $text) {
                $message->to($to)->subject($subject);
                $message->getSymfonyMessage()->text($text);
                if (! empty($smtp['from_address'])) {
                    $message->from($smtp['from_address'], $smtp['from_name'] ?? 'inlocuireparbriz.ro');
                }
            });
            $this->log('email', $templateKey, $to, 'sent', [], $leadId);

            return true;
        } catch (\Throwable $e) {
            Log::warning('Email send failed', ['error' => $e->getMessage()]);
            $this->log('email', $templateKey, $to, 'failed', ['error' => $e->getMessage()], $leadId);
            $this->lastError = $e->getMessage();

            return false;
        }
    }

    protected function brand(): string
    {
        return (string) (\App\Support\Company::display()['brand'] ?? 'inlocuireparbriz.ro');
    }

    protected function url(string $path): string
    {
        return rtrim((string) config('inlocuireparbriz.canonical_url', config('app.url')), '/').'/'.ltrim($path, '/');
    }

    protected function telButton(?string $phone, string $label): ?array
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            $digits = '40'.substr($digits, 1);
        }

        return [$label, 'tel:+'.$digits, false];
    }

    protected function whatsappButton(?string $phone): ?array
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            $digits = '40'.substr($digits, 1);
        }

        return ['WhatsApp', 'https://wa.me/'.$digits, false];
    }

    /** @return array<int,array{0:string,1:string}> Detaliile cererii, doar câmpurile completate. */
    protected function leadRows(Lead $lead, bool $withContact): array
    {
        $glassTypes = (array) config('inlocuireparbriz.glass_types', []);
        $features = (array) config('inlocuireparbriz.glass_features', []);
        $locations = (array) config('inlocuireparbriz.location_types', []);
        $label = fn ($map, $key) => is_array($map[$key] ?? null) ? ($map[$key]['label'] ?? $key) : ($map[$key] ?? $key);

        $rows = [];
        if ($withContact) {
            $rows[] = ['Client', (string) $lead->customer_name];
            $rows[] = ['Telefon', (string) $lead->phone];
            $rows[] = ['Email', (string) ($lead->email ?? '')];
        }
        $rows[] = ['Serviciu', (string) optional($lead->category)->name];
        $rows[] = ['Mașina', trim(($lead->vehicle_brand ?? '').' '.($lead->vehicle_model ?? '').' '.($lead->vehicle_year ?? ''))];
        $rows[] = ['Serie șasiu (VIN)', (string) ($lead->vehicle_vin ?? '')];
        $rows[] = ['Geam', $lead->glass_type ? (string) $label($glassTypes, $lead->glass_type) : ''];
        $rows[] = ['Dotări', implode(', ', array_map(fn ($f) => $f === 'nu_stiu' ? 'nu știe' : (string) $label($features, $f), (array) $lead->glass_features))];
        $rows[] = ['Localitate', trim(implode(', ', array_filter([optional($lead->city)->name, optional($lead->sector)->name])))];
        $rows[] = ['Adresă', (string) ($lead->address_text ?? '')];
        $rows[] = ['Loc montaj', $lead->service_location_type ? (string) $label($locations, $lead->service_location_type) : ''];
        $rows[] = ['Dată preferată', trim(optional($lead->preferred_date)->format('d.m.Y').' '.($lead->preferred_time ?? ''))];
        $rows[] = ['CASCO', $lead->insurance_casco ? 'da' : ''];
        $rows[] = ['Urgent', $lead->urgency ? 'da' : ''];
        $rows[] = ['Mesaj', (string) ($lead->description ?? '')];

        return array_values(array_filter($rows, fn ($r) => trim($r[1]) !== ''));
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
