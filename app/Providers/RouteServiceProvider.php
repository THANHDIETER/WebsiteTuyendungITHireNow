<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\AdminMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();


        Route::middleware(['api', 'auth:api', 'admin'])
        ->prefix('api')
        ->group(base_path('routes/web.php'));

    }
}
