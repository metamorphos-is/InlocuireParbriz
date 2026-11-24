<?php

namespace App\Console\Commands;

use App\Models\SeoResearchRun;
use App\Services\DataForSeo\DataForSeoClient;
use App\Services\DataForSeo\ResearchRunner;
use Illuminate\Console\Command;

/**
 * Rulează cercetări DataForSEO pe server.
 *   php artisan seo:research --pending          (procesează rulările cerute din admin; rulat de scheduler)
 *   php artisan seo:research --plan=national    (pornește planul național complet)
 *   php artisan seo:research --run=12           (re-rulează o rulare anume)
 */
class SeoResearch extends Command
{
    protected $signature = 'seo:research {--pending} {--plan=} {--run=}';

    protected $description = 'Rulează cercetarea de cuvinte-cheie DataForSEO';

    public function handle(ResearchRunner $runner): int
    {
        if (! DataForSeoClient::isConfigured()) {
            if (! $this->option('pending')) {
                $this->error('DataForSEO nu e configurat (DATAFORSEO_LOGIN / DATAFORSEO_PASSWORD).');
            }

            return self::SUCCESS;
        }

        $runs = collect();

        if ($id = $this->option('run')) {
            $runs->push(SeoResearchRun::query()->findOrFail($id));
        } elseif ($plan = $this->option('plan')) {
            $runs->push(SeoResearchRun::query()->create(['type' => $plan === 'national' ? 'national_plan' : $plan, 'params' => []]));
        } elseif ($this->option('pending')) {
            $runs = SeoResearchRun::query()->where('status', 'pending')->oldest()->limit(3)->get();
        }

        foreach ($runs as $run) {
            $this->info("Rulez #{$run->id} ({$run->type})…");
            $run = $runner->run($run);
            $this->line("→ {$run->status}, cost {$run->cost} USD".($run->error ? ", eroare: {$run->error}" : ''));
        }

        return self::SUCCESS;
    }
}
