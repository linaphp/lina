<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function handle(Request $request): Response
    {
        return new Response('Hello, World! haha');
    }
}
