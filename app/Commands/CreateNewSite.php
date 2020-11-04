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
        $filesystem->copyDirectory(
            base_path('skeleton'),
            getcwd().'/'.$this->argument('name')
        );
    }
}
