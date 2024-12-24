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
        $path = $request->getScriptName();

        if ($this->isStaticFile($path)) {
            return new Response(
                file_get_contents(getcwd() . '/public' . $path),
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

        $html = $html . $script; // so who care about well-formed html here xD!

        return $html;
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
