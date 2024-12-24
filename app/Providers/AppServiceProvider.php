<?php

namespace LinaPhp\Lina\Providers;

use LinaPhp\Lina\ContentFinder;
use LinaPhp\Lina\Contracts\MarkdownParser as MarkdownParserContract;
use LinaPhp\Lina\Contracts\Router;
use LinaPhp\Lina\MarkdownParser;
use LinaPhp\Lina\MarkdownRenderer;
use Illuminate\Console\Signals;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MarkdownParserContract::class, MarkdownParser::class);

        $this->app->singleton(Router::class, function ($app) {
            return new \LinaPhp\Lina\Router(
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
        config(['view.compiled' => getcwd() . '/composer/.lina/cache']);
    }
}
