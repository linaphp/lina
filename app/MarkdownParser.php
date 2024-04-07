<?php

namespace BangNokia\Lina;

use BangNokia\Lina\Contracts\MarkdownParser as MarkdownParserContract;

class MarkdownParser implements MarkdownParserContract
{
    protected $driver;

    public function __construct()
    {
        $this->driver = new \BangNokia\Lina\Markdown\Parser();
    }

    public function parse(string $text): string
    {
        return trim($this->driver->text($text));
    }
}
