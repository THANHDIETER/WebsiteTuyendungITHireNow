<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\SeekerCV;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Admin\JobseekerAppliedNotification;
use App\Notifications\Employer\NewApplicationNotification;
use App\Jobs\ProcessCvUpload;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập để nộp đơn.'], 401);
        }

        $cvChoice = $request->input('cv_choice', $request->has('cv_id') ? 'saved' : 'upload');

        // Rules
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:250',
        ] + ($cvChoice === 'saved'
            ? ['cv_id' => 'required|exists:seeker_cvs,id']
            : ['cv_file' => 'required|file|mimes:pdf|max:2048'] // 2MB
        );

        $messages = [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'cv_id.required' => 'Bạn phải chọn CV đã lưu.',
            'cv_id.exists' => 'CV đã chọn không tồn tại.',
            'cv_file.required' => 'Bạn phải tải lên file CV.',
            'cv_file.mimes' => 'CV phải là file PDF.',
            'cv_file.max' => 'CV không được vượt quá 2MB.',
        ];

        // Validate
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check duplicate
        if (JobApplication::where('job_id', $job->id)->where('user_id', Auth::id())->exists()) {
            return response()->json(['error' => 'Bạn đã ứng tuyển cho vị trí này rồi.'], 409);
        }

        try {
            $cvPath = null;
            $tempPath = null;

            if ($cvChoice === 'saved') {
                $cvPath = optional(SeekerCV::find($request->cv_id))->file_path ?? null;
                if (!$cvPath) {
                    return response()->json(['error' => 'CV đã chọn không hợp lệ.'], 422);
                }
            } else {
                $filename = 'job' . $job->id . '_' . uniqid() . '.pdf';
                $request->file('cv_file')->move(storage_path('app/tmp'), $filename);
                $tempPath = 'tmp/' . $filename;
            }

            $application = JobApplication::create([
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'company_id' => $job->company_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $cvPath ?? null,
                'cover_letter' => $request->cover_letter,
                'status' => 'pending',
                'applied_at' => now(),
                'is_shortlisted' => false,
                'source' => 'website',
            ]);

            if ($cvChoice === 'upload' && $tempPath) {
                ProcessCvUpload::dispatch($tempPath, $application->id);
            }

            // Notify employer & admin
            if ($employer = $job->company->user ?? null) {
                $employer->notify(new NewApplicationNotification($job, Auth::user()));
            }
            User::where('role', 'admin')
                ->each(fn($admin) => $admin->notify(new JobseekerAppliedNotification($job, Auth::user())));

            return response()->json(['success' => 'Đơn ứng tuyển đã được gửi thành công!']);
        } catch (\Throwable $e) {
            Log::error('Job apply error', ['msg' => $e->getMessage()]);
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }
}
