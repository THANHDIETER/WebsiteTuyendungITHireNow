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
        $user = $request->user(); // Tương thích cho cả Sanctum và Web

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Nếu request là từ API
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden. Admin only.'], 403);
        }

        // Nếu request từ web (giao diện blade)
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
