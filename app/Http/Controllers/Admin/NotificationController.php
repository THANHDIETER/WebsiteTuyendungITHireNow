<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Mail\SystemNotificationMail;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notification::with('user')->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = \App\Models\Notification::with('user')->findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }
    public function create()
    {
        $users = User::select('id', 'email')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'link_url' => 'nullable|string|max:255',
            'user_id' => 'nullable',
        ]);

        if ($request->user_id === 'all') {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => $request->type,
                    'message' => $request->message,
                    'link_url' => $request->link_url,
                ]);
                Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
            }
        } else {
            $user = User::findOrFail($request->user_id);
            Notification::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'message' => $request->message,
                'link_url' => $request->link_url,
            ]);
            Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
        }

        return redirect()->back()->with('success', 'Đã gửi thông báo thành công!');
    }
}
