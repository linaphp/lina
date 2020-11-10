<?php

require 'vendor/autoload.php';

use App\UriDetector;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// should we load all the posts into the memory???
//
$data = (new UriDetector)->detect($uri);
dd($data);
