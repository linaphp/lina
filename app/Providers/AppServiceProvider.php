<?php

namespace BangNokia\Lina\Providers;

use BangNokia\Lina\ContentFinder;
use BangNokia\Lina\Contracts\MarkdownParser as MarkdownParserContract;
use BangNokia\Lina\Contracts\Router;
use BangNokia\Lina\MarkdownParser;
use BangNokia\Lina\MarkdownRenderer;
use Illuminate\Console\Signals;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\SignalRegistry\SignalRegistry;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MarkdownParserContract::class, MarkdownParser::class);

        $this->app->singleton(Router::class, function ($app) {
            return new \BangNokia\Lina\Router(
                new ContentFinder(getcwd())
            );
        });

        $this->app->singleton(MarkdownRenderer::class, function ($app) {
            return new MarkdownRenderer(getcwd());
        });

        Signals::resolveAvailabilityUsing(function () {
            return $this->app->runningInConsole() && !$this->app->runningUnitTests() && extension_loaded('pcntl');
        });
    }

    public function boot()
    {
        config(['view.paths' => [getcwd() . '/resources/views']]);
        config(['view.compiled' => getcwd() . '/resources/cache']);
    }
}
