<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirecționări din admin (înainte de rutare), apoi noindex cât timp site-ul nu e lansat.
        $middleware->web(prepend: [
            \App\Http\Middleware\HandleRedirects::class,
        ], append: [
            \App\Http\Middleware\ForceNoIndex::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

// Pe Hostinger codul rulează din public_html/site/ (clone Git), iar .env-ul de
// producție stă un nivel mai sus, în public_html/. Dacă site/.env lipsește,
// folosim .env-ul din folderul părinte (secretul nu trebuie copiat sau pus în Git).
if (! is_file($app->basePath('.env')) && is_file(dirname($app->basePath()).'/.env')) {
    $app->useEnvironmentPath(dirname($app->basePath()));
}

return $app;
