<?php

namespace App;

use Illuminate\Contracts\Http\Kernel;
use Symfony\Component\HttpFoundation\Response;

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
        $path = $request->getPathInfo();

        $response = new Response(
            'hello world',
            200
        );

        return $response;
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
