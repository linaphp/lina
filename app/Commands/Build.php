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

    public function handle(Parser $parser, Filesystem $filesystem)
    {
        $this->setConfigViewPaths($path = getcwd());

        $this->makeLocalStorage($path);

        if (file_exists($postPath = $path.'/app/Post.php')) {
            require $postPath;
        }

        $posts = [];

        foreach ($this->storage->allFiles('posts') as $filePath) {
            $data = array_merge(
                $parser->parse($this->storage->get($filePath)),
                $this->parseFileName($filePath)
            );

            $post = new \Post($data);

            $this->info('building '.$filePath.'...');
            $this->buildPost($post);

            $posts[] = $post;
        }

        $this->buildIndexPage($posts);

        return 0;
    }

    protected function buildIndexPage(array $posts)
    {
        return $this->storage->put('public/index.html', view('index', ['posts' => $posts])->render());
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

    protected function buildPost(\Post $post): bool
    {
        $this->storage->makeDirectory('public/posts/'.$post->slug);

        return $this->storage->put(
            'public/posts/'.$post->slug.'/index.html',
            view($post->layout, ['post' => $post])->render()
        );
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
