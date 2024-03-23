<?php

namespace BangNokia\Lina;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router implements \BangNokia\Lina\Contracts\Router
{
    protected Finder $finder;

    public function __construct(protected ContentFinder $contentFinder)
    {
        $this->finder = (new Finder())->in(getcwd() . '/public');
    }

    public function parse(Request $request): Response
    {
        $path = $request->getScriptName();

        if ($this->isStaticFile($path)) {
            return new Response(
                file_get_contents(getcwd() . '/public' . $path),
                200,
                ['Content-Type' => $request->getMimeType(last(explode('.', basename($path))))]
            );
        }

        $contentFileRealPath = $this->contentFinder->tryFind($path);

        return new Response(
            app(MarkdownRenderer::class)->render($contentFileRealPath),
            200,
            ['Content-Type' => 'text/html']
        );
    }

    protected function isStaticFile(string $path): bool
    {
        return in_array(pathinfo($path, PATHINFO_EXTENSION), ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg']);
    }

    protected function escape(string $path): string
    {
        // remove all path traversal
        $cleaned = str_replace(['..', '%2E%2E', '%252E%252E'], '', $path);

        return ltrim($cleaned, '/');
    }
}
