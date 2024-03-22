<?php

namespace BangNokia\Pekyll;

class Renderer
{
    public function render(string $file): string
    {
        return file_get_contents($file);
    }
}
