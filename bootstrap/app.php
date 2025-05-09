<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\TwoFactor; // ADD THIS

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom route middleware here
        $middleware->alias([
            'TwoFactor' => TwoFactor::class,
            'is_admin' => IsAdmin::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


