<?php

it('can build index page with component', function () {
    chdir('tests/demo');
    exec('rm -rf build/*');

    $this->artisan('build')
        ->assertExitCode(0);
    $this->assertFileExists(base_path('tests/demo/build/hello/index.html'));
});
