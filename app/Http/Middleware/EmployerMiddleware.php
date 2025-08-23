<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('showLoginForm');
        }

        $user = Auth::user();

        // Chỉ cho phép employer hoặc admin
        if (!in_array($user->role, ['employer', 'admin'])) {
            return redirect()->route('showLoginForm');
        }

        // if ($user->role === 'employer') {
        //     $company = $user->company;

        //     if (!$company->isComplete()) {
        //         return redirect()->route('employer.companies.show', $company->id)
        //             ->with('error', 'Vui lòng cập nhật đầy đủ thông tin công ty trước khi sử dụng các chức năng khác.');
        //     }
        // }


        return $next($request);
    }
}
