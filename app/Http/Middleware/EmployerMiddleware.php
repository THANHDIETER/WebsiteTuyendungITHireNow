<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'employer' && Auth::user()->role !== 'admin') {
            return redirect('/showLoginForm');
        }

        return $next($request);
    }
}
