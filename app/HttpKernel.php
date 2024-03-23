<?php

namespace BangNokia\Lina;

use Illuminate\Contracts\Foundation\Application;

//use Illuminate\Foundation\Http\Kernel;
use BangNokia\Lina\Router;
use Illuminate\Contracts\Http\Kernel;

class HttpKernel implements Kernel
{
    protected array $bootstrappers = [
        \LaravelZero\Framework\Bootstrap\LoadConfiguration::class,
        \LaravelZero\Framework\Bootstrap\RegisterFacades::class,
        \LaravelZero\Framework\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    protected Application $app;

    protected Router $router;

    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    public function bootstrap()
    {
        if (!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers);
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request)
    {
        $this->bootstrap();

        return $this->router->parse($request);
    }

    public function terminate($request, $response)
    {
    }

    public function getApplication()
    {
        return $this->app;
    }
}
