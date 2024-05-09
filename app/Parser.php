<?php

namespace BangNokia\Lina;

use BangNokia\Lina\Contracts\MarkdownParser;
use BangNokia\Lina\Exceptions\InvalidMarkdownContent;
use Symfony\Component\Yaml\Yaml;

class Parser
{
    protected MarkdownParser $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $text): array
    {
        try {
            ['yaml' => $yaml, 'markdown' => $markdown] = $this->classify($text);

            return [
                'front_matter' => $this->parseFrontMatter($yaml),
                'content'      => $this->markdownParser->parse($markdown)
            ];
        } catch (\Exception $exception) {
            throw new InvalidMarkdownContent($text);
        }
    }

    public function parseFrontMatter(string $text): ?array
    {
        return Yaml::parse($text) ?? [];
    }

    public function classify(string $text): array
    {
        $pos = strpos($text, '---', 1);

        if ($pos === false) {
            return [
                'yaml'     => '',
                'markdown' => $text,
            ];
        }

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
