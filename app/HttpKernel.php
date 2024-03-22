<?php

namespace BangNokia\Pekyll;

use Illuminate\Contracts\Foundation\Application;

//use Illuminate\Foundation\Http\Kernel;
use BangNokia\Pekyll\Router;
use Illuminate\Contracts\Http\Kernel;

class HttpKernel implements Kernel
{
    protected $bootstrappers = [
        \LaravelZero\Framework\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \LaravelZero\Framework\Bootstrap\RegisterFacades::class,
        \LaravelZero\Framework\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    public function __construct(protected Application $app)
    {
        $this->app = $app;
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

        $router = new Router(new ContentFinder(getcwd() . '/content/'));

        return $router->parse($request);
    }

    public function terminate($request, $response)
    {
    }

    public function getApplication()
    {
        return $this->app;
    }
}
