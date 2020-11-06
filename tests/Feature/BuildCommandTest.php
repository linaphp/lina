<?php

it('can build index page with component', function () {
    $skeletonPath = base_path('tests/skeleton');
    chdir($skeletonPath);
    exec('rm -rf public/*');

    $this->artisan('build')
        ->expectsOutput('building posts/2020-10-30-hello-world.md...')
        ->expectsOutput('building posts/2020-11-01-foo.md...')
        ->assertExitCode(0);

    $this->assertFileExists($skeletonPath.'/public/posts/hello-world.html');
    $this->assertFileExists($skeletonPath.'/public/posts/foo.html');
    $this->assertFileDoesNotExist($skeletonPath.'/public/posts/bar.html');

    $this->assertFileExists($skeletonPath.'/public/page-foo.html'); // page foo
    $this->assertFileExists($skeletonPath.'/public/index.html'); // index page

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/hello-world.html')),
        file_get_contents($skeletonPath.'/public/posts/hello-world.html')
    );

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/page-foo.html')),
        file_get_contents($skeletonPath.'/public/page-foo.html')
    );

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/index.html')),
        file_get_contents($skeletonPath.'/public/index.html')
    );
});
