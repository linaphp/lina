<?php

it('can find the index markdown file', function () {
    chdirToSkeleton();


    $contentFinder = new \BangNokia\Pekyll\ContentFinder();
    $contentFile = $contentFinder->find('/');
    $this->assertEquals(getcwd().'/contents/index.md', $contentFile);
});

