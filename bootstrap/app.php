<?php

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\SetValoda;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckPermission;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => CheckPermission::class,
            'admin' => AdminOnly::class,
            'valoda' => SetValoda::class
        ]);

        $middleware->web([
            SetValoda::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
