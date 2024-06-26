<?php

namespace LinaPhp\Lina;

use LinaPhp\Lina\Exceptions\ContentNotFoundException;
use LinaPhp\Lina\Exceptions\InvalidMarkdownContent;
use LinaPhp\Lina\Exceptions\ManyContentFound;
use Symfony\Component\Finder\Finder;

class ContentFinder
{
    protected ?string $workingDir = null;

    public function __construct(string $workingDir = null)
    {
        $this->workingDir = $workingDir ?: getcwd() . '/content';
    }

    /**
     * Find the content file by path from url
     *
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function tryFind(string $contentFile = ''): string
    {
        $finder = new Finder();

        $path = $contentFile === '/' || $contentFile === '' ? 'index' : $contentFile;

        $baseName = basename($path);
        $dirName = dirname($path);

        $pattern = '/(\d{4}-\d{2}-\d{2}-)?' . $baseName . '.md$/';

        $contentDirectory = $this->workingDir . ($dirName === '.' ? '' : $dirName);

        $finder->files()->in($contentDirectory)->name($pattern);

        $result = $this->processFinderResult($finder, $path);

        return $result;
    }

    public function get(string $filePath, $absolute = false): Content
    {
        $absolutePath = $absolute ? $filePath : $this->workingDir . $filePath;

        $content = file_get_contents($absolutePath);

        try {
            $data = (new Parser(new MarkdownParser()))->parse($content);
        } catch (\Exception $exception) {
            throw new InvalidMarkdownContent($filePath);
        }

        $fileName = basename($filePath, '.md');

        if (preg_match('/(\d{4}-\d{2}-\d{2}-)?(.*)/', $fileName, $matches)) {
            $slug = $matches[2];
            $createdAt = $matches[1] ? rtrim($matches[1], '-') : null;
        }

        return new Content(
            path: $absolute ? str_replace($this->workingDir, '', $filePath) : $filePath,
            slug: $slug ?? $fileName,
            content: $data['content'],
            meta: $data['front_matter'],
            createdAt: $createdAt ?? null,
        );
    }

    public function index(string $directory = ''): array
    {
        $posts = [];
        $finder = (new Finder())->in($this->workingDir . ltrim('/' . $directory))->name('*.md');

        foreach ($finder as $file) {
            if ($file->isDir()) {
                continue;
            }

            $posts[] = $this->get($file->getRealPath(), true);
        }

        return $posts;
    }

    /**
     * @throws ContentNotFoundException
     * @throws ManyContentFound
     */
    public function processFinderResult(Finder $finder, string $path): string
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
