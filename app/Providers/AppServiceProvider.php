<?php

namespace App\Providers;

use App\Models\Logo;
use App\Models\Company;
use App\Models\Message;
use App\Models\SeoSetting;
use App\Models\Conversation;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }


    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        $favicon = Cache::rememberForever('settings:favicon', function () {
            return Logo::query()
                ->select('id', 'image_path')
                ->where('type', 'site')
                ->where('is_active', true)
                ->first();
        });

        $seo = Cache::rememberForever('settings:seo', function () {
            return SeoSetting::query()
                ->select('title', 'description', 'keywords')
                ->first();
        });

        View::share(compact('favicon', 'seo'));

        // View::composer('*', function ($view) {
        //     if (!Auth::check()) {
        //         return;
        //     }

        //     $userId = Auth::id();
        //     $conversations = Conversation::query()
        //         ->where(function ($q) use ($userId) {
        //             $q->where('user_one', $userId)
        //                 ->orWhere('user_two', $userId);
        //         })
        //         ->pluck('id');

        //     $totalUnread = 0;
        //     if ($conversations->isNotEmpty()) {
        //         $totalUnread = Message::query()
        //             ->whereNull('read_at')
        //             ->where('sender_id', '!=', $userId)
        //             ->whereIn('conversation_id', $conversations)
        //             ->count();
        //     }

        //     $view->with([
        //         'userConversations' => $conversations->all(),
        //         'totalUnread' => $totalUnread,
        //     ]);
        // });
    }
}
