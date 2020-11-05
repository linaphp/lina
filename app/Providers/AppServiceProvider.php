<?php

namespace App\Providers;

use App\MarkdownParser;
use App\MarkdownParserInterface;
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

    public function boot()
    {
        if (base_path() !== getcwd()) {
           $this->app['config']->set('commands.remove', [
               \LaravelZero\Framework\Commands\InstallCommand::class,
               \LaravelZero\Framework\Commands\BuildCommand::class,
               \LaravelZero\Framework\Commands\MakeCommand::class,
               \LaravelZero\Framework\Commands\StubPublishCommand::class,
               \LaravelZero\Framework\Commands\RenameCommand::class,
               \Pest\Laravel\Commands\PestDatasetCommand::class,
               \Pest\Laravel\Commands\PestInstallCommand::class,
               \Pest\Laravel\Commands\PestTestCommand::class,
           ]);
        }
    }
}
