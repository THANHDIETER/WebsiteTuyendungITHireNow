<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class JobSeekerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Nếu chưa đăng nhập
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa xác thực'], 401);
        }

<<<<<<< HEAD
        if (Auth::user()->role === 'job_seeker' || Auth::user()->role === 'admin') {
=======
         if (Auth::user()->role === 'job_seeker' || Auth::user()->role === 'admin') {
>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05
            return $next($request);
        }

        return response()->json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }


}
