<?php

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

// Create bootstrap cache files for Laravel 11
$bootstrapFiles = [
    '/tmp/bootstrap/cache/packages.php' => '<?php return [];',
    '/tmp/bootstrap/cache/services.php' => '<?php return [];'
];

foreach ($bootstrapFiles as $file => $content) {
    if (!file_exists($file)) {
        @file_put_contents($file, $content);
    }
}

// Require the original Laravel entry point
require __DIR__ . '/../public/index.php';