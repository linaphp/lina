<?php

it('can build index page with component', function () {
    $skeletonPath = base_path('tests/skeleton');
    chdir($skeletonPath);
    exec('rm -rf build/*');

    $this->artisan('build')
        ->expectsOutput('building posts/2020-10-30-hello-world.md...')
        ->expectsOutput('building posts/2020-11-01-foo.md...')
        ->assertExitCode(0);

    $this->assertFileExists($skeletonPath.'/build/hello-world/index.html');
    $this->assertFileExists($skeletonPath.'/build/foo/index.html');
    $this->assertFileDoesNotExist($skeletonPath.'/build/bar/index.html');
    $this->assertFileExists($skeletonPath.'/build/index.html');

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/hello-world.html')),
        file_get_contents($skeletonPath.'/build/hello-world/index.html')
    );

    $this->assertEquals(
        file_get_contents(base_path('tests/expected/index.html')),
        file_get_contents($skeletonPath.'/build/index.html')
    );
});
