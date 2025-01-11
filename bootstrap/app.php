<?php

use App\Http\Middleware\CheckAdminLogin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckGuestAndRespond;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckAdminRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.guest' => CheckGuestAndRespond::class,
            'check.user' => CheckUserRole::class,
            'check.admin' => CheckAdminRole::class,
            'check.admin.login' => CheckAdminLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
