<?php

namespace LinaPhp\Lina;

use LinaPhp\Lina\Commands\WebsocketServeCommand;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router implements \LinaPhp\Lina\Contracts\Router
{
    protected Finder $finder;

    public function __construct(protected ContentFinder $contentFinder)
    {
        $this->finder = (new Finder())->in(getcwd() . '/public');
    }

    public function parse(Request $request): Response
    {
        $path = rawurldecode(parse_url($request->getRequestUri() ?? '/', PHP_URL_PATH) ?: '/');

        if ($this->isStaticFile($path)) {
            $publicFile = getcwd() . '/public/' . $this->escape($path);
            return new Response(
                file_get_contents($publicFile),
                200,
                ['Content-Type' => $request->getMimeType(last(explode('.', basename($path))))]
            );
        }

        $contentFileRealPath = $this->contentFinder->tryFind($path);

        $html = app(MarkdownRenderer::class)->render($contentFileRealPath);

        // we don't have middleware so let inject the websocket script here
        $html = $this->injectWebSocketScript($html);

        return new Response(
            $html,
            200,
            ['Content-Type' => 'text/html']
        );
    }

    protected function injectWebSocketScript(string $html): string
    {
        $port = WebsocketServeCommand::port();

        $script = <<<JS
<script>
    (new WebSocket('ws://127.0.0.1:$port')).onmessage = function (message) {
        if (message.data === 'reload') {
            window.location.reload(true);
        }
    };
</script>
JS;

        return $html . $script; // so who care about well-formed html here xD!
    }

    protected function isStaticFile(string $path): bool
    {
        $relativePath = $this->escape($path);
        $absolutePath = getcwd() . '/public/' . $relativePath;

        return in_array(
            strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'eot']
        )
        && is_file($absolutePath);
    }

    protected function escape(string $path): string
    {
        // remove all path traversal
        $cleaned = str_replace(['..', '%2E%2E', '%252E%252E'], '', $path);

        return ltrim($cleaned, '/');
    }
}
