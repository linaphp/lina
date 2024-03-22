<?php

namespace BangNokia\Pekyll\Contracts;

interface Renderer
{
    public function render(string $file): string;
}
