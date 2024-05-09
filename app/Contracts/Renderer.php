<?php

namespace LinaPhp\Lina\Contracts;

interface Renderer
{
    public function render(string $file): string;
}
