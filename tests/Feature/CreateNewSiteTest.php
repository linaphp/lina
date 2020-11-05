<?php

it('can create a skeleton site', function () {
    $this->artisan('new tests/tmp');

    $this->assertDirectoryExists(getcwd().'/tests/tmp');

    $filesystem = new Illuminate\Filesystem\Filesystem();

    $this->assertEquals(
        $filesystem->allFiles(base_path('stubs')),
        $filesystem->allFiles(getcwd().'/tests/tmp')
    );
});

it('can not create new site if directory existed', function () {
    mkdir('tests/tmp');
    $this->artisan('new tests/tmp')
        ->assertExitCode(1);
});

afterEach(function () {
    exec('rm -rf tests/tmp');
});
