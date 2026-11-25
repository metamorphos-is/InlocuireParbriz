<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

/*
 * Hostinger: un singur cron rulează în fiecare minut
 *   /opt/alt/php83/usr/bin/php /home/u422988064/domains/inlocuireparbriz.ro/public_html/site/artisan schedule:run
 *
 * IMPORTANT: pe Hostinger `proc_open`/`exec` sunt dezactivate, deci NU folosim
 * Schedule::command() / runInBackground() (pornesc procese separate și eșuează).
 * Totul rulează în același proces, prin Schedule::call() + Artisan::call().
 */

// Semnal „cron activ” afișat în admin.
Schedule::call(fn () => Cache::put('scheduler:heartbeat', now()->toIso8601String(), now()->addMinutes(10)))
    ->everyMinute()
    ->name('scheduler-heartbeat');

// După fiecare deploy nou: migrări + curățare cache.
Schedule::call(fn () => Artisan::call('app:post-deploy'))
    ->everyMinute()
    ->name('post-deploy')
    ->withoutOverlapping(10);

// Coada (emailuri/SMS-uri).
Schedule::call(fn () => Artisan::call('queue:work', ['--stop-when-empty' => true, '--max-time' => 50, '--tries' => 3]))
    ->everyMinute()
    ->name('queue-work')
    ->withoutOverlapping(5);

// Cercetări DataForSEO cerute din admin (pot dura câteva minute).
Schedule::call(fn () => Artisan::call('seo:research', ['--pending' => true]))
    ->everyMinute()
    ->name('seo-research')
    ->withoutOverlapping(30);

// Publicare zilnică: o pagină/un articol nou pe zi din coada de publicare (admin → SEO & Conținut → Coadă de publicare).
// Rulează des între 9:00 și 20:00 (ora României), dar comanda publică cel mult un element pe zi.
Schedule::call(fn () => Artisan::call('content:publish-next'))
    ->everyFifteenMinutes()
    ->timezone('Europe/Bucharest')
    ->between('9:00', '20:00')
    ->name('content-publish-next')
    ->withoutOverlapping(10);
