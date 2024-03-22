<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\Renderer;

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
//        dd($result);

        $content = view('post', [
            ...$result
        ])->render();
//        dd($content);

        return $content;

        return view($result['layout'], [
            ...$result
        ])->render();
//        return $content;
    }
}
