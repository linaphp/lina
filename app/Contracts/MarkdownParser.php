<?php

namespace BangNokia\Pekyll\Contracts;

interface MarkdownParser
{
    public function parse(string $text): string;
}
