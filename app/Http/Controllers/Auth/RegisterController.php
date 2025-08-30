<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterEmployerRequest;

use Spatie\Permission\Exceptions\RoleDoesNotExist;
use App\Notifications\Admin\NewEmployerRegisteredNotification;
use App\Notifications\Admin\NewJobseekerRegisteredNotification;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $title = 'Đăng ký';
        return view('auth.register',compact('title'));
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
                'status' => 'active',
            ]);

            // Gán role bằng Spatie (nếu có)
            try {
                $user->assignRole($role);
            } catch (RoleDoesNotExist $e) {
                // Nếu role không tồn tại trong bảng roles => bỏ qua
            }

            // Nếu muốn đăng nhập luôn sau khi đăng ký:
            Auth::login($user);
            return redirect()->route('showLoginForm')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi khi đăng ký: ' . $e->getMessage());
            return redirect()->route('register')->withInput();
        }
    }

    public function showRegisterEmployerForm()
    {
        $title = 'Đăng ký nhà tuyển dụng';
        $locations = Location::all();
        return view('auth.registerEmployer',compact('locations','title'));
    }

    public function registerEmployer(RegisterEmployerRequest $request)
    {
        // dd($request->toArray());
        try {

            $validated = $request->validated();
            $rolee= 'employer';
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                "name" => $validated['full_name'],
                "phone_number" => $validated['phone'],
                'role' => $rolee,
                'status' => 'active',
            ]);

            $company = Company::create([
                'user_id' => $user->id,
                'name' => $validated['company_name'] ?? null,
                'slug' => Str::slug($validated['company_name'] ?? 'company') . '-' . Str::random(12),
                'email' => $validated['email'],
                "address" => $validated['address'],
                'phone' => $validated['phone'] ?? null,
                'city_id' => $validated['city_id'],
                'status' => 'active',
                'is_verified' => false,
            ]);

            try {
                $user->assignRole('employer');
            } catch (RoleDoesNotExist $e) {
                $user->assignRole('job_seeker');
            }
            Auth::login($user);
            session()->flash('success', 'Đăng ký nhà tuyển dụng thành công! Vui lòng cập nhật thông tin công ty.');
            return redirect()->route('employer.companies.show', $company->id);
        } catch (\Exception $e) {
            session()->flash('error', 'Lỗi khi đăng ký nhà tuyển dụng: ' . $e->getMessage());
            return redirect()->route('showRegisterEmployerForm')->withInput();
        }
    }
}
