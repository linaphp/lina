<?php

namespace App;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Builder
{
    protected string $workingPath;

    protected Parser $parser;

    protected Filesystem $storage;

    public function __construct(string $workingPath, Parser $parser)
    {
        $this->workingPath = $workingPath;
        $this->parser = $parser;

        $this->makeLocalStorage();
        $this->setConfigViewPaths();
        $this->includePostClass();
    }

    protected function makeLocalStorage()
    {
        $this->storage = Storage::createLocalDriver([
            'root' => $this->workingPath
        ]);
    }

    public function storage()
    {
        return $this->storage;
    }

    protected function setConfigViewPaths(string $path = null): self
    {
        $path = $path ?? $this->workingPath;
        config(['view.paths' => [$path.'/resources/views']]);
        config(['view.compiled' => $path.'/resources/cache']);

        return $this;
    }

    public function buildPosts()
    {
        return collect($this->storage->files('/posts'))
            ->reverse()
            ->map(fn($filePath) => $this->makePost($filePath))
            ->map(fn(\Post $post) => $this->buildPost($post));
    }

    public function makePost(string $filePath): \Post
    {
        $attributes = array_merge(
            $this->parser->parse($this->storage->get($filePath)),
            $this->parseFileName($filePath)
        );

        return new \Post($attributes);
    }

    protected function parseFileName(string $fileName): array
    {
        preg_match('/^(\d{4}-\d{2}-\d{2})-(.+)\.md$/', basename($fileName), $matches);

        return [
            'created_at' => $matches[1],
            'slug'       => $matches[2]
        ];
    }

    public function buildPost(\Post $post): \Post
    {
        $this->storage->put(
           "/public/posts/{$post->slug}.html",
            view($post->layout, ['post' => $post])->render()
        );

        return $post;
    }

    protected function includePostClass(): void
    {
        include_once $this->workingPath.'/app/Post.php';
    }

    public function buildPages($posts)
    {
        return collect(
            $this->storage->files('/resources/views/pages')
        )->map(fn($filePath) => $this->buildPage($filePath, $posts));
    }

    protected function buildPage(string $filePath, Collection $posts): string
    {
        $slug = str_replace('.blade.php', '', basename($filePath));

        $this->storage->put(
            "/public/{$slug}.html",
            view('pages.'.$slug, ['posts' => $posts])->render()
        );

        return $slug;
    }
}
