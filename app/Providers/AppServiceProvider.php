<?php

namespace App\Providers;

use App\Models\Logo;
use App\Models\Company;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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

        /**
         * Composer cho toàn bộ view
         * Cache favicon + seo để tránh query lặp
         */
        view()->composer('*', function ($view) {
            // Cache favicon 1h
            $favicon = Cache::remember('favicon', 3600, function () {
                return Logo::where('type', 'site')
                    ->where('is_active', true)
                    ->first();
            });

            // Cache seo settings 1h
            $seo = Cache::remember('seo_settings', 3600, function () {
                return SeoSetting::first();
            });

            $view->with([
                'favicon' => $favicon,
                'seo'     => $seo,
            ]);
        });

        /**
         * Composer riêng cho layout employer
         * Cache company theo user_id trong 10 phút
         */
        View::composer('employer.layouts.*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $company = Cache::remember("employer_company_{$userId}", 600, function () use ($userId) {
                    return Company::where('user_id', $userId)->first();
                });

                $view->with('employerCompany', $company);
            }
        });
    }
}
