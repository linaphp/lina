<?php

namespace App\Providers;

use App\HttpKernel;
use App\MarkdownParser;
use App\MarkdownParserInterface;
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
