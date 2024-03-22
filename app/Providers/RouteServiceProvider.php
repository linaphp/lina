<?php

namespace BangNokia\Pekyll\Providers;

use BangNokia\Pekyll\ContentFinder;
use BangNokia\Pekyll\Contracts\Renderer;
use BangNokia\Pekyll\Contracts\Router;
use BangNokia\Pekyll\MarkdownRenderer;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Renderer::class, function () {
            return new MarkdownRenderer(getcwd() . '/content');
        });

        $this->app->singleton(Router::class, function ($app) {
            return new \BangNokia\Pekyll\Router($app, $app->make(ContentFinder::class), $app->make(Renderer::class));
        });
    }
}
