<?php

use App\Http\Middleware\EnsureAdminRole;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Đăng ký middleware toàn cục (nếu cần)
        $middleware->alias([
            'admin' => EnsureAdminRole::class,
        ]);

        // Đăng ký middleware cho nhóm route hoặc cụ thể (tùy chọn)
        // $middleware->group('admin', [EnsureAdminRole::class]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
