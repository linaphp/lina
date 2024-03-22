<?php

namespace BangNokia\Pekyll;

use Illuminate\Contracts\Http\Kernel;
use LaravelZero\Framework\Application;
use Symfony\Component\HttpFoundation\Response;

class HttpKernel implements Kernel
{
    protected $app;

//    protected $router;

    public function __construct(Application $app, protected Router $router)
    {
        $this->app = $app;
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
        return $this->router->parse($request);
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    public function getApplication()
    {
        return $this->app;
    }
}
