<?php

use BangNokia\Pekyll\Providers\RouteServiceProvider;

if (file_exists(__DIR__.'/../../autoload.php')) {
    require __DIR__.'/../../autoload.php';
} else {
	require __DIR__.'/vendor/autoload.php';
}

/**
 * Bootstrap the Laravel zero application.
 */
$app = require_once __DIR__.'/bootstrap/app.php';

//$app->register(\BangNokia\Pekyll\Providers\ViewServiceProvider::class);
$app->register(\Illuminate\View\ViewServiceProvider::class);
$app->register(\BangNokia\Pekyll\Providers\RouteServiceProvider::class);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    BangNokia\Pekyll\HttpKernel::class,
);

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $httpKernel->handle(
    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals()
)->send();

$httpKernel->terminate($request, $response);

