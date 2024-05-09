<?php

namespace LinaPhp\Lina\Commands;

use Illuminate\Console\Command;
use League\Flysystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanCommand extends Command
{
    protected $signature = 'clean';

    protected $description = 'Clean the built files in public directory';

    public function handle(): int
    {
        $finder = new Finder();

        $finder->in(getcwd() . '/public')->name('*.html');

        foreach ($finder as $item) {
            if ($item->isFile()) {
                unlink($item->getRealPath());
                unset($item);
            }
        }

        $this->info('Cleaned the public directory');

        return 0;
    }
}
