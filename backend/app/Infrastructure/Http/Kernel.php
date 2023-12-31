<?php

namespace App\Infrastructure\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Infrastructure\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        //        \Illuminate\Session\Middleware\StartSession::class,
        //        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Infrastructure\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Infrastructure\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Infrastructure\Http\Middleware\SetLocales::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Infrastructure\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Infrastructure\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class
            //            \App\Infrastructure\Http\Middleware\EncryptCookies::class,
            //            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            //            \Illuminate\Session\Middleware\StartSession::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                 => \App\Infrastructure\Http\Middleware\Authenticate::class,
        'auth.basic'           => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers'        => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'                  => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'                => \App\Infrastructure\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm'     => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'               => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'             => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'             => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'SuperAdminMiddleware' => \App\Infrastructure\Http\Middleware\SuperAdminMiddleware::class,
        'StoreMiddleware'      => \App\Infrastructure\Http\Middleware\StoreMiddleware::class,
        'CenterMiddleware'     => \App\Infrastructure\Http\Middleware\CenterMiddleware::class,
        'IsActiveUser'         => \App\Infrastructure\Http\Middleware\IsActiveUser::class,
        'IsActiveAdmin'        => \App\Infrastructure\Http\Middleware\IsActiveAdmin::class,
        'Delivery'             => \App\Infrastructure\Http\Middleware\Delivery::class,
        'IsActiveDelivery'     => \App\Infrastructure\Http\Middleware\IsActiveDelivery::class,
        'CompanyMiddleware'     => \App\Infrastructure\Http\Middleware\CompanyMiddleware::class,
    ];
}
