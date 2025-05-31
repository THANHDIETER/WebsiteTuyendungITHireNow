<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureAdminRole
{
   public function handle(Request $request, Closure $next): Response
    {
        $guard = $request->is('api/*') ? 'api' : 'web';
        $user = Auth::guard($guard)->user();

        if (!$user || (JWTAuth::parseToken()->getClaim('role') !== 'admin' && $user->role !== 'admin')) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chỉ admin mới có quyền truy cập.',
                ], 403);
            }
            abort(403, 'Chỉ admin mới có quyền truy cập.');
        }

        return $next($request);
    }
}