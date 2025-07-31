<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class ChatServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $conversations = Conversation::with('messages')
                    ->where('user_one', $userId)
                    ->orWhere('user_two', $userId)
                    ->get();

                $totalUnread = $conversations->sum(function ($conv) use ($userId) {
                    return $conv->messages()
                        ->where('sender_id', '!=', $userId)
                        ->whereNull('read_at')
                        ->count();
                });

                $view->with('totalUnread', $totalUnread);
            } else {
                $view->with('totalUnread', 0);
            }
        });
    }

    public function register()
    {
        //
    }
}
