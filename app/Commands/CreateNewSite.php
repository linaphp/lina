<?php

namespace App\Commands;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class CreateNewSite extends Command
{
    protected $signature = 'new {name}';

    protected $description = 'Create new site';

    public function handle(Filesystem $filesystem): int
    {
        $directory = $this->argument('name');

        if ($filesystem->isDirectory($directory)) {
            $this->error($directory.' already existed');
            return 1;
        }

        $filesystem->copyDirectory(base_path('stubs'), $sitePath = getcwd().'/'.$directory);

        $this->info("Your blog scaffolded successfully! 👏");

        return 0;
    }
}

