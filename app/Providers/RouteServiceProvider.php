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

    // Route::middleware('web')
    //     ->group(base_path('routes/web.php'));

    // Route::middleware('api')
    //     ->prefix('api/admin')
    //     ->group(base_path('routes/api.php'));

    Route::middleware(['api', 'auth:api', 'admin'])
        ->prefix('api')
        ->group(base_path('routes/web.php'));

    // Route::middleware(['api', 'auth:api', 'employer'])
    //     ->prefix('api/employer')
    //     ->group(base_path('routes/employer.php'));

    // Route::middleware(['api', 'auth:api', 'jobseeker'])
    //     ->prefix('api/jobseeker')
    //     ->group(base_path('routes/jobseeker.php'));
}
}
