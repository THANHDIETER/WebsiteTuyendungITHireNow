<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   protected function redirectTo($request)
{
    if ($request->expectsJson()) {
        abort(response()->json(['message' => 'Chưa xác thực'], 401));
    }
    return route('login');
}

}
