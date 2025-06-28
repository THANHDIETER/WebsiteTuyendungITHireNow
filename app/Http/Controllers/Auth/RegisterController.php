<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use App\Http\Requests\RegisterEmployerRequest;
use App\Notifications\Admin\NewJobseekerRegisteredNotification;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            // Luôn gán role mặc định là 'job_seeker'
            $role = 'job_seeker';

            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
            ]);
            // Gửi thông báo cho admin khi jobseeker đăng ký
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewJobseekerRegisteredNotification($user));
            }

            // Gán role bằng Spatie (nếu có)
            try {
                $user->assignRole($role);
            } catch (RoleDoesNotExist $e) {
                // Nếu role không tồn tại trong bảng roles => bỏ qua
            }

            // Nếu muốn đăng nhập luôn sau khi đăng ký:
            // Auth::login($user);

            // Trả về view login (hoặc redirect nếu bạn dùng route login)
            return redirect()->route('showLoginForm')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi khi đăng ký: ' . $e->getMessage());
            return redirect()->route('register')->withInput();
        }
    }

    public function showRegisterEmployerForm()
    {
        return view('auth.registerEmployer');
    }

    public function registerEmployer(RegisterEmployerRequest $request)
    {
        try {
            // dd('Form đã gửi thành công vào POST!');

            $validated = $request->validated();

            // Đảm bảo vai trò là 'employer'
            $validated['role'] = 'employer';

            // Tạo tài khoản cho Employer
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'employer', // Mặc định vai trò là employer
            ]);
            // Gửi thông báo cho admin khi employer đăng ký
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewEmployerRegisteredNotification($user));
            }

            // Gán vai trò cho người dùng
            try {
                $user->assignRole('employer');
            } catch (RoleDoesNotExist $e) {
                $user->assignRole('job_seeker');  // Mặc định gán vai trò 'job_seeker' nếu không có role 'employer'
            }

            session()->flash('success', 'Đăng ký nhà tuyển dụng thành công! Bạn có thể đăng nhập ngay.');
            return redirect()->route('showLoginForm');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi khi đăng ký nhà tuyển dụng: ' . $e->getMessage());
            return redirect()->route('showRegisterEmployerForm')->withInput();
        }
    }
}
