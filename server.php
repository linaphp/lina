<?php

use App\Parser;
use App\Builder;
use Illuminate\Contracts\Console\Kernel;

if (file_exists(__DIR__.'/../../autoload.php')) {
    require __DIR__.'/../../autoload.php';
} else {
	require __DIR__.'/vendor/autoload.php';
}

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class)->bootstrap();

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
$uri = $uri === '/' ? '/index.html' : $uri;

$builder = new Builder(getcwd(), $app->make(Parser::class));
$posts = collect($builder->storage()->files('posts'))->reverse()->map(fn($filePath) => $builder->makePost($filePath));

if (preg_match('/^\/posts\/(.+)\.html$/', $uri, $matches) === 1) {
    $slug = $matches[1];
    $post = $posts->first(fn($post) => $post->slug === $slug);

    echo view($post->layout, ['post' => $post])->render();
} elseif (preg_match('/^\/([a-zA-Z_0-9\-]+)\.html$/', $uri, $matches) === 1) {
    echo view('pages.'.$matches[1], ['posts' => $posts])->render();
} else {
    return false;
}
