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

        // Favicon + SEO Settings (global)
        $favicon = Cache::rememberForever('favicon', function () {
            return Logo::select('id', 'image_path')
                ->where('type', 'site')
                ->where('is_active', true)
                ->first();
        });

        $seo = Cache::rememberForever('seo_settings', function () {
            return SeoSetting::select('title', 'description', 'keywords')->first();
        });

        View::share(compact('favicon', 'seo'));

        // Employer layout: gắn company cho user login
        View::composer('employer.layouts.*', function ($view) {
            if ($userId = Auth::id()) {
                $company = Cache::remember("employer_company_{$userId}", 600, function () use ($userId) {
                    return Company::select('id')->where('user_id', $userId)->first();
                });
                $view->with('employerCompany', $company);
            }
        });
    }


}
