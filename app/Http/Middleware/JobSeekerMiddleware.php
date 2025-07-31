<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !Auth::check() || (Auth::user()->role !== 'job_seeker' &&
                Auth::user()->role !== 'employer' &&
                Auth::user()->role !== 'admin')
        ) {
            return redirect('/showLoginForm');
        }


        return $next($request);
    }
}
