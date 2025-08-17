<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Logo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive(); // or Paginator::useTailwind();
         view()->composer('*', function ($view) {
        $favicon = Logo::where('type', 'site')
            ->where('is_active', true)
            ->first();
        $view->with('favicon', $favicon);
    });
    }
}
