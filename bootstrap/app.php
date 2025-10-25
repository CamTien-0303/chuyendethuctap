<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
        // Trust proxies for Railway/production
        $middleware->trustProxies(at: '*');

=======
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
        $middleware->alias([
            'client.auth' => \App\Http\Middleware\ClientAuth::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'client.only' => \App\Http\Middleware\ClientOnlyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
