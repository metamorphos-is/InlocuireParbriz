<?php
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
define('LARAVEL_START', microtime(true));
$envPath = __DIR__.'/../.env';
$prod = __DIR__.'/../bootstrap/production-settings.php';
if (! is_file($envPath) && is_file($prod)) {
    $cfg = require $prod;
    $lines = [];
    foreach ($cfg as $k => $v) { $lines[] = $k.'='.$v; }
    file_put_contents($envPath, implode("\n", $lines)."\n");
}
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../vendor/autoload.php';
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->handleRequest(Request::capture());
