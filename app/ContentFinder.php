<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Exceptions\ContentNotFoundException;
use BangNokia\Pekyll\Exceptions\ManyContentFound;
use Symfony\Component\Finder\Finder;

class ContentFinder
{
    public function __construct(protected Finder $finder)
    {
    }

    /**
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function find(string $contentFile = ''): string
    {
        $cwd = getcwd();

        $path = $contentFile === '/' || $contentFile === '' ? 'index.md' : $contentFile;

        $baseName = basename($path);
        $dirName = dirname($path);

        $pattern = '/(\d{4}-\d{2}-\d{2}-)?' . $baseName . '.md$/';

        $this->finder->files()->in($cwd . '/content/' . $dirName)->name($pattern);

        $fileCount = $this->finder->count();

        if ($fileCount === 0) {
            throw new ContentNotFoundException($path);
        }

        if ($fileCount > 1) {
            $fileNames = [];

            foreach ($this->finder as $file) {
                $fileNames[] = $file->getRelativePath();
            }

            throw new ManyContentFound($fileNames);
        }

        foreach ($this->finder as $file) {
            return $file->getRealPath();
        }
    }
}
