<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Exceptions\ContentNotFoundException;
use Symfony\Component\Finder\Finder;

class ContentFinder
{
    public function __construct(protected Finder $finder)
    {
    }

    public function find(string $contentFile = ''): string
    {
        $cwd = getcwd();

        $absolutePath = $cwd . '/contents' . $contentFile;

        $fileName = $contentFile === '/' || $contentFile === '' ? 'index.md' : $contentFile;

        $this->finder->files()->in($cwd . '/content')->name($fileName);

        if ($this->finder->count() !== 1) {
            throw new ContentNotFoundException($fileName);
        }

        foreach ($this->finder as $file) {
            return $file->getRealPath();
        }
    }
}
