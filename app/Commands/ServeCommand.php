<?php

namespace LinaPhp\Lina\Commands;

use Illuminate\Process\Pool;
use Illuminate\Support\Facades\Process;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\PhpExecutableFinder;

class ServeCommand extends Command
{
    protected $signature = 'serve';

    protected $description = 'Start development server';

    public function handle(): int
    {
        $phpBinary = (new PhpExecutableFinder())->find();
        // get the current php binary path which is running the command
        $pool = Process::pool(function (Pool $pool) use ($phpBinary) {
            $pool->path(getcwd())->command([$phpBinary, base_path('lina'), 'serve:http']);
            $pool->path(getcwd())->command([$phpBinary, base_path('lina'), 'serve:ws']);
        })->start(function (string $type, string $output, string $key) {
            $this->output->write($output);
        });

        while ($pool->running()->isNotEmpty()) {
            usleep(0.5 * 1000000);
        }

        $pool->wait();
    }
}
