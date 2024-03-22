<?php

namespace BangNokia\Pekyll;

class Content
{
    public string $slug;

    public ?string $title;

    public string $content;

    public string $createdAt;

    public array $meta;

    public ?string $layout = null;

    public function __construct(string $slug, string $content, array $meta = [], string $createdAt = null, $layout = null)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->meta = $meta;
        $this->layout = $layout;

        $this->title = $this->meta['title'] ?? null;
    }
}
