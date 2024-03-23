<?php

namespace BangNokia\Pekyll\Commands;

use BangNokia\Pekyll\Content;
use BangNokia\Pekyll\ContentFinder;
use BangNokia\Pekyll\MarkdownRenderer;
use BangNokia\Pekyll\Parser;
use LaravelZero\Framework\Commands\Command;

class Build extends Command
{
    protected $signature = 'build {--production}';

    protected $description = 'build your app to html files';

    public function handle(Parser $parser): int
    {
        $finder = app(ContentFinder::class);

        $items = $finder->index('/');
        $renderer = app(MarkdownRenderer::class);

        $this->warn('Building your site...');
        $count = 0;
        $startAt = microtime(true);

        foreach ($items as $item) {
            $this->buildItem($item, $renderer);
            $count++;
        }

        $this->info(
            sprintf("Built %s pages in %s! 🚀", $count, round(microtime(true) - $startAt, 4) * 1000 . 'ms')
        );

        return 0;
    }

    protected function buildItem(Content $item, MarkdownRenderer $renderer): void
    {
        $directory = getcwd() . '/public/' . ($item->url() === '/' ? 'index.html' : ($item->url() . '/index.html'));

        if (!is_dir(dirname($directory))) {
            mkdir(dirname($directory), 0755, true);
        }

        file_put_contents($directory, $renderer->render(content_path($item->filePath)));

//        $this->getOutput()->writeln('Built html for: ' . $item->filePath . '\r');
    }
}
