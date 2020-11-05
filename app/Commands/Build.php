<?php

namespace App\Commands;

use App\Parser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Contracts\Filesystem\Filesystem;

class Build extends Command
{
    protected $signature = 'build';

    protected $description = 'build your app to html files';

    protected Filesystem $storage;

    public function handle(Parser $parser)
    {
        $this->setConfigViewPaths($path = getcwd());

        $this->makeLocalStorage($path);

        $this->includePostClass($path);

        $posts = collect($this->storage->allFiles('posts'))->map(function ($filePath) use ($parser) {
            $data = array_merge(
                $parser->parse($this->storage->get($filePath)),
                $this->parseFileName($filePath)
            );

            $post = new \Post($data);

            $this->info('building '.$filePath.'...');
            $this->buildPost($post);

            return $post;
        });

        $this->buildIndexPage($posts);

        return 0;
    }

    protected function buildIndexPage(Collection $posts)
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

   protected function includePostClass(string $path)
   {
       include_once $path.'/app/Post.php';
   }
}
