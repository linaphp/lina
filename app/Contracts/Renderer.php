<?php

namespace BangNokia\Lina\Contracts;

interface Renderer
{
    public function render(string $file): string;
}
