<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa xác thực'], 401);
        }
        
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Bị cấm. Chỉ dành cho quản trị viên.'], 403);
    }
}
