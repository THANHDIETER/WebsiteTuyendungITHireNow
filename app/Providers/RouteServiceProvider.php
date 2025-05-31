<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\RoleMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}
