<?php

namespace BangNokia\Pekyll;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function __construct(protected ContentFinder $contentFinder)
    {
    }

    public function handle(Request $request): Response
    {
        $path = $request->getPathInfo();

        $path = $this->escape($path);

        $basePath = getcwd() . '/contents/';

        // the root path must be where the serve command pwd
        $contentFile = $basePath . ($path ?: 'index');


        $contentFilePath = $this->contentFinder->find($contentFile);

        $content = file_get_contents($contentFile);

        return new Response('Hello, World! haha');
    }

    protected function escape(string $path): string
    {
        // remove all path traversal
        $cleaned = str_replace(['..', '%2E%2E', '%252E%252E'], '', $path);

        return ltrim($cleaned, '/');
    }
}
