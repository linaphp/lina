<?php

it('build', function () {
	$this->artisan('build')
		->expectsOutput('Building...')
		->assertExitCode(0);
});
