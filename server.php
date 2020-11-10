<?php

use App\Parser;
use App\Builder;

require __DIR__.'vendor/autoload.php';

// I have no idea about these code
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);
// end

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
$uri = $uri === '/' ? 'index.html' : $uri;

$builder = new Builder(getcwd(), $app->make(Parser::class));
$posts = collect($builder->storage()->files('posts'))->map(fn($filePath) => $builder->makePost($filePath));

if (preg_match('/^\/posts\/(.+)\.html$/', $uri, $matches) === 1) {
    $slug = $matches[1];
    $post = $posts->first(fn($post) => $post->slug === $slug);
    echo view($post->layout, ['post' => $post])->render(); // the fuck
} elseif (preg_match('/^\/([a-zA-Z_0-9\-]+)\.html$/', $uri, $matches) === 1) {
    echo view('pages.'.$matches[1], ['posts' => $posts])->render();
} else {
    return false;
}
