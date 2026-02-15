<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Create necessary temp directories for Vercel's read-only filesystem
$tempDirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache'
];

foreach ($tempDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Create bootstrap cache files
if (!file_exists('/tmp/bootstrap/cache/packages.php')) {
    @file_put_contents('/tmp/bootstrap/cache/packages.php', '<?php return [];');
}
if (!file_exists('/tmp/bootstrap/cache/services.php')) {
    @file_put_contents('/tmp/bootstrap/cache/services.php', '<?php return [];');
}

// Determine base path
$basePath = $_ENV['LAMBDA_TASK_ROOT'] ?? dirname(__DIR__);

// Check for maintenance mode
if (file_exists($maintenance = $basePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require $basePath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request
$app = require_once $basePath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
