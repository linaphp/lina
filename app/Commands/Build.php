<?php

namespace App\Commands;

use App\Parser;
use Illuminate\Support\Facades\Storage;
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

        $posts = [];

        foreach ($this->storage->allFiles('posts') as $filePath) {
            $data = array_merge(
                $parser->parse($this->storage->get($filePath)),
                $this->parseFileName($filePath)
            );

            $this->info('building '.$filePath.'...');
            $this->buildPage($data);

            $posts[] = $data;
        }

        // build homepage
        $this->buildIndexPage($posts);

        return 0;
    }

    protected function buildIndexPage(array $posts)
    {
        return $this->storage->put('build/index.html', view('index', ['posts' => $posts])->render());
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

    protected function buildPage(array $data): bool
    {
        $this->storage->makeDirectory('build/'.$data['slug']);

        return $this->storage->put('build/'.$data['slug'].'/index.html', view($data['layout'], $data)->render());
    }

    protected function parseFileName($file): array
    {
        preg_match('/^posts\/(\d{4}-\d{2}-\d{2})-(.+)\.md$/', $file, $matches);

        return [
            'created_at' => $matches[1],
            'slug'       => $matches[2]
        ];
    }
}
