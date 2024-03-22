<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\MarkdownParserInterface;
use Symfony\Component\Yaml\Yaml;

class Parser
{
    protected MarkdownParserInterface $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $text): array
    {
        ['yaml' => $yaml, 'markdown' => $markdown] = $this->classify($text);

        return array_merge($this->parseFrontMatter($yaml), ['content' => $this->markdownParser->parse($markdown)]);
    }

    public function parseFrontMatter(string $text): array
    {
        return Yaml::parse($text);
    }

    public function classify(string $text): array
    {
        $pos = strpos($text, '---', 1);

        return [
            'yaml'     => trim(substr($text, 4, $pos - 4)),
            'markdown' => trim(substr($text, $pos + 4)),
        ];
    }

    protected function parseLine(string $line): array
    {
        return array_map('trim', explode(':', $line, 2));
    }
}
