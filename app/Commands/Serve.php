<?php

namespace BangNokia\Pekyll\Commands;

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
        $process = new Process($this->serverCommand(), timeout: 0);

        $process->start(function ($type, $data) {
            $this->output->write($data);
        });

        // Stop the server when the user hits Ctrl+C
        // to void the port in used error
        $this->trap(fn () => [SIGTERM, SIGINT, SIGHUP, SIGUSR1, SIGUSR2, SIGQUIT], function ($signal) use ($process) {
            if ($process->isRunning()) {
                $process->stop(10, $signal);
            }

            exit;
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
        return 6969 + $this->portOffset;
    }
}
