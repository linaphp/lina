<?php

namespace BangNokia\Lina\Contracts;

interface MarkdownParser
{
    public function parse(string $text): string;
}
