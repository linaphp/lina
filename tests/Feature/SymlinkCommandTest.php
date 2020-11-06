<?php

$filesystem = new \Illuminate\Filesystem\Filesystem();

it('can delete directories before create symbolic links', function () use ($filesystem) {
    $filesystem->makeDirectory('tests/tmp');

    chdir('tests/tmp');

    $filesystem->makeDirectory('public/images', 0755, true);
    $filesystem->makeDirectory('public/css', 0755, true);
    $filesystem->makeDirectory('public/js', 0755, true);

    $this->artisan('link');

    expect(is_link('public/images'))->toBeTrue();
    expect(is_link('public/css'))->toBeTrue();
    expect(is_link('public/js'))->toBeTrue();
});

afterEach(function () use($filesystem) {
   $filesystem->deleteDirectory(base_path('tests/tmp'));
});
