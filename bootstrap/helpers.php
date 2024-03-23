<?php

use BangNokia\Lina\ContentFinder;

if (!function_exists('list_content')) {
    function cf(): ContentFinder
    {
        return app(ContentFinder::class);
    }

    function content_path($path = ''): string
    {
        return getcwd() . '/content/' . $path;
    }
}
