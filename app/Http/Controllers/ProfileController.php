<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $profile = Auth::user()->profile;
        return view('website.profile.dashboard', compact('profile'));
    }

    public function show()
    {
        $profile = Auth::user()->profile;
        return view('website.profile.profile', compact('profile'));
    }

    public function settings()
    {
        $profile = Auth::user()->profile;
        return view('website.profile.settings', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:nam,nữ,khác',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $userId = Auth::id();

        // Avatar xử lý file
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar'] = Storage::url($path);
        } else {
            $existing = DB::table('profiles')->where('user_id', $userId)->first();
            $data['avatar'] = $existing->avatar ?? null;
        }

        // Update hoặc insert
        $exists = DB::table('profiles')->where('user_id', $userId)->exists();

        if ($exists) {
            DB::table('profiles')->where('user_id', $userId)->update($data);
        } else {
            $data['user_id'] = $userId;
            DB::table('profiles')->insert($data);
        }

        return back()->with('success', 'Cập nhật hồ sơ thành công!');
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'new_password.min'       => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
        ]);

        $userId = Auth::id();
        $user = DB::table('users')->where('id', $userId)->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        DB::table('users')->where('id', $userId)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function myJobs()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Query builder: lấy các job đã ứng tuyển kèm thông tin công ty
        $appliedJobs = DB::table('job_applications')
            ->join('jobs', 'job_applications.job_id', '=', 'jobs.id')
            ->leftJoin('companies', 'jobs.company_id', '=', 'companies.id')
            ->where('job_applications.user_id', $user->id)
            ->select(
                'jobs.id as job_id',
                'jobs.title as job_title',
                'jobs.location',
                'companies.name as company_name',
                'companies.logo_url as company_logo',
                'job_applications.created_at as applied_at'
            )
            ->orderByDesc('applied_at')
            ->get();

        return view('website.profile.myJobs', compact('profile', 'appliedJobs'));
    }
}
