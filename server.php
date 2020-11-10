<?php

require 'vendor/autoload.php';

use App\UriDetector;
use Illuminate\Filesystem\Filesystem;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$currentPath = getcwd();
// should we load all the posts into the memory???
$filesystem = new Filesystem();

$postFiles = $filesystem->allFiles('posts');
$posts = collect($postFiles)->map();
dd($posts);

//
$data = (new UriDetector)->detect($uri);
dd($data);
