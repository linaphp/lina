<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\Renderer;

class MarkdownRenderer implements Renderer
{
    public function __construct(protected string $rootDir, protected Parser $parser)
    {
    }

    public function render(string $file): string
    {
        $content = file_get_contents($file);

        $result = $this->parser->parse($content);
        dd($content);
    }
}
