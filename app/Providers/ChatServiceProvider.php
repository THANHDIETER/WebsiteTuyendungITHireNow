<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $totalUnread = Message::whereNull('read_at')
                    ->where('sender_id', '!=', $userId)
                    ->whereHas('conversation', function ($q) use ($userId) {
                        $q->where('user_one', $userId)
                          ->orWhere('user_two', $userId);
                    })
                    ->count();

                $view->with('totalUnread', $totalUnread);
            } else {
                $view->with('totalUnread', 0);
            }
        });
    }

   
    public function register(): void
    {
        //
    }
}
