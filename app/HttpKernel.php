<?php

namespace BangNokia\Pekyll;

use Illuminate\Contracts\Http\Kernel;
use LaravelZero\Framework\Application;
use Symfony\Component\HttpFoundation\Response;

class HttpKernel implements Kernel
{
    protected $app;

    public function __construct(Application $app)
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
        return $this->app->make(Router::class)->parse($request);
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
