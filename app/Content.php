<?php

namespace BangNokia\Pekyll;

class Content
{
    public string $slug;

    public string $content;

    public string $createdAt;

    public array $meta;

    public string $filePath;

    public function __construct(string $slug, string $content, array $meta = [], string $createdAt = null, $layout = null)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->meta = $meta;
    }

    public function url(): string
    {
        return str_replace(getcwd(), '', $this->filePath) . $this->slug;
    }

    public function __get($name)
    {
        return $this->meta[$name] ?? null;
    }
}
