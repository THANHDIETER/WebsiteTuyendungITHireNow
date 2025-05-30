<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required' => 'Email là trường bắt buộc.',
                'email.string' => 'Email phải là một chuỗi ký tự.',
                'email.email' => 'Email phải có định dạng hợp lệ.',
                'password.required' => 'Mật khẩu là trường bắt buộc.',
                'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]
        );

        if (!$credentials['email'] || !$credentials['password']) {
            session()->flash('error', 'Email và mật khẩu là bắt buộc.');
            return redirect()->back()->withInput();
        }

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            session()->flash('error', 'Email không hợp lệ.');
            return redirect()->back()->withInput();
        }

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            session()->flash('error', 'Email không tồn tại trong hệ thống.');
            return redirect()->back()->withInput();
        }

        if (Auth::attempt($credentials)) {
            try {
                $token = JWTAuth::fromUser($user);
                session()->flash('access_token', $token);
                return redirect()->intended(route('admin.user'));
            } catch (JWTException $e) {
                session()->flash('error', 'Không thể tạo token: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        session()->flash('error', 'Mật khẩu không đúng.');
        return redirect()->back()->withInput();
    }
}
