<?php

use Illuminate\Support\Facades\Schedule;

/*
 * Hostinger: un singur cron rulează în fiecare minut
 *   php artisan schedule:run
 * Tot restul e definit aici (versionat în Git).
 */

// După fiecare deploy nou: migrări + curățare cache.
Schedule::command('app:post-deploy')->everyMinute()->withoutOverlapping(10);

// Coada (emailuri/SMS-uri).
Schedule::command('queue:work --stop-when-empty --max-time=55 --tries=3')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

// Cercetări DataForSEO cerute din admin.
Schedule::command('seo:research --pending')->everyMinute()->withoutOverlapping(30)->runInBackground();

// Semnal „cron activ” afișat în admin.
Schedule::call(fn () => \Illuminate\Support\Facades\Cache::put('scheduler:heartbeat', now()->toIso8601String(), now()->addMinutes(10)))
    ->everyMinute()
    ->name('scheduler-heartbeat');
