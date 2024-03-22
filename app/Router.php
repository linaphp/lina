<?php

namespace BangNokia\Pekyll;

use LaravelZero\Framework\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BangNokia\Pekyll\Contracts\Renderer;

class Router implements \BangNokia\Pekyll\Contracts\Router
{
    public function __construct(protected ContentFinder $contentFinder)
    {
    }

    public function parse(Request $request): Response
    {
        $path = $request->getPathInfo();

        $path = $this->escape($path);

        $contentFilePath = $this->contentFinder->find($path);

        return new Response(
            (new MarkdownRenderer(getcwd()))->render($contentFilePath),
            200,
            ['Content-Type' => 'text/html']
        );
    }

    protected function escape(string $path): string
    {
        // remove all path traversal
        $cleaned = str_replace(['..', '%2E%2E', '%252E%252E'], '', $path);

        return ltrim($cleaned, '/');
    }
}
