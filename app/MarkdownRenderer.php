<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\Renderer;
use Illuminate\Support\Facades\Blade;

class MarkdownRenderer implements Renderer
{
    protected Parser $parser;

    public function __construct(protected string $rootDir)
    {
        $this->parser = new Parser(new MarkdownParser());

        config(['view.paths' => [$this->rootDir . '/resources/views']]);
        config(['view.compiled' => $this->rootDir . '/resources/cache']);
    }

    public function render(string $realPath): string
    {
        $content = app(ContentFinder::class)->get($realPath, true);

        return view($content->layout, [
            'data' => $content,
        ])->render();
    }
}
