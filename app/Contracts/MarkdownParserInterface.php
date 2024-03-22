<?php

namespace BangNokia\Pekyll\Contracts;

interface MarkdownParserInterface
{
    public function parse(string $text): string;
}
