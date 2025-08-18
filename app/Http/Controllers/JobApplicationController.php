<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\SeekerCV;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Admin\JobseekerAppliedNotification;
use App\Notifications\Employer\NewApplicationNotification;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để nộp đơn ứng tuyển.');
        }

        // Xác định lựa chọn CV
        $cvChoice = $request->input('cv_choice', 'saved');

        // Rule chung
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:1000',
        ];

        // Rule riêng
        if ($cvChoice === 'saved') {
            $rules['cv_id'] = 'required|exists:seeker_cvs,id';
        } else {
            $rules['cv_file'] = 'required|file|mimes:pdf|max:5120';
        }

        $request->validate($rules);

        // Kiểm tra đã ứng tuyển trước đó
        if (JobApplication::where('job_id', $job->id)->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Bạn đã ứng tuyển cho vị trí này rồi.');
        }

        try {
            $cvPath = null;

            if ($cvChoice === 'saved') {
                $cv = SeekerCV::findOrFail($request->cv_id);

                // kiểm tra cột nào có dữ liệu (file_path hoặc image)
                $cvPath = $cv->file_path ?? $cv->image;

                if (!$cvPath) {
                    return redirect()->back()->with('error', 'CV đã chọn không có file.');
                }
            } else {
                $cvPath = $request->file('cv_file')->store('cvs', 'public');
            }


            // Lưu JobApplication
            $application = JobApplication::create([
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'company_id' => $job->company_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $cvPath,
                'cover_letter' => $request->cover_letter,
                'status' => 'pending',
                'applied_at' => now(),
                'is_shortlisted' => false,
                'source' => 'website',
            ]);

            // Thông báo cho employer
            $employer = User::find($job->company->user_id ?? null);
            $jobseeker = Auth::user();
            if ($employer) {
                $employer->notify(new NewApplicationNotification($job, $jobseeker));
            }

            // Thông báo cho admin
            User::where('role', 'admin')->get()->each(function ($admin) use ($job, $jobseeker) {
                $admin->notify(new JobseekerAppliedNotification($job, $jobseeker));
            });

            // Update thông tin user
            Auth::user()->update([
                'name' => $request->full_name,
                'phone_number' => $request->phone,
            ]);

            return redirect()->back()->with('success', 'Đơn ứng tuyển của bạn đã được gửi thành công!');
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTraceAsString());
            Log::error('Job apply error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            if (isset($cvPath) && $cvChoice === 'upload' && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi gửi đơn ứng tuyển. Vui lòng thử lại sau.');
        }

    }
}
