<?php

namespace App;

use Parsedown;

class MarkdownParser implements MarkdownParserInterface
{
    protected Parsedown $driver;

    public function __construct()
    {
        $this->driver = new Parsedown();
    }

    public function parse(string $text): string
    {
        return $this->driver->text($text);
    }
}
