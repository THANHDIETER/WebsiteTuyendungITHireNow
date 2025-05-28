<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Email hoặc mật khẩu không đúng',
                ], 401);
            }

            $user = auth('api')->user();

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    // 'permissions' => $user->getAllPermissions()->pluck('name'),
                ],
                'token' => $token,
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Không thể tạo token: ' . $e->getMessage(),
            ], 500);
        }
    }
}
