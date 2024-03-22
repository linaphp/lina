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

    public function render(string $file): string
    {
        $content = app(ContentFinder::class)->get($file);

        return view($content->layout, [
            'data' => $content,
        ])->render();
    }
}
