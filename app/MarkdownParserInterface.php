<?php

namespace BangNokia\Pekyll;

interface MarkdownParserInterface
{
    public function parse(string $text): string;
}
