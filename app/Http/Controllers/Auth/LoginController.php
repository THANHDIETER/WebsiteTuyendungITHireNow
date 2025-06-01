<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\Google;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password_hash)) {
        return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
    }

    if ($user->is_blocked) {
        return response()->json(['message' => 'Tài khoản đã bị khóa.'], 403);
    }

    // ✅ Tạo token API
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Đăng nhập thành công',
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}


    public function redirect()
    {
        $provider = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => route('auth.callback'),
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        Session::put('oauth2state', $provider->getState());

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $provider = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => route('auth.callback'),
            'scopes'       => ['email', 'profile'],
        ]);

        if ($request->get('state') !== Session::pull('oauth2state')) {
            session()->flash('error', 'Invalid state');
            return redirect()->route('showLoginForm');
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->get('code')
        ]);

        $googleUser = $provider->getResourceOwner($token);

        // Lấy dữ liệu thô từ Google
        $userData = $googleUser->toArray();
        $email = $userData['email'] ?? null;
        $name = $userData['name'] ?? 'Google User';
        $googleId = $userData['sub'] ?? null;
        $avatar = $userData['picture'] ?? null;

        if (!$email) {
            session()->flash('error', 'Không thể lấy email từ Google. Vui lòng kiểm tra quyền truy cập.');
            return redirect()->route('showLoginForm');
        }

        // Kiểm tra người dùng đã tồn tại chưa
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Tạo người dùng mới nếu chưa tồn tại
            $user = User::create([
                'email' => $email,
                'password_hash' => Hash::make(uniqid()),
                'role' => 'job_seeker',
            ]);
        } else {
            // Cập nhật thông tin nếu người dùng đã tồn tại (tùy chọn)
            $user->update([
                'google_id' => $googleId,
                'avatar' => $avatar,
            ]);
        }

        // Đăng nhập người dùng
        Auth::login($user);

        // Tạo token JWT
        try {
            $jwtToken = JWTAuth::fromUser($user);
            session()->put('access_token', $jwtToken);
            return redirect()->intended(route('list-user'));
        } catch (JWTException $e) {
            return redirect()->route('showLoginForm');
        }
    }
}