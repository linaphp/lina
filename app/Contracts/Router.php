<?php

namespace LinaPhp\Lina\Contracts;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface Router
{
    public function parse(Request $request): Response;
}
