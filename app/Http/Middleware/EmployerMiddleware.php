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

        $role = Auth::user()->role;

        // Chỉ cho phép employer hoặc admin
        if ($role === 'employer' || $role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }


}
