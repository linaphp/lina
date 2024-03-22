<?php

if (!function_exists('list_content')) {
    function cf(): \BangNokia\Pekyll\ContentFinder
    {
        return app(\BangNokia\Pekyll\ContentFinder::class);
    }
}
