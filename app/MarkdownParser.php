<?php

namespace BangNokia\Lina;

use BangNokia\Lina\Contracts\MarkdownParser as MarkdownParserContract;
use ParsedownToC;

class MarkdownParser implements MarkdownParserContract
{
    protected ParsedownToC $driver;

    public function __construct()
    {
        $this->driver = new ParsedownToC();
    }

    public function parse(string $text): string
    {
        return trim($this->driver->text($text));
    }
}
