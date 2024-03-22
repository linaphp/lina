<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Exceptions\ContentNotFoundException;
use BangNokia\Pekyll\Exceptions\ManyContentFound;
use Symfony\Component\Finder\Finder;

class ContentFinder
{
    protected ?string $workingDir = null;

    public function __construct(string $workingDir = null)
    {
        $this->workingDir = $workingDir ?: getcwd() . '/content/';
    }

    /**
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function find(string $contentFile = ''): string
    {
        $finder = new Finder();

        $path = $contentFile === '/' || $contentFile === '' ? 'index' : $contentFile;

        $baseName = basename($path);
        $dirName = dirname($path);

        $pattern = '/(\d{4}-\d{2}-\d{2}-)?' . $baseName . '.md$/';

        $contentDirectory = $this->workingDir . ($dirName === '.' ? '' : $dirName);

        $finder->files()->in($contentDirectory)->name($pattern);

        return $this->processFinderResult($finder, $path);
    }

    /**
     * @param Finder $finder
     * @param string $path
     * @return false|string|void
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function processFinderResult(Finder $finder, string $path)
    {
        $fileCount = $finder->count();

        if ($fileCount === 0) {
            throw new ContentNotFoundException($path);
        }

        if ($fileCount > 1) {
            $fileNames = [];

            foreach ($finder as $file) {
                $fileNames[] = $file->getRelativePath();
            }

            throw new ManyContentFound($fileNames);
        }

        foreach ($finder as $file) {
            return $file->getRealPath();
        }
    }
}
