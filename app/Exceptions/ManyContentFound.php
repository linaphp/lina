<?php

namespace BangNokia\Lina\Exceptions;

class ManyContentFound extends \Exception
{
    public function __construct(array $fileNames)
    {
        parent::__construct('Many content files matched: ' . implode(', ', $fileNames));
    }
}
