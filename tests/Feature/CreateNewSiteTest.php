<?php

use Illuminate\Filesystem\Filesystem;

it('can create a skeleton site', function () {
    $this->artisan('new tests/tmp');

    expect(base_path('/tests/tmp'))->toBeMatchDirectory(base_path('skeleton'));
});

it('can not create new site if directory existed', function () {
    mkdir('tests/tmp');


    $this->artisan('new tests/tmp')
        ->expectsConfirmation('The directory tests/tmp already exists. Do you want to continue?', 'no')
        ->assertExitCode(1);
});

afterEach(function () {
    (new Filesystem())->deleteDirectory(base_path('tests/tmp'));
});
