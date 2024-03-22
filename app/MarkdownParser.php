<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\MarkdownParserInterface;
use ParsedownToC;

class MarkdownParser implements MarkdownParserInterface
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
