<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Resolve paths for vendor/bootstrap/maintenance
|--------------------------------------------------------------------------
|
| This file is resilient: it first checks standard Laravel layout
| (../vendor, ../bootstrap, ../storage). If those don't exist — for
| example when public files were copied into public_html on Hostido —
| it falls back to the actual project location inside 'app/src/website-handicrafts'.
|
| Adjust the FALLBACK_PROJECT_SUBPATH if your repo root inside "app" is different.
|
*/

$standardBase = realpath(__DIR__ . '/..'); // e.g. /home/.../app/src/website-handicrafts/public/.. => src/website-handicrafts
$fallbackProjectSubpath = 'app/src/website-handicrafts'; // relative to parent of public_html (usually ../app/src/website-handicrafts)

/**
 * Try standard relative paths first.
 */
$maintenancePath = __DIR__ . '/../storage/framework/maintenance.php';
$vendorAutoloadPath = __DIR__ . '/../vendor/autoload.php';
$bootstrapAppPath = __DIR__ . '/../bootstrap/app.php';

/**
 * If the standard vendor/autoload does not exist (common when public copied to public_html),
 * compute fallback paths relative to public_html parent.
 */
if (!file_exists($vendorAutoloadPath)) {
    // parent of public_html, e.g. /home/host108162/domains/handmademalin.pl
    $parent = realpath(__DIR__ . '/..') ?: dirname(__DIR__);

    // fallback base: /home/.../domains/.../app/src/website-handicrafts
    $fallbackBase = $parent . DIRECTORY_SEPARATOR . $fallbackProjectSubpath;

    $vendorAutoloadPath = $fallbackBase . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
    $bootstrapAppPath = $fallbackBase . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'app.php';
    $maintenancePath = $fallbackBase . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Check maintenance mode
|--------------------------------------------------------------------------
*/
if (file_exists($maintenancePath)) {
    require $maintenancePath;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
if (! file_exists($vendorAutoloadPath)) {
    // fatal: vendor autoload not found — give explicit error with hint
    fwrite(STDERR, "Autoload file not found at: $vendorAutoloadPath\n");
    http_response_code(500);
    echo "Application error: vendor autoload not found. Contact administrator.";
    exit(1);
}
require $vendorAutoloadPath;

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
if (! file_exists($bootstrapAppPath)) {
    fwrite(STDERR, "Bootstrap file not found at: $bootstrapAppPath\n");
    http_response_code(500);
    echo "Application error: bootstrap file not found. Contact administrator.";
    exit(1);
}

/** @var Application $app */
$app = require_once $bootstrapAppPath;

$app->handleRequest(Request::capture());
