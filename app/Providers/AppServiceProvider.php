<?php

namespace App\Providers;
use App\Models\Logo;
use App\Models\Company;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        // Composer cho toàn bộ view
        view()->composer('*', function ($view) {
            // favicon
            $favicon = Logo::where('type', 'site')
                ->where('is_active', true)
                ->first();

            // seo
            $seo = SeoSetting::first();

            $view->with([
                'favicon' => $favicon,
                'seo' => $seo,
            ]);
        });

        // Composer riêng cho layout employer
        View::composer('employer.layouts.*', function ($view) {
            if (Auth::check()) {
                $company = Company::where('user_id', Auth::id())->first();
                $view->with('employerCompany', $company);
            }
        });
    }

}
