<?php

namespace BangNokia\Pekyll\Providers;

use BangNokia\Pekyll\Contracts\MarkdownParserInterface;
use BangNokia\Pekyll\Contracts\Router;
use BangNokia\Pekyll\MarkdownParser;
use Illuminate\Console\Signals;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MarkdownParserInterface::class, MarkdownParser::class);

        $this->app->singleton(Router::class, function ($app) {
            return new \BangNokia\Pekyll\Router($app);
        });

        Signals::resolveAvailabilityUsing(function () {
            return $this->app->runningInConsole() && !$this->app->runningUnitTests() && extension_loaded('pcntl');
        });
    }

    public function boot()
    {
        config(['view.paths' => [getcwd().'/resources/views']]);
        config(['view.compiled' => getcwd().'/resources/cache']);
    }
}
