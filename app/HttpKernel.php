<?php

namespace App;

use Illuminate\Contracts\Http\Kernel;

class HttpKernel implements Kernel
{
    public function bootstrap()
    {
        // TODO: Implement bootstrap() method.
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request)
    {
        dd($request);
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
