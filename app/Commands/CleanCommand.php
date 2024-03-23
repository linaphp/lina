<?php

namespace BangNokia\Lina\Commands;

use BangNokia\Lina\ContentFinder;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class CleanCommand extends Command
{
    protected $signature = 'clean';

    protected $description = 'Clean the built files in public directory';

    public function handle(): int
    {
        $finder = new Finder();

        $finder->in(getcwd() . '/public')->files('*.html');

        foreach ($finder as $file) {
            unlink($file->getRealPath());
        }

        $this->info('Cleaned the public directory');
    }
}
