<?php

namespace BangNokia\Lina\Commands;

use BangNokia\Lina\Socket;
use BangNokia\Lina\Watcher;
use LaravelZero\Framework\Commands\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Loop;
use Symfony\Component\Finder\Finder;
use Ratchet\ConnectionInterface;
use React\Socket\SocketServer as Reactor;


class WebsocketServeCommand extends Command
{
    protected $signature = 'ws:serve';

    protected $description = 'Start websocket server for development';

    protected $loop;

    protected $server;

    public static $port = 9696;

    public static $portOffset = 0;

    public function handle()
    {
        $this->loop = Loop::get();

        $this->loop->futureTick(function () {
            $this->line("<info>Starting websocket server:</info> ws://{$this->host()}:{$this->port()}");
        });

        $this->startWatcher()
            ->startServer();
    }

    protected function startWatcher(): static
    {
        $dirs = $this->dirs();

        if (empty($dirs)) {
            $this->warn('No directory to watch, please check you are in the correct directory.');
            return $this;
        }

        $finder = (new Finder())->files()->in($this->dirs());

        (new Watcher($this->loop, $finder))
            ->startWatching(function () {
                collect(Socket::$clients)
                    ->map(function (ConnectionInterface $client) {
                        $this->info('Changes detected, reloading...');
                        $client->send('reload');
                    });
            });

        return $this;
    }

    protected function startServer(): static
    {
        try {
            $this->server = new IoServer(
                new HttpServer(new WsServer(new Socket())),
                new Reactor("{$this->host()}:{$this->port()}", [], $this->loop),
                $this->loop
            );

            $this->server->run();
        } catch (\Exception $exception) {
            if (static::$portOffset < 10) {
                static::$portOffset++;
                $this->startServer();
            }
        }

        return $this;
    }

    public function host()
    {
        return '127.0.0.1';
    }

    public static function port()
    {
        return static::$port + static::$portOffset;
    }

    protected function dirs(): array
    {
        $currentDir = getcwd();

        $proposalDirs = [
            $currentDir . '/content',
            $currentDir . '/public',
            $currentDir . '/resources/views',
        ];

        $realDirs = [];

        foreach ($proposalDirs as $dir) {
            if (is_dir($dir)) {
                $realDirs[] = $dir;
            }
        }

        return $realDirs;
    }
}
