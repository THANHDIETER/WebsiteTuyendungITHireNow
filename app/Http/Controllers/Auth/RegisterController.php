<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

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

            $user = User::create([
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password_hash']),
                'role' => $validated['role'] ?? 'job_seeker',
            ]);

            $role = $user->role;
            if (!in_array($role, ['job_seeker', 'employer'])) {
                $role = 'job_seeker'; 
                $user->update(['role' => $role]);
            }
            try {
                $user->assignRole($role);
            } catch (RoleDoesNotExist $e) {
                $user->assignRole('job_seeker');
            }

            Auth::login($user);

            session()->flash('success', 'Đăng ký thành công! Chào mừng bạn đến với hệ thống.');

            return redirect()->route('post-login');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi khi đăng ký: ' . $e->getMessage());
            return redirect()->route('register')->withInput();
        }
    }
}
