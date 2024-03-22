<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Exceptions\ContentNotFoundException;
use BangNokia\Pekyll\Exceptions\ManyContentFound;
use Symfony\Component\Finder\Finder;

class ContentFinder
{
    protected ?string $workingDir = null;

    public function __construct(protected Finder $finder)
    {
        $this->workingDir = $this->workingDir ?: getcwd() . '/content/';
    }

    /**
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function find(string $contentFile = ''): string
    {
        $path = $contentFile === '/' || $contentFile === '' ? 'index' : $contentFile;

        $baseName = basename($path);
        $dirName = dirname($path);

        $pattern = '/(\d{4}-\d{2}-\d{2}-)?' . $baseName . '.md$/';

        $contentDirectory = $this->workingDir . ($dirName === '.' ? '' : $dirName);

        $this->finder->files()->in($contentDirectory)->name($pattern);

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
