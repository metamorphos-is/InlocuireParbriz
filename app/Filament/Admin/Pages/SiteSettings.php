<?php

namespace App\Filament\Admin\Pages;

use App\Models\SiteSetting;
use App\Support\Company;
use App\Support\SettingSecret;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * Setări site (brand, SMTP, SMSO, SEO). Stocate în site_settings (key => JSON).
 * Parola SMTP și cheia SMSO sunt mascate în formular și criptate la salvare;
 * lăsate goale = se păstrează valoarea existentă.
 */
class SiteSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Setări site';

    protected static ?string $title = 'Setări site';

    protected static ?string $slug = 'setari-site';

    protected string $view = 'filament.admin.pages.site-settings';

    /** @var array<string,mixed> */
    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('testEmail')
                ->label('Trimite email de test')
                ->icon(\Filament\Support\Icons\Heroicon::OutlinedEnvelope)
                ->modalDescription('Trimite un exemplu de notificare „cerere nouă” (date fictive) la adresele de notificare salvate. Salvează întâi setările, dacă le-ai modificat.')
                ->action(function () {
                    $notifier = app(\App\Services\Notifications\LeadNotifier::class);
                    $sent = $notifier->sendTestEmail();
                    $sent
                        ? Notification::make()->title('Email trimis la '.implode(', ', $sent))->success()->send()
                        : Notification::make()->title('Emailul nu a plecat')->body($notifier->lastError ?: 'Verifică setările SMTP.')->danger()->send();
                }),
        ];
    }

    public function mount(): void
    {
        $brand = (array) SiteSetting::getValue('brand', []);
        $smtp = (array) SiteSetting::getValue('smtp', []);
        $smso = (array) SiteSetting::getValue('smso', []);
        $seo = (array) SiteSetting::getValue('seo', []);
        $dfs = (array) SiteSetting::getValue('dataforseo', []);

        $this->form->fill([
            'company' => Company::all(),
            'brand' => [
                'name' => $brand['name'] ?? 'inlocuireparbriz.ro',
                'tagline' => $brand['tagline'] ?? '',
                'team' => $brand['team'] ?? '',
            ],
            'smtp' => [
                'enabled' => (bool) ($smtp['enabled'] ?? false),
                'host' => $smtp['host'] ?? '',
                'port' => $smtp['port'] ?? 465,
                'username' => $smtp['username'] ?? '',
                'password' => '', // mascat: nu se afișează niciodată
                'encryption' => $smtp['encryption'] ?? 'ssl',
                'from_address' => $smtp['from_address'] ?? '',
                'from_name' => $smtp['from_name'] ?? 'inlocuireparbriz.ro',
                'admin_notify_to' => $smtp['admin_notify_to'] ?? \App\Services\Notifications\LeadNotifier::DEFAULT_ADMIN_EMAIL,
            ],
            'smso' => [
                'enabled' => (bool) ($smso['enabled'] ?? false),
                'api_key' => '', // mascat
                'sender' => $smso['sender'] ?? '',
            ],
            'seo' => [
                'noindex' => (bool) ($seo['noindex'] ?? true),
                'google_verification' => $seo['google_verification'] ?? '',
            ],
            'dataforseo' => [
                'login' => $dfs['login'] ?? '',
                'password' => '', // mascat
                'monthly_budget' => $dfs['monthly_budget'] ?? config('services.dataforseo.monthly_budget', 25),
            ],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        $smtp = (array) SiteSetting::getValue('smtp', []);
        $smso = (array) SiteSetting::getValue('smso', []);
        $dfs = (array) SiteSetting::getValue('dataforseo', []);

        return $schema
            ->components([
                Section::make('Date firmă (afișate pe site)')
                    ->description('Apar în footer, pe pagina Contact și în datele structurate (Schema.org). Câmpurile goale nu se afișează.')
                    ->columns(3)
                    ->schema([
                        Toggle::make('company.is_test')
                            ->label('Date de test (nu se publică în Schema.org)')
                            ->helperText('Dezactivează după ce completezi datele reale.')
                            ->columnSpanFull(),
                        TextInput::make('company.brand')->label('Nume comercial')->maxLength(120),
                        TextInput::make('company.legal_name')->label('Denumire firmă')->maxLength(160),
                        TextInput::make('company.cui')->label('CUI / CIF')->maxLength(20),
                        TextInput::make('company.reg_com')->label('Nr. Registrul Comerțului')->maxLength(40),
                        TextInput::make('company.phone')->label('Telefon')->tel()->maxLength(30),
                        TextInput::make('company.whatsapp')->label('WhatsApp (opțional)')->tel()->maxLength(30),
                        TextInput::make('company.email')->label('Email contact')->email()->maxLength(190),
                        TextInput::make('company.address')->label('Adresă / sediu')->maxLength(255),
                        TextInput::make('company.hours')->label('Program')->maxLength(120),
                    ]),
                Section::make('Brand')
                    ->columns(3)
                    ->schema([
                        TextInput::make('brand.name')->label('Nume brand')->required()->maxLength(120),
                        TextInput::make('brand.team')->label('Nume echipă')->maxLength(120),
                        TextInput::make('brand.tagline')->label('Slogan')->maxLength(255),
                    ]),
                Section::make('Email (SMTP)')
                    ->columns(2)
                    ->schema([
                        Toggle::make('smtp.enabled')->label('Trimitere email activă')->columnSpanFull(),
                        TextInput::make('smtp.admin_notify_to')
                            ->label('Email pentru notificări „cerere nouă”')
                            ->helperText('Aici primești fiecare cerere nouă. Poți pune mai multe adrese, separate prin virgulă.')
                            ->placeholder(\App\Services\Notifications\LeadNotifier::DEFAULT_ADMIN_EMAIL)
                            ->rule(fn () => function (string $attribute, $value, \Closure $fail) {
                                foreach (array_filter(array_map('trim', preg_split('/[,;\s]+/', (string) $value))) as $e) {
                                    if (! filter_var($e, FILTER_VALIDATE_EMAIL)) {
                                        $fail("„{$e}” nu este o adresă de email validă.");
                                    }
                                }
                            })
                            ->columnSpanFull(),
                        TextInput::make('smtp.host')->label('Server SMTP (host)')->maxLength(255),
                        TextInput::make('smtp.port')->label('Port')->numeric()->minValue(1)->maxValue(65535),
                        TextInput::make('smtp.username')->label('Utilizator')->maxLength(255)->autocomplete(false),
                        TextInput::make('smtp.password')
                            ->label('Parolă')
                            ->password()
                            ->autocomplete('new-password')
                            ->helperText(SettingSecret::isSet($smtp['password'] ?? null)
                                ? 'Parolă salvată (mascată). Lasă gol pentru a o păstra.'
                                : 'Nicio parolă salvată.'),
                        Select::make('smtp.encryption')
                            ->label('Criptare')
                            ->options(['ssl' => 'SSL', 'tls' => 'TLS', '' => 'Fără']),
                        TextInput::make('smtp.from_address')->label('Expeditor (email)')->email()->maxLength(255),
                        TextInput::make('smtp.from_name')->label('Expeditor (nume)')->maxLength(255),
                    ]),
                Section::make('SMS (SMSO)')
                    ->columns(2)
                    ->schema([
                        Toggle::make('smso.enabled')->label('Trimitere SMS activă')->columnSpanFull(),
                        TextInput::make('smso.api_key')
                            ->label('Cheie API SMSO')
                            ->password()
                            ->autocomplete('new-password')
                            ->helperText(SettingSecret::isSet($smso['api_key'] ?? null)
                                ? 'Cheie salvată (mascată). Lasă gol pentru a o păstra.'
                                : 'Nicio cheie salvată.'),
                        TextInput::make('smso.sender')->label('Expeditor SMS')->maxLength(30),
                    ]),
                Section::make('SEO')
                    ->schema([
                        Toggle::make('seo.noindex')
                            ->label('Blochează indexarea (noindex) pe tot site-ul')
                            ->helperText('Activ = Google nu indexează site-ul. Oprit = site lansat (meta robots, X-Robots-Tag și robots.txt se schimbă automat).'),
                        TextInput::make('seo.google_verification')
                            ->label('Cod verificare Google Search Console (opțional)')
                            ->helperText('Doar dacă verifici proprietatea prin „Etichetă HTML”: lipește meta tag-ul sau doar codul din content="…". Pentru proprietate de tip Domeniu se folosește DNS.')
                            ->maxLength(300),
                    ]),
                Section::make('DataForSEO')
                    ->description(filled(config('services.dataforseo.login'))
                        ? 'Credențialele sunt deja setate în .env pe server (au prioritate față de câmpurile de mai jos).'
                        : 'Alternativă la .env: credențialele se salvează criptat în baza de date.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('dataforseo.login')->label('Login API')->maxLength(190)->autocomplete(false),
                        TextInput::make('dataforseo.password')
                            ->label('Parolă API')
                            ->password()
                            ->autocomplete('new-password')
                            ->helperText(SettingSecret::isSet($dfs['password'] ?? null)
                                ? 'Parolă salvată (mascată). Lasă gol pentru a o păstra.'
                                : 'Nicio parolă salvată.'),
                        TextInput::make('dataforseo.monthly_budget')->label('Plafon lunar (USD)')->numeric()->minValue(1)->maxValue(1000),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $oldSmtp = (array) SiteSetting::getValue('smtp', []);
        $oldSmso = (array) SiteSetting::getValue('smso', []);
        $oldSeo = (array) SiteSetting::getValue('seo', []);
        $oldBrand = (array) SiteSetting::getValue('brand', []);
        $oldDfs = (array) SiteSetting::getValue('dataforseo', []);

        $smtp = $state['smtp'];
        $smtp['password'] = filled($smtp['password'] ?? null)
            ? SettingSecret::protect($smtp['password'])
            : ($oldSmtp['password'] ?? '');

        $smso = $state['smso'];
        $smso['api_key'] = filled($smso['api_key'] ?? null)
            ? SettingSecret::protect($smso['api_key'])
            : ($oldSmso['api_key'] ?? '');

        $dfs = $state['dataforseo'] ?? [];
        $dfs['password'] = filled($dfs['password'] ?? null)
            ? SettingSecret::protect($dfs['password'])
            : ($oldDfs['password'] ?? '');
        SiteSetting::setValue('dataforseo', array_merge($oldDfs, $dfs));

        SiteSetting::setValue('company', array_merge(Company::DEFAULTS, $state['company'] ?? [], [
            'is_test' => (bool) ($state['company']['is_test'] ?? false),
        ]));

        SiteSetting::setValue('brand', array_merge($oldBrand, $state['brand']));
        SiteSetting::setValue('smtp', array_merge($oldSmtp, $smtp));
        SiteSetting::setValue('smso', array_merge($oldSmso, $smso));
        SiteSetting::setValue('seo', array_merge($oldSeo, [
            'noindex' => (bool) $state['seo']['noindex'],
            'default_robots' => $state['seo']['noindex'] ? 'noindex,nofollow' : 'index,follow',
            'google_verification' => trim((string) ($state['seo']['google_verification'] ?? '')),
        ]));

        // Resetează câmpurile mascate și reîncarcă mesajele de ajutor.
        $this->mount();

        Notification::make()->title('Setări salvate')->success()->send();
    }
}
