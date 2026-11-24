<?php

namespace App\Filament\Admin\Pages;

use App\Console\Commands\PostDeploy;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * Întreținere: versiunea publicată, starea migrărilor, rulare manuală (doar super admin).
 * Înlocuiește scripturile „one-shot” cu token din public/ — totul trece prin login-ul de admin.
 */
class Maintenance extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Întreținere';

    protected static ?string $title = 'Întreținere';

    protected static ?string $slug = 'intretinere';

    protected string $view = 'filament.admin.pages.maintenance';

    public function getViewData(): array
    {
        try {
            Artisan::call('migrate:status', ['--pending' => true, '--no-ansi' => true]);
            $pending = trim(Artisan::output());
        } catch (Throwable $e) {
            $pending = 'Nu pot citi starea: '.$e->getMessage();
        }

        return [
            'head' => PostDeploy::currentHead(),
            'lastRun' => Cache::get('deploy:last_run'),
            'heartbeat' => Cache::get('scheduler:heartbeat'),
            'pending' => $pending,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('migrate')
                ->label('Rulează migrările acum')
                ->icon(Heroicon::OutlinedCircleStack)
                ->requiresConfirmation()
                ->modalDescription('Aplică modificările de structură a bazei de date din ultima versiune publicată. Migrările proiectului sunt doar aditive (nu șterg date).')
                ->action(function () {
                    try {
                        Artisan::call('app:post-deploy', ['--force' => true]);
                        Notification::make()->title('Migrări rulate')->body(mb_substr(trim(Artisan::output()), 0, 500))->success()->send();
                    } catch (Throwable $e) {
                        Notification::make()->title('Eroare la migrare')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }
}
