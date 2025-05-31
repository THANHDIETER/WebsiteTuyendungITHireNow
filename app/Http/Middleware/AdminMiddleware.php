<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

    if (!Auth::check()) {
        return response()->json(['message' => 'Chưa xác thực'], 401);
    }

    if (Auth::user()->role === 'admin') {
        return $next($request);
    }

    logger('Không phải admin');
    return response()->json(['message' => 'Bị cấm. Chỉ dành cho quản trị viên.'], 403);
    }

}
