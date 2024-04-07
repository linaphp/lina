<?php

namespace BangNokia\Lina;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;

class Socket implements MessageComponentInterface
{
    public static SplObjectStorage $clients;

    public function __construct()
    {
        static::$clients = new SplObjectStorage();
    }

    function onOpen(ConnectionInterface $conn)
    {
        static::$clients->attach($conn);
    }

    function onClose(ConnectionInterface $conn)
    {
        static::$clients->detach($conn);
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
    }
}
