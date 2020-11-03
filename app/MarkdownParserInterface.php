<?php

namespace App;

interface MarkdownParserInterface
{
    public function parse(string $text): string;
}
