<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Notifications\Admin\JobseekerAppliedNotification;
use App\Notifications\Employer\NewApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cv_file' => 'required|file|mimes:pdf|max:5120', // Max 5MB
            'cover_letter' => 'nullable|string|max:1000',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để nộp đơn ứng tuyển.');
        }

        // Kiểm tra xem người dùng đã ứng tuyển cho job này chưa
        $existingApplication = DB::table('job_applications')
            ->where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Bạn đã ứng tuyển cho vị trí này rồi.');
        }

        try {
            // Tạo tên file duy nhất
            $fileName = 'cv_' . Auth::id() . '_' . Str::random(10) . '.pdf';

            // Upload CV file
            $cvPath = $request->file('cv_file')->storeAs('cvs', $fileName, 'public');


            // Create application in job_applications table
            DB::table('job_applications')->insert([
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'company_id' => $job->company_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cv_url' => $cvPath,
                'cover_letter' => $request->cover_letter,
                'status' => 'pending',
                'applied_at' => now(),
                'is_shortlisted' => false,
                'source' => 'website',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Lấy employer của job
            $employer = User::find($job->company->user_id ?? null);
            $jobseeker = Auth::user();

            if ($employer) {
                $employer->notify(new NewApplicationNotification($job, $jobseeker));
            }
            // GỬI THÔNG BÁO CHO ADMIN
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new JobseekerAppliedNotification($job, $jobseeker));
            }


            // Cập nhật thông tin người dùng nếu chưa có
            DB::table('users')
                ->where('id', Auth::id())
                ->update([
                    'name' => $request->full_name,
                    'phone_number' => $request->phone,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'Đơn ứng tuyển của bạn đã được gửi thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, xóa file đã upload (nếu có)
            if (isset($cvPath) && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi gửi đơn ứng tuyển. Vui lòng thử lại sau.')
                ->withInput();
        }
    }



    


}
