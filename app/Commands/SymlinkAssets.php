<?php

namespace App\Commands;

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

        foreach ($this->linkableDirectories() as $source => $target) {
            if ($filesystem->isDirectory($targetLink = "{$sitePath}/{$target}")) {
                $filesystem->deleteDirectory($targetLink);
            }

            $filesystem->delete($targetLink);

            $filesystem->link("{$sitePath}/{$source}", $targetLink);
        }
    }

    protected function linkableDirectories(): array
    {
        return [
            'images'        => 'public/images',
            'resources/css' => 'public/css',
            'resources/js'  => 'public/js'
        ];
    }
}
