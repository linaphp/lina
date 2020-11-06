<?php

it('can create a skeleton site', function () {
    $this->artisan('new tests/tmp');

    expect('tests/tmp')->and('tests/tmp/posts')->toBeDirectory()
        ->and(is_link('tests/tmp/public/images'))->toBeTrue()
        ->and(readlink('tests/tmp/public/images'))->toBe(getcwd().'/tests/tmp/images')
        ->and(is_link('tests/tmp/public/css'))->toBeTrue()
        ->and(readlink('tests/tmp/public/css'))->toBe(getcwd().'/tests/tmp/resources/css')
        ->and(is_link('tests/tmp/public/js'))->toBeTrue()
        ->and(readlink('tests/tmp/public/js'))->toBe(getcwd().'/tests/tmp/resources/js');

//    $filesystem = new Illuminate\Filesystem\Filesystem();

//    $this->assertEquals(
//        $filesystem->allFiles(base_path('stubs')),
//        $filesystem->allFiles(getcwd().'/tests/tmp')
//    );
});

it('can not create new site if directory existed', function () {
    mkdir('tests/tmp');
    $this->artisan('new tests/tmp')
        ->assertExitCode(1);
});

afterEach(function () {
    $filesystem = new \Illuminate\Filesystem\Filesystem();
    $filesystem->deleteDirectory(base_path('tests/tmp'));
});
