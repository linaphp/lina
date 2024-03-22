<?php

namespace BangNokia\Pekyll;

use Illuminate\Contracts\Http\Kernel;
use LaravelZero\Framework\Application;
use Symfony\Component\HttpFoundation\Response;

class HttpKernel implements Kernel
{
    protected $app;

    public function __construct(Application $app, protected Router $router)
    {
        $this->app = $app;
    }

    public function bootstrap()
    {
//        if (! $this->app->hasBeenBootstrapped()) {
//            $this->app->bootstrapWith([
////                \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
//                \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
////                \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
////                \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
//                \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
//                \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
//                \Illuminate\Foundation\Bootstrap\BootProviders::class,
//            ]);
//        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request)
    {
//        $this->bootstrap();

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
