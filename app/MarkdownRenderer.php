<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\Renderer;

class MarkdownRenderer implements Renderer
{
    public function __construct(protected string $rootDir)
    {
    }

    public function render(string $file): string
    {
        return file_get_contents($file);
    }
}
