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
            $existing = DB::table('seeker_profiles')->where('user_id', $userId)->first();
            $data['avatar'] = $existing->avatar ?? null;
        }

        // Update hoặc insert
        $exists = DB::table('seeker_profiles')->where('user_id', $userId)->exists();

        if ($exists) {
            DB::table('seeker_profiles')->where('user_id', $userId)->update($data);
        } else {
            $data['user_id'] = $userId;
            DB::table('seeker_profiles')->insert($data);
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

    public function updateAboutMe(Request $request)
    {
        $request->validate([
            'about_me' => 'nullable|string|max:2500',
        ], [
            'about_me.max' => 'Giới thiệu bản thân không được vượt quá 2500 ký tự.',
        ]);

        $userId = Auth::id();

        // Kiểm tra xem user đã có profile chưa
        $exists = DB::table('seeker_profiles')->where('user_id', $userId)->exists();

        if ($exists) {
            // Cập nhật
            DB::table('seeker_profiles')
                ->where('user_id', $userId)
                ->update([
                    'about_me' => $request->about_me,
                    'updated_at' => now(),
                ]);
        } else {
            // Tạo mới
            DB::table('seeker_profiles')->insert([
                'user_id'   => $userId,
                'about_me'  => $request->about_me,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Cập nhật giới thiệu bản thân thành công!');
    }

    public function updateEducation(Request $request)
    {
        $request->validate([
            'school'     => 'required|string|max:255',
            'field'      => 'nullable|string|max:150',
            'degree'     => 'nullable|string|max:100',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'details'    => 'nullable|string',
        ]);

        $userId = Auth::id();

        DB::table('educations')->insert([
            'user_id'     => $userId,
            'school_name' => $request->school,
            'major'       => $request->field,
            'degree'      => $request->degree,
            'start_date'  => $request->start_date ? $request->start_date . '-01' : null, // input[month] = YYYY-MM
            'end_date'    => $request->end_date ? $request->end_date . '-01' : null,
            'details'     => $request->details,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Thêm học vấn thành công!');
    }

    public function storeWorkExperience(Request $request)
    {
        $request->validate([
            'position'           => 'required|string|max:150',
            'company_name'       => 'required|string|max:255',
            'start_date'         => 'nullable|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'work_description'   => 'nullable|string',
            'project_details'    => 'nullable|string',
        ]);

        DB::table('work_experiences')->insert([
            'user_id'           => Auth::id(),
            'position'          => $request->position,
            'company_name'      => $request->company_name,
            'start_date'        => $request->start_date ? $request->start_date . '-01' : null, // input[month] = YYYY-MM
            'end_date'          => $request->end_date ? $request->end_date . '-01' : null,
            'work_description'  => $request->work_description,
            'project_details'   => $request->project_details,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('success', 'Thêm kinh nghiệm làm việc thành công!');
    }

    public function storeSkills(Request $request)
    {
        $request->validate([
            'group_name' => 'required|in:soft_skills,hard_skills',
            'skill_input' => 'required|string|max:255',
        ]);

        DB::table('skills')->insert([
            'user_id'     => Auth::id(),
            'group_name'  => $request->group_name,
            'skill_name'  => $request->skill_input,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Đã thêm kỹ năng thành công!');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'project_name'        => 'required|string|max:255',
            'start_date'          => 'nullable|date_format:Y-m',
            'end_date'            => 'nullable|date_format:Y-m|after_or_equal:start_date',
            'project_description' => 'nullable|string|max:2500',
            'project_link'        => 'nullable|url|max:255',
        ]);

        $userId = Auth::id();

        DB::table('projects')->insert([
            'user_id'             => $userId,
            'project_name'        => $request->project_name,
            'start_date'          => $request->start_date ? $request->start_date . '-01' : null,
            'end_date'            => $request->end_date ? $request->end_date . '-01' : null,
            'project_description' => $request->project_description,
            'project_link'        => $request->project_link,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        return back()->with('success', 'Đã lưu dự án thành công!');
    }

    public function storeCertificate(Request $request)
    {
        $request->validate([
            'certificate_name'     => 'required|string|max:255',
            'organization'         => 'required|string|max:255',
            'start_date'           => 'nullable|string|regex:/^\d{4}-\d{2}$/',
            'certificate_link'     => 'nullable|url|max:255',
            'project_description'  => 'nullable|string|max:2000',
        ]);

        $startDate = $request->start_date ? $request->start_date . '-01' : null;

        DB::table('certificates')->insert([
            'user_id'              => Auth::id(),
            'certificate_name'     => $request->certificate_name,
            'organization'         => $request->organization,
            'start_date'           => $startDate,
            'certificate_link'     => $request->certificate_link,
            'description'          => $request->project_description,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        return back()->with('success', 'Thêm chứng chỉ thành công!');
    }

    public function storeAward(Request $request)
    {
        $request->validate([
            'award_name'         => 'required|string|max:255',
            'organization'       => 'nullable|string|max:255',
            'start_date'         => 'nullable|string|regex:/^\d{4}-\d{2}$/', // YYYY-MM
            'project_description' => 'nullable|string|max:2000',
        ]);

        $startDate = $request->start_date ? $request->start_date . '-01' : null;

        DB::table('awards')->insert([
            'user_id'     => Auth::id(),
            'award_name'  => $request->award_name,
            'organization' => $request->organization,
            'start_date'  => $startDate,
            'description' => $request->project_description,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Thêm giải thưởng thành công!');
    }

    public function storeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|max:100',
            'language_level' => 'required|in:basic,intermediate,advanced,native',
        ]);

        $userId = Auth::id();

        DB::table('languages')->insert([
            'user_id' => $userId,
            'language_name' => $request->language,
            'proficiency_level' => $request->language_level,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Đã thêm ngoại ngữ thành công!');
    }
}
