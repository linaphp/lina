<?php

it('can build index page', function () {
    exec("rm -rf ".base_path('tests/demo/cache/*'));
    chdir(base_path('tests/demo'));

    $this->artisan('build')
        ->assertExitCode(0);
//    $this->assertFileExists(base_path('tests/demo/build/index.html'));
});
