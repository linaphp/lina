<?php

use Illuminate\Support\Facades\Request;

if (file_exists(__DIR__.'/../../autoload.php')) {
    require __DIR__.'/../../autoload.php';
} else {
	require __DIR__.'/vendor/autoload.php';
}

/**
 * Bootstrap the Laravel zero application.
 */
$app = require_once __DIR__.'/bootstrap/app.php';

/** @var \Illuminate\Foundation\Http\Kernel $kernel */


$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);

