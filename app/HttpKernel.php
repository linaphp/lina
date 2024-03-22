<?php

namespace App;

use Illuminate\Contracts\Http\Kernel;

class HttpKernel implements Kernel
{
    public function bootstrap()
    {
        // TODO: Implement bootstrap() method.
    }

    public function handle($request)
    {
        echo 'wtf';
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    public function getApplication()
    {
        // TODO: Implement getApplication() method.
    }
}
