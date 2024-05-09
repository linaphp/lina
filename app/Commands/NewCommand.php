<?php

namespace LinaPhp\Lina\Commands;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class NewCommand extends Command
{
    protected $signature = 'new {name}';

    protected $description = 'Create new skeleton';

    public function handle(Filesystem $filesystem): int
    {
        $directory = $this->argument('name');

        if (
            $filesystem->isDirectory($directory)
            && !$this->confirm("The directory $directory already exists. Do you want to continue?", false)
        ) {
            $this->info('Aborted!');
            return 1;
        }

        $filesystem->copyDirectory(base_path('skeleton'), $sitePath = getcwd() . '/' . $directory);

        $this->info("Your blog scaffolded successfully! 👏");

        return 0;
    }
}

