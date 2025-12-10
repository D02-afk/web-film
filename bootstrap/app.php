<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // sẽ tạo ở bước sau

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware mặc định Laravel 11
        $middleware->web(append: [

        ]);

        // Đặt tên ngắn gọn cho middleware thường dùng
        $middleware->alias([
            'auth'    => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest'   => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'admin'   => \App\Http\Middleware\AdminMiddleware::class,     // middleware admin
            'verified'=> \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        // Tự động thêm middleware PreventRequestsDuringMaintenance, ValidateCsrfToken, v.v.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();