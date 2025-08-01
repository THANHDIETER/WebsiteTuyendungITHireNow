<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
               $notifications = Auth::user()->notifications()->latest()->paginate(10);
        
        // Đánh dấu tất cả đã đọc khi vào trang
        Auth::user()->unreadNotifications->markAsRead();
        return view('website.notifications.index', compact('notifications'));
    }
    


}
