<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\MiddlewareServiceProvider;
use App\Providers\RoleMiddlewareServiceProvider;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booting(function (Application $app) {
        // Register MiddlewareServiceProvider here
        $app->register(provider: MiddlewareServiceProvider::class);
        $app->register(RoleMiddlewareServiceProvider::class);
        $app->singleton('home_route', fn () => env('APP_HOME', '/dashboard'));
    })
    ->create();
