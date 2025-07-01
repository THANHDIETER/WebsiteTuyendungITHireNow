<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);
        
        // Đánh dấu tất cả đã đọc khi vào trang
        Auth::user()->unreadNotifications->markAsRead();
        return view('employer.notifications.index', compact('notifications'));
    }
}
