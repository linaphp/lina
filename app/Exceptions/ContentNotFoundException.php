<?php

namespace BangNokia\Pekyll\Exceptions;

class ContentNotFoundException extends \Exception
{
    public function __construct(string $fileName)
    {
        parent::__construct('The content file ' . $fileName . ' not found');
    }
}
