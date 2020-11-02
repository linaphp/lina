<?php

namespace App\Commands;

use Jenssegers\Blade\Blade;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Build extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'build';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Build html files from markdown';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = getcwd();
        $viewPath = $path.'/resources/views';
        $compiledPath = $path.'/cache';
        config(['view.paths' => $viewPath]);
        config(['view.compiled' => $compiledPath]);

        $this->info('before make blade');
        $blade = new Blade($viewPath, $compiledPath);

        $this->info('before make index page');
        echo $blade->make('index', ['title' => 'Home page'])->render();

        return 0;
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
