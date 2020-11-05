<?php

namespace App\Commands;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class CreateNewSite extends Command
{
    protected $signature = 'new {name}';

    protected $description = 'Create new site';

    public function handle(Filesystem $filesystem)
    {
        $directory = $this->argument('name');

        if ($filesystem->isDirectory($directory)) {
            $this->error($directory.' already existed');
            return 1;
        }

        $filesystem->copyDirectory(base_path('stubs'), getcwd().'/'.$directory);

        $this->createSymbolicLinks($directory, $filesystem);

        return 0;
    }

    protected function createSymbolicLinks($directory, Filesystem  $filesystem)
    {
        $filesystem->link(getcwd()."/{$directory}/images", getcwd()."/{$directory}/public/images");
        $filesystem->link(getcwd()."/{$directory}/resources/css", getcwd()."/{$directory}/public/css");
        $filesystem->link(getcwd()."/{$directory}/resources/js", getcwd()."/{$directory}/public/js");
    }
}

