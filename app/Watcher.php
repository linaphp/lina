<?php

namespace LinaPhp\Lina;

use Illuminate\Support\Facades\Cache;
use LinaPhp\ResourceWatcher\Crc32ContentHash;
use LinaPhp\ResourceWatcher\ResourceCacheMemory;
use LinaPhp\ResourceWatcher\ResourceWatcher;

class Watcher
{
    protected $loop;
    protected $finder;

    public function __construct($loop, $finder)
    {
        $this->loop = $loop;
        $this->finder = $finder;
    }

    public function startWatching($callback)
    {
        $watcher = new ResourceWatcher(
            new ResourceCacheMemory(),
            $this->finder,
            new Crc32ContentHash()
        );

        $this->loop->addPeriodicTimer(1, function () use ($watcher, $callback) {
            Cache::put('serve_websockets_running', true, 5);
            if ($watcher->findChanges()->hasChanges()) {
                call_user_func($callback);
            }
        });
    }

}
