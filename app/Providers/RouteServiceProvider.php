<?php

namespace BangNokia\Pekyll\Providers;

use BangNokia\Pekyll\ContentFinder;
use BangNokia\Pekyll\Contracts\Renderer;
use BangNokia\Pekyll\Contracts\Router;
use BangNokia\Pekyll\MarkdownParser;
use BangNokia\Pekyll\MarkdownRenderer;
use BangNokia\Pekyll\Parser;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Router::class, function ($app) {
            return new \BangNokia\Pekyll\Router($app, $app->make(ContentFinder::class));
        });
    }

    public function boot()
    {
        config(['view.paths' => [getcwd().'/resources/views']]);
        config(['view.compiled' => getcwd().'/resources/cache']);
    }
}
