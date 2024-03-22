<?php

namespace BangNokia\Pekyll;

use BangNokia\Pekyll\Contracts\Renderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function __construct(protected ContentFinder $contentFinder, protected Renderer $renderer)
    {
    }

    public function handle(Request $request): Response
    {
        $path = $request->getPathInfo();

        $path = $this->escape($path);

        $contentFilePath = $this->contentFinder->find($path);

        return new Response(
            $this->renderer->render($contentFilePath),
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
