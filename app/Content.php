<?php

namespace BangNokia\Pekyll;

class Content
{
    public string $slug;

    public string $content;

    public ?string $createdAt;

    public array $meta;

    public string $filePath;

    public function __construct(string $slug, string $content, array $meta = [], string $createdAt = null, $relativePath = null)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->meta = $meta;
        $this->filePath = $relativePath;
    }

    public function url(): string
    {
        if ($this->filePath === '/index.md') {
            return '/';
        }

        return dirname($this->filePath) . '/' . $this->slug;
    }

    public function __get($name)
    {
        return $this->meta[$name] ?? null;
    }
}
