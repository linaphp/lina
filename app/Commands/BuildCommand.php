<?php

namespace BangNokia\Lina\Commands;

use BangNokia\Lina\Content;
use BangNokia\Lina\ContentFinder;
use BangNokia\Lina\MarkdownRenderer;
use LaravelZero\Framework\Commands\Command;

class BuildCommand extends Command
{
    protected $signature = 'build';

    protected $description = 'build your app to html files';

    public function handle(): int
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
        echo 'Building ' . $item->path . PHP_EOL;

        file_get_contents('https://ping2.me/@daudau/debug?message=building' . $item->slug);

        $directory = getcwd() . '/public/' . ($item->url() === '/' ? 'index.html' : ($item->url() . '/index.html'));

        if (!is_dir(dirname($directory))) {
            mkdir(dirname($directory), 0755, true);
        }

        file_put_contents($directory, $renderer->render(content_path($item->path)));

        $this->getOutput()->writeln('Built html for: ' . $item->filePath . '\r');
    }
}
