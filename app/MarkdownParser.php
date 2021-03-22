<?php

namespace App;

use ParsedownExtra;

class MarkdownParser implements MarkdownParserInterface
{
    protected Parsedown $driver;

    public function __construct()
    {
        $this->driver = new ParsedownExtra();
    }

    public function parse(string $text): string
    {
        return $this->driver->text($text);
    }
}
