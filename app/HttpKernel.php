<?php

namespace BangNokia\Pekyll;

use Illuminate\Contracts\Http\Kernel;
use Symfony\Component\HttpFoundation\Response;

class HttpKernel implements Kernel
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

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
        return $this->router->handle($request);
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    public function getApplication()
    {
    }
}
