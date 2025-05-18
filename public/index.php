<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

// Správna cesta k maintenance módu
if (file_exists($maintenance = __DIR__.'/laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader
require __DIR__.'/laravel/vendor/autoload.php';

// Bootstrap Laravel a spusti request
$app = require_once __DIR__.'/laravel/bootstrap/app.php';

/** @var Application $app */
$app->handleRequest(Request::capture());
