<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use App\Support\SettingSecret;
use Illuminate\Console\Command;

/**
 * Salvează credențialele DataForSEO criptat în site_settings (alternativă la .env).
 * Nu afișează parola în output.
 */
class SeoSetCredentials extends Command
{
    protected $signature = 'seo:set-credentials {login} {password} {--budget=25}';

    protected $description = 'Salvează criptat credențialele DataForSEO în baza de date';

    public function handle(): int
    {
        $old = (array) SiteSetting::getValue('dataforseo', []);
        SiteSetting::setValue('dataforseo', array_merge($old, [
            'login' => (string) $this->argument('login'),
            'password' => SettingSecret::protect((string) $this->argument('password')),
            'monthly_budget' => (float) $this->option('budget'),
        ]));

        $this->info('Credențiale DataForSEO salvate (criptat) pentru '.$this->argument('login'));

        return self::SUCCESS;
    }
}
