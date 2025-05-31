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
                return redirect()->route('list-user');
            } catch (JWTException $e) {
                session()->flash('error', 'Không thể tạo token: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        session()->flash('error', 'Mật khẩu không đúng.');
        return redirect()->back()->withInput();
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
