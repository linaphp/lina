<?php

namespace App;

class Parser
{
    protected MarkdownParserInterface $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $text): array
    {
        return [
            'meta'    => 'meta',
            'content' => $this->markdownParser->parse($text)
        ];
    }
}
