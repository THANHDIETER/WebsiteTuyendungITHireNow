<?php

use Illuminate\Foundation\Application;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployerMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Đăng ký middleware toàn cục (nếu cần)
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'employer' => \App\Http\Middleware\EmployerMiddleware::class,
            'job_seeker' => \App\Http\Middleware\JobSeekerMiddleware::class,
            'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            
            'api' => [
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Ghi đè xử lý lỗi AuthenticationException
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'message' => 'Token không hợp lệ hoặc đã hết hạn',
            ], 401);
        });
    })
    ->create();
