<?php

namespace BangNokia\Lina;

class Content
{
    public string $slug;

    public string $content;

    public ?string $createdAt;

    public array $meta;

    /** @var string $path  The relative path to the `content` folder */
    public string $path;

    public function __construct(string $path, string $slug, string $content, array $meta = [], string $createdAt = null)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->meta = $meta;
        $this->path = $path;
    }

    public function url(): string
    {
        if ($this->path === '/index.md') {
            return '/';
        }

        return dirname($this->path) . '/' . $this->slug;
    }

    public function __get($name)
    {
        return $this->meta[$name] ?? null;
    }
}
