<?php

namespace App\Commands;

use App\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Contracts\Filesystem\Filesystem;

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

    protected Filesystem $storage;

    public function handle(Parser $parser)
    {
        $this->setConfigViewPaths($path = getcwd());

        $this->makeLocalStorage($path);

        foreach ($this->storage->allFiles('posts') as $filePath) {
            $data = array_merge(
                $parser->parse($this->storage->get($filePath)),
                ['slug' => $this->parseFileName($filePath)]
            );

            $this->info('building '.$filePath.'...');
            $this->writeFile($data);
        }

        return 0;
    }

    protected function setConfigViewPaths($path): void
    {
        config(['view.paths' => [$path.'/resources/views']]);
        config(['view.compiled' => $path.'/resources/cache']);
    }

    protected function makeLocalStorage(string $path)
    {
        return $this->storage = Storage::createLocalDriver([
            'root' => $path
        ]);
    }

    protected function writeFile(array $data): bool
    {
        $this->storage->makeDirectory('build/'.$data['slug']);

        return $this->storage->put('build/'.$data['slug'].'/index.html', view($data['layout'], $data)->render());
    }

    protected function parseFileName($file): string
    {
        preg_match('/^posts\/(.+)\.md$/', $file, $matches);

        return $matches[1];
    }
}
