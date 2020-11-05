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
        ['yaml' => $yaml, 'markdown' => $markdown] = $this->classify($text);

        return array_merge($this->parseYaml($yaml), ['content' => $this->markdownParser->parse($markdown)]);
    }

    public function parseYaml(string $text): array
    {
        $meta = [];

        foreach (explode(PHP_EOL, $text) as $line) {
            if (blank($line)) {
                continue;
            }

            [$key, $value] = $this->parseLine($line);

            if (substr($key, -2) === '[]') {
                $key = substr($key, 0, strlen($key) - 2);
                $value = array_map('trim', explode(',', $value));
            }

            $meta[$key] = $value;
        }

        return $meta;
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
