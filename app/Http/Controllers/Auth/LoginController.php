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
use Illuminate\Support\Str;

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
                'email.email' => 'Email phải có định dạng hợp lệ.',
                'password.required' => 'Mật khẩu là trường bắt buộc.',
                'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]
        );

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            session()->flash('error', 'Email không tồn tại trong hệ thống.');
            return redirect()->back()->withInput();
        }

        // Kiểm tra trạng thái tài khoản
        if ($user->status === 'inactive') {
            session()->flash('error', 'Tài khoản của bạn đang bị khóa. Vui lòng liên hệ quản trị viên.');
            return redirect()->back()->withInput();
        }

        if ($user->status === 'banned') {
            session()->flash('error', 'Tài khoản của bạn đã bị cấm.');
            return redirect()->back()->withInput();
        }

        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            // Tạo token nếu dùng Laravel Sanctum
            $token = $user->createToken('access_token')->plainTextToken;
            session()->flash('access_token', $token);

            // Điều hướng theo vai trò
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'employer':
                    return redirect()->route('employer');
                case 'job_seeker':
                    return redirect()->route('home');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'Tài khoản không hợp lệ.']);
            }
        }

        session()->flash('error', 'Mật khẩu không đúng.');
        return redirect()->back()->withInput();
    }


    public function redirect()
    {
        $provider = new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri' => route('auth.callback'),
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        Session::put('oauth2state', $provider->getState());

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $provider = new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri' => route('auth.callback'),
            'scopes' => ['email', 'profile'],
        ]);

        if ($request->get('state') !== Session::pull('oauth2state')) {
            session()->flash('error', 'Invalid state');
            return redirect()->route('showLoginForm');
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
                session()->flash('error', 'Không thể lấy email từ Google. Vui lòng kiểm tra quyền truy cập.');
                return redirect()->route('showLoginForm');
            }

            $user = User::where('email', $email)->first();

            if ($user) {
                // Kiểm tra trạng thái
                if ($user->status === 'inactive') {
                    session()->flash('error', 'Tài khoản của bạn đang bị khóa.');
                    return redirect()->route('showLoginForm');
                }

                if ($user->status === 'banned') {
                    session()->flash('error', 'Tài khoản của bạn đã bị cấm.');
                    return redirect()->route('showLoginForm');
                }

                // Cập nhật google_id và avatar nếu chưa có
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleId,
                        'avatar' => $avatar,
                    ]);
                }
            } else {
                // Tạo mới người dùng (mặc định là active)
                $user = User::create([
                    'email' => $email,
                    'name' => $name,
                    'password' => Hash::make(Str::random(40)),
                    'role' => 'job_seeker',
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                    'status' => 'active',
                ]);
            }

            Auth::login($user);
            $accessToken = $user->createToken('access_token')->plainTextToken;
            session(['access_token' => $accessToken]);

            return redirect()->route('home');
        } catch (\Exception $e) {
            session()->flash('error', 'Đăng nhập với Google thất bại: ' . $e->getMessage());
            return redirect()->route('showLoginForm');
        }
    }


    public function logout(Request $request)
    {
        // Đăng xuất khỏi session
        Auth::logout();

        // Hủy session hiện tại
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->user() && method_exists($request->user(), 'tokens')) {
            $request->user()->tokens()->delete();
        }


        return redirect('/');


    }

    public function employerDetails()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'employer') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return view('employer.index', compact('user'));
    }
}