<?php

namespace App\Commands;

use App\Parser;
use App\Builder;
use LaravelZero\Framework\Commands\Command;

class Build extends Command
{
    protected $signature = 'build {--production}';

    protected $description = 'build your app to html files';

    public function handle(Parser $parser)
    {
        $this->info('building...');

        $this->call(CopyAssets::class);

        $builder = new Builder(getcwd(), $parser);

        $posts = $builder->buildPosts();

        $builder->buildPages($posts);

        $this->info('building completed!');

        return 0;
    }
}
