<?php

namespace App\Commands;

use App\Parser;
use Illuminate\Support\Collection;
use Dotenv\Parser\ParserInterface;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Contracts\Filesystem\Filesystem;

class Build extends Command
{
    protected $signature = 'build';

    protected $description = 'build your app to html files';

    protected Filesystem $storage;

    protected Parser $parser;

    public function handle(Parser $parser)
    {
        $this->parser = $parser;

        $this->setConfigViewPaths($path = getcwd())
            ->makeLocalStorage($path)
            ->includePostClass($path);

        $posts = collect(
            $this->storage->allFiles('posts')
        )->map(fn($filePath) => $this->buildPost($filePath));

        $pages = collect(
            $this->storage->allFiles('resources/views/pages')
        )->map(fn ($filePath) => $this->buildPage($filePath, $posts));

        $this->buildIndexPage($posts, $pages);

        $this->error(memory_get_peak_usage(true)/1024/1024 . 'MB');

        return 0;
    }

    protected function buildIndexPage(Collection $posts, Collection $pages)
    {
        return $this->storage->put(
            'public/index.html',
            view('index', ['posts' => $posts, 'page' => $pages])->render()
        );
    }

    protected function setConfigViewPaths($path): self
    {
        config(['view.paths' => [$path.'/resources/views']]);
        config(['view.compiled' => $path.'/resources/cache']);

        return $this;
    }

    protected function makeLocalStorage(string $path): self
    {
        $this->storage = Storage::createLocalDriver([
            'root' => $path
        ]);

        return $this;
    }

    protected function buildPost(string $filePath): \Post
    {
        $attributes = array_merge(
            $this->parser->parse($this->storage->get($filePath)),
            $this->parseFileName($filePath)
        );

        $post = new \Post($attributes);

        $this->info('building '.$filePath.'...');

        $this->storage->put(
            "public/posts/{$post->slug}.html",
            view($post->layout, ['post' => $post])->render()
        );

        return $post;
    }

    protected function buildPage(string $filePath, Collection $posts): string
    {
        $pageSlug = str_replace('.blade.php', '', basename($filePath));
        $this->storage->put(
            "public/{$pageSlug}.html",
            view('pages.'.$pageSlug, ['posts' => $posts])->render()
        );

        return $pageSlug;
    }

    protected function parseFileName($file): array
    {
        preg_match('/^posts\/(\d{4}-\d{2}-\d{2})-(.+)\.md$/', $file, $matches);

        return [
            'created_at' => $matches[1],
            'slug'       => $matches[2]
        ];
    }

    protected function includePostClass(string $path): void
    {
        include_once $path.'/app/Post.php';
    }
}
