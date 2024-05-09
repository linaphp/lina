<?php

namespace LinaPhp\Lina;

use LinaPhp\Lina\Contracts\MarkdownParser as MarkdownParserContract;

class MarkdownParser implements MarkdownParserContract
{
    protected $driver;

    public function __construct()
    {
        $this->driver = new \LinaPhp\Lina\Markdown\Parser();
    }

    public function parse(string $text): string
    {
        return trim($this->driver->text($text));
    }
}
