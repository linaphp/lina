<?php

namespace BangNokia\Pekyll;

if (!function_exists('list_content')) {
    function list_content(string $directory): array
    {
        $contentFinder = new ContentFinder();

        return $contentFinder->index($directory);
    }
}
