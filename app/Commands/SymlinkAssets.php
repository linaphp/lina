<?php

namespace BangNokia\Pekyll\Commands;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class SymlinkAssets extends Command
{
    protected $signature = 'link {root?}';

    protected $hidden = true;

    protected $description = 'Command description';

    public function handle(Filesystem $filesystem)
    {
        $sitePath = $this->argument('root') ?: getcwd();

        foreach (config('app.asset_paths') as $source => $target) {
            if (is_link($target)) {
                unlink($target);
            } elseif ($filesystem->isDirectory($target)) {
                $filesystem->deleteDirectory($target);
            }

            $filesystem->link($sitePath.'/'.$source, $sitePath.'/'.$target);
        }
    }
}
