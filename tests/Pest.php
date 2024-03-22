<?php

use PHPUnit\Framework\Assert;

uses(Tests\TestCase::class)->in('Feature');

expect()->extend('toBeMatchDirectory', function (string $source) {
    Assert::assertTrue(is_dir($this->value), "Expected directory '$this->value' to exist.");
    Assert::assertTrue(is_dir($source), "Expected directory '$source' to exist.");

    return $this;
});

function chdirToSkeleton(): void
{
    chdir(__DIR__.'/../skeleton');
}
