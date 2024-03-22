<?php

namespace App\Providers;

use App\HttpKernel;
use App\MarkdownParser;
use App\MarkdownParserInterface;
use Illuminate\Contracts\Http\Kernel;
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
    }
}
