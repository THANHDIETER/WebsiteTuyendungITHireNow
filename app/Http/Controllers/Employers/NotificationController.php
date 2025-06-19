<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('employer.notifications.index', compact('notifications'));
    }
}
