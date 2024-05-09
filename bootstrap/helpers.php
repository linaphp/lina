<?php

use LinaPhp\Lina\ContentFinder;

if (!function_exists('list_content')) {
    function lina(): ContentFinder
    {
        return app(ContentFinder::class);
    }

    function content_path($path = ''): string
    {
        return getcwd() . '/content/' . $path;
    }
}
