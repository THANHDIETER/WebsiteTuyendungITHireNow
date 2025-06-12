<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Xử lý yêu cầu vào route có middleware này.
     */
    public function handle(Request $request, Closure $next)
    {


        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa xác thực'], 401);
        }

        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }
}
