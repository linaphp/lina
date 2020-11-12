<?php

namespace App\Commands;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;

class CopyAssets extends Command
{
    protected $signature = 'copy-assets';

    protected $description = 'Command description';

    public function handle(Filesystem $filesystem)
    {
        foreach (config('app.asset_paths') as $source => $mirror) {
            if (is_link($mirror)) {
                unlink($mirror);
            } else {
                $filesystem->deleteDirectory($mirror, true);
            }

            $filesystem->copyDirectory($source, $mirror);
        }
    }
}
