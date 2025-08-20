<?php

namespace App\Providers;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Logo;
use Illuminate\Support\Facades\URL;

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
        if (app()->environment('production')) {
                URL::forceScheme('https');
        }
        Paginator::useBootstrapFive(); 
        view()->composer('*', function ($view) {
            $favicon = Logo::where('type', 'site')
                ->where('is_active', true)
                ->first();
            $view->with('favicon', $favicon);
            View::composer('employer.layouts.*', function ($view) {
                if (Auth::check()) {
                    $company = Company::where('user_id', Auth::id())->first();
                    $view->with('employerCompany', $company);
                }
            });
            
        });
    }
}
