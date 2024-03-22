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
        $this->app->bind(Renderer::class, function ($app) {
            return new MarkdownRenderer(getcwd() . '/content', new Parser(new MarkdownParser()));
        });

        $this->app->singleton(Router::class, function ($app) {
            return new \BangNokia\Pekyll\Router($app, $app->make(ContentFinder::class), $app->make(Renderer::class));
        });
    }
}
