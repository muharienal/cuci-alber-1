<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Rute login kita bernama 'admin.login' (bukan 'login' bawaan Laravel).
        // Tanpa ini, saat sesi habis/belum login, middleware 'auth' akan mencoba
        // redirect ke route('login') yang tidak ada -> fatal RouteNotFoundException.
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Kalau sudah login lalu membuka /admin/login lagi, langsung lempar ke dashboard.
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
