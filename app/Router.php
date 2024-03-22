<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function handle(Request $request): Response
    {
        $path = $request->getPathInfo();

        $path = $this->escape($path);

        // the root path must be where the serve command pwd

        $contentFile = sprintf('%s/contents/%s.md', getcwd(), $path);

        if (!file_exists($contentFile)) {
            return new Response("Content file [$path] not found", 404);
        }

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
