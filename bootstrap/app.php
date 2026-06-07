<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web     : __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health  : '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class,
        ]);

        $middleware->alias([
            'permission'  => \App\Http\Middleware\CheckPermission::class,
            'role'        => \App\Http\Middleware\CheckRole::class,
            'user.status' => \App\Http\Middleware\CheckUserStatus::class,
        ]);
    })
    ->withProviders([
        \App\Providers\AuthServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (\Throwable $e, Request $request) {

            $status = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode() : 500;

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'An error occurred.',
                ], $status);
            }

            $viewMap = [
                403 => 'errors.403',
                404 => 'errors.404',
            ];

            if (isset($viewMap[$status]) && view()->exists($viewMap[$status])) {
                return response()->view($viewMap[$status], ['exception' => $e], $status);
            }

            return null;
        });
    })->create();
