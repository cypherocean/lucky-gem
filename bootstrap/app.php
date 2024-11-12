<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\MiddlewareServiceProvider;

// Define a global constant for the HOME path
if (!defined('HOME')) {
    define('HOME', '/dashboard'); // Set your default home route here
}


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booting(function (Application $app) {
        // Register MiddlewareServiceProvider here
        $app->register(MiddlewareServiceProvider::class);
    })
    ->create();
