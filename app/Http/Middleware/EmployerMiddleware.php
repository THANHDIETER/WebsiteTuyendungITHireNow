<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployerMiddleware
{

    public function handle($request, Closure $next)
    {
        // Nếu chưa đăng nhập
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa xác thực'], 401);
        }

        if (Auth::user()->role === 'employer' || Auth::user()->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }


}
