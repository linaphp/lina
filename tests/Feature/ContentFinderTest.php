<?php

use LinaPhp\Lina\ContentFinder;
use LinaPhp\Lina\Exceptions\ContentNotFoundException;

it('can find the index markdown file', function () {
    chdirToSkeleton();

    $contentFinder = app(ContentFinder::class);
    $contentFile = $contentFinder->tryFind('/');

    $this->assertEquals(getcwd().'/content/index.md', $contentFile);
});

it('can find the file with date prefix', function () {
    chdirToSkeleton();

    $contentFinder = app(ContentFinder::class);

    $contentFile = $contentFinder->tryFind('/posts/hello');
    $this->assertEquals(getcwd().'/content/posts/2020-11-01-hello.md', $contentFile);

    $contentFile = $contentFinder->tryFind('/posts/2020-11-01-hello');
    $this->assertEquals(getcwd().'/content/posts/2020-11-01-hello.md', $contentFile);
});

it('throw exception when file not found', function () {
    chdirToSkeleton();

    $contentFinder = app(ContentFinder::class);

    $contentFinder->tryFind('/not-found.md');
})->throws(ContentNotFoundException::class);

