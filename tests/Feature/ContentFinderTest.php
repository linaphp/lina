<?php

use BangNokia\Pekyll\ContentFinder;
use BangNokia\Pekyll\Exceptions\ContentNotFoundException;

it('can find the index markdown file', function () {
    chdirToSkeleton();

    $contentFinder = app(ContentFinder::class);
    $contentFile = $contentFinder->find('/');

    $this->assertEquals(getcwd().'/content/index.md', $contentFile);
});

it('throw exception when file not found', function () {
    chdirToSkeleton();

    $contentFinder = app(ContentFinder::class);

    $contentFinder->find('/not-found.md');
})->throws(ContentNotFoundException::class);

