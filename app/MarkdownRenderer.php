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
    }

    public function render(string $file): string
    {
        $content = file_get_contents($file);

        $result = $this->parser->parse($content);
//        dd(Blade::getFacadeRoot());

        return Blade::compileString($result);
    }
}
