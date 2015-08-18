<?php

namespace Wolphy\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

        //Since API is stateless and use no Cookies at all
        //\Wolphy\Http\Middleware\EncryptCookies::class,
        //\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,

        //Disable since API is stateless and session is not based on cookies (CSRF is impossible without the JWT)
        //\Wolphy\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        //'auth' => \Wolphy\Http\Middleware\Authenticate::class,
        //'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        //'guest' => \Wolphy\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
