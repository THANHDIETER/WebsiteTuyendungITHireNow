<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Chỉ admin mới có quyền truy cập.');
        }

        return $next($request);
    }
}