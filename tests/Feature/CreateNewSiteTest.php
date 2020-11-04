<?php

it('can create a skeleton site', function () {
    $this->artisan('new tests/tmp');

    $this->assertDirectoryExists(getcwd().'/tests/tmp');

    $filesystem = new Illuminate\Filesystem\Filesystem();

    $this->assertEquals(
        $filesystem->allFiles(base_path('skeleton')),
        $filesystem->allFiles(getcwd().'/tests/tmp')
    );
});

afterEach(function () {
    exec('rm -rf tests/tmp');
});
