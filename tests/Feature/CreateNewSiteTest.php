<?php

use Illuminate\Filesystem\Filesystem;

it('can create a skeleton site', function () {
    $this->artisan('new tests/tmp');

    expect('tests/tmp')
        ->and('tests/tmp/content/posts')->toBeDirectory()
        ->and('tests/tmp/content/index.md')->toBeFile()
        ->and('tests/tmp/public')->toBeDirectory()
        ;
});

it('can not create new site if directory existed', function () {
    mkdir('tests/tmp');
    $this->artisan('new tests/tmp')
        ->assertExitCode(1);
});

afterEach(function () {
    (new Filesystem())->deleteDirectory(base_path('tests/tmp'));
});
