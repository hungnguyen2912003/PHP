<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\Admin\AuthenticateAdmin;
use App\Http\Middleware\Admin\EnsureRole;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
     ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->alias([
            'admin.auth' => AuthenticateAdmin::class,
            'role'       => EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->view('error.pages.404', [], 404);
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($e instanceof ValidationException || $e instanceof NotFoundHttpException) {
                return null;
            }

            return response()->view('error.pages.500', [
                'exception' => $e
            ], 500);
        });
    })->create();
