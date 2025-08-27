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
        // Bắt buộc https khi production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Pagination Bootstrap 5
        // Paginator::useBootstrapFive();

        /**
         * Favicon + SEO Settings (global)
         * Cache 24h, xóa khi admin update
         */
        $favicon = Cache::remember('favicon', now()->addDay(), function () {
            return Logo::select('id','image_path')
                ->where('type', 'site')
                ->where('is_active', true)
                ->first();
        });

        $seo = Cache::remember('seo_settings', now()->addDay(), function () {
            return SeoSetting::select('title', 'description', 'keywords')->first();
        });

        View::share([
            'favicon' => $favicon,
            'seo' => $seo,
        ]);

        /**
         * Employer layout: gắn company cho user login
         * Cache 10 phút theo user_id
         */
        View::composer('employer.layouts.*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $company = Cache::remember("employer_company_{$userId}", now()->addMinutes(60), function () use ($userId) {
                    return Company::select('id')
                        ->where('user_id', $userId)
                        ->first();
                });
                $view->with('employerCompany', $company);
            }
        });

    }
    
}
