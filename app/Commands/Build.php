<?php

namespace BangNokia\Pekyll\Commands;

use BangNokia\Pekyll\Content;
use BangNokia\Pekyll\MarkdownRenderer;
use BangNokia\Pekyll\Parser;
use LaravelZero\Framework\Commands\Command;

class Build extends Command
{
    protected $signature = 'build {--production}';

    protected $description = 'build your app to html files';


    public function handle(Parser $parser)
    {
        $finder = app(\BangNokia\Pekyll\ContentFinder::class);

        $items = $finder->index('/');
        $renderer = app(MarkdownRenderer::class);


        $this->info('Building your site...');
        $startAt = microtime(true);

        foreach ($items as $item) {
            $this->buildItem($item, $renderer);
        }

        $endAt = microtime(true);
        $this->info(
            sprintf("Site has been built successfully in %s! 🚀", round($endAt - $startAt, 4) * 1000 . 'ms')
        );

        return 0;
    }

    protected function buildItem(Content $item, MarkdownRenderer $renderer): void
    {
        $directory = getcwd() . '/public/' .  ($item->url() === '/' ? 'index.html' : ($item->url() . '/index.html'));

        if (!is_dir(dirname($directory))) {
            mkdir(dirname($directory), 0755, true);
        }

        file_put_contents($directory, $renderer->render(content_path($item->filePath)));

        $this->info('Built html for: ' . $item->filePath);
    }
}
