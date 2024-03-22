<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class Serve extends Command
{
    protected $signature = 'serve';

    protected $description = 'Start simple web server for development';

    protected int $portOffset = 0;

    public function handle()
    {
        $this->line("<info>Starting development server:</info> http://{$this->host()}:{$this->port()}");

        $process = $this->startProcess();

        $this->callSilent('link');

        while ($process->isRunning()) {
            usleep(0.5 * 1000000);
        }

        $status = $process->getExitCode();

        if ($status && $this->portOffset++ < 10) {
            $this->handle();
        }

        return $status;
    }

    protected function startProcess()
    {
        $process = new Process($this->serverCommand());

        $process->start(function ($type, $data) {
            $this->output->write($data);
        });

        return $process;
    }

    protected function serverCommand()
    {
        return [
            (new PhpExecutableFinder)->find(false),
            '-S',
            $this->host().':'.$this->port(),
            '-t',
            'public',
            base_path('server.php')
        ];
    }

    protected function host()
    {
        return '127.0.0.1';
    }

    protected function port()
    {
        return 1337 + $this->portOffset;
    }
}
