<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\MarkdownParser as MarkdownParserContract;
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
        return $this->driver->text($text);
    }
}
