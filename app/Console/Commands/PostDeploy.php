<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Rulat de scheduler în fiecare minut. Când detectează un commit nou (după deploy din Git),
 * rulează migrările (doar aditive, --force) și golește cache-urile de view/rute.
 * Înlocuiește vechile scripturi „one-shot” cu token din public/.
 */
class PostDeploy extends Command
{
    protected $signature = 'app:post-deploy {--force : Rulează chiar dacă commit-ul nu s-a schimbat}';

    protected $description = 'Migrări + curățare cache după un deploy nou';

    public function handle(): int
    {
        $head = $this->currentHead();
        $last = Cache::get('deploy:last_head');

        if (! $this->option('force') && $head !== null && $head === $last) {
            return self::SUCCESS;
        }

        Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = trim(Artisan::output());
        Artisan::call('optimize:clear');

        Cache::forever('deploy:last_head', $head);
        Cache::forever('deploy:last_run', [
            'head' => $head,
            'at' => now()->toIso8601String(),
            'migrate' => mb_substr($migrateOutput, 0, 4000),
        ]);

        Log::info('Post-deploy rulat', ['head' => $head]);
        $this->info("Post-deploy OK ({$head})");
        $this->line($migrateOutput);

        return self::SUCCESS;
    }

    public static function currentHead(): ?string
    {
        $git = base_path('.git');
        if (! is_file("{$git}/HEAD")) {
            return null;
        }
        $ref = trim((string) file_get_contents("{$git}/HEAD"));
        if (str_starts_with($ref, 'ref: ')) {
            $refFile = "{$git}/".substr($ref, 5);
            if (is_file($refFile)) {
                return trim((string) file_get_contents($refFile));
            }
            $packed = @file_get_contents("{$git}/packed-refs") ?: '';
            if (preg_match('/^([0-9a-f]{40}) '.preg_quote(substr($ref, 5), '/').'$/m', $packed, $m)) {
                return $m[1];
            }

            return null;
        }

        return $ref;
    }
}
