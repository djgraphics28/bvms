<?php

use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\AdminPanelProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            App\Http\Middleware\AddSeoDefaults::class,
        ]);

        $middleware->redirectTo(fn () => Filament\Pages\Dashboard::getUrl());

        $middleware->alias([
            'check.approved' => \App\Http\Middleware\CheckApprovedStatus::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(fn (Throwable $e) => $exceptions->handler->shouldReport($e) &&
            FilamentExceptions::report($e)
        );
    })->create();
