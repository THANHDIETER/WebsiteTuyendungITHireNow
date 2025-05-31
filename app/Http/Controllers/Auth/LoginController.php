<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email không tồn tại trong hệ thống.');
        }

        if (!Hash::check($credentials['password'], $user->password_hash)) {
            return redirect()->back()->withInput()->with('error', 'Mật khẩu không đúng.');
        }

        if ($user->is_blocked) {
            return redirect()->back()->withInput()->with('error', 'Tài khoản đã bị khóa.');
        }

        Auth::login($user);

        return redirect()->route('list-user');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công');
    }

    // ---------- GOOGLE LOGIN ----------
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
            return redirect()->route('login')->with('error', 'Invalid state');
        }

        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

            $googleUser = $provider->getResourceOwner($token);
            $userData = $googleUser->toArray();

            $email = $userData['email'] ?? null;
            $name = $userData['name'] ?? 'Google User';
            $googleId = $userData['sub'] ?? null;
            $avatar = $userData['picture'] ?? null;

            if (!$email) {
                return redirect()->route('login')->with('error', 'Không lấy được email từ Google.');
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'password_hash' => Hash::make(uniqid()),
                    'role' => 'job_seeker',
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                ]);
            } else {
                $user->update([
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                ]);
            }

            Auth::login($user);
            return redirect()->intended(route('list-user'));

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Lỗi khi đăng nhập bằng Google: ' . $e->getMessage());
        }
    }
}
