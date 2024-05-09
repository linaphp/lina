<?php

namespace LinaPhp\Lina\Contracts;

interface MarkdownParser
{
    public function parse(string $text): string;
}
