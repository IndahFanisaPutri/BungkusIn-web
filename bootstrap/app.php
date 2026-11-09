<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// File ini menggantikan bootstrap/app.php bawaan Laravel 11.
// Jika file Anda sudah berbeda, cukup salin isi blok ->withMiddleware() saja.
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware 'role' -> dipakai sebagai role:admin, role:merchant, dst.
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // User yang SUDAH login lalu membuka /login atau /register (middleware 'guest')
        // diarahkan ke dashboard sesuai role-nya.
        $middleware->redirectUsersTo(function () {
            return match (auth()->user()?->role) {
                'admin'    => '/admin/dashboard',
                'merchant' => '/merchant/dashboard',
                default    => '/katalog',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
