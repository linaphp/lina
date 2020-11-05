<?php

it('can build index page with component', function () {
    $skeletonPath = base_path('tests/skeleton');
    chdir($skeletonPath);
    exec('rm -rf public/*');

    $this->artisan('build')
        ->expectsOutput('building posts/2020-10-30-hello-world.md...')
        ->expectsOutput('building posts/2020-11-01-foo.md...')
        ->assertExitCode(0);

    $this->assertFileExists($skeletonPath.'/public/posts/hello-world/index.html');
    $this->assertFileExists($skeletonPath.'/public/posts/foo/index.html');
    $this->assertFileDoesNotExist($skeletonPath.'/public/posts/bar/index.html');
    $this->assertFileExists($skeletonPath.'/public/index.html');

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/hello-world.html')),
        file_get_contents($skeletonPath.'/public/posts/hello-world/index.html')
    );

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/index.html')),
        file_get_contents($skeletonPath.'/public/index.html')
    );
});
