<?php

namespace BangNokia\Pekyll\Providers;

use BangNokia\Pekyll\ContentFinder;
use BangNokia\Pekyll\Contracts\Renderer;
use BangNokia\Pekyll\Contracts\Router;
use BangNokia\Pekyll\HttpKernel;
use BangNokia\Pekyll\MarkdownParser;
use BangNokia\Pekyll\MarkdownParserInterface;
use BangNokia\Pekyll\MarkdownRenderer;
use Illuminate\Console\Signals;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Command\SignalableCommandInterface;

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

        Signals::resolveAvailabilityUsing(function () {
            return $this->app->runningInConsole() && !$this->app->runningUnitTests() && extension_loaded('pcntl');
        });
    }
}
