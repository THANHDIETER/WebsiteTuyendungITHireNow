<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Tìm user theo email
        $user = User::where('email', $request->email)->first();

        // Kiểm tra tồn tại
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }

        // Kiểm tra trạng thái
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Tài khoản của bạn đang bị khóa hoặc chưa kích hoạt.']);
        }

        // Gửi mail đặt lại mật khẩu
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Đã gửi link đặt lại mật khẩu!')
            : back()->withErrors(['email' => __($status)]);
    }
}
