<?php

namespace App\Commands;

use App\Parser;
use Jenssegers\Blade\Blade;
use Illuminate\Support\Facades\Storage;
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
    public function handle(Parser $parser)
    {
        $path = getcwd();
        $viewPath = $path.'/resources/views';
        $compiledPath = $path.'/resources/cache';
        config(['view.paths' => [$viewPath]]);
        config(['view.compiled' => $compiledPath]);

        /** @var Storage $client */
        $storage = Storage::createLocalDriver([
            'root' => $path
        ]);
        $postFiles = $storage->allFiles('posts');
        foreach ($postFiles as $file) {
            $content = $storage->get($file);
            // here we have to parse meta data and content
            $data = $parser->parse($content);
            dd($data);
        }

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
