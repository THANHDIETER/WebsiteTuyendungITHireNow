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

        // FE gửi cv_choice = "select" hoặc "upload"
        $cvChoice = $request->input('cv_choice');

        // Validation rules
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:250',
        ];

        if ($cvChoice === 'select') {
            $rules['cv_select'] = 'required|exists:seeker_cvs,id';
        } else {
            $rules['cv_file'] = 'required|file|mimes:pdf|max:2048'; // 2MB
        }

        $messages = [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'cv_select.required' => 'Bạn phải chọn CV đã lưu.',
            'cv_select.exists' => 'CV đã chọn không tồn tại.',
            'cv_file.required' => 'Bạn phải tải lên file CV.',
            'cv_file.mimes' => 'CV phải là file PDF.',
            'cv_file.max' => 'CV không được vượt quá 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check duplicate application
        if (JobApplication::where('job_id', $job->id)->where('user_id', Auth::id())->exists()) {
            return response()->json(['error' => 'Bạn đã ứng tuyển cho vị trí này rồi.'], 409);
        }

        try {
            $cvPath = null;
            $tempPath = null;

            if ($cvChoice === 'select') {
                $cvPath = optional(SeekerCV::find($request->cv_select))->file_path ?? null;
                if (!$cvPath) {
                    return response()->json(['error' => 'CV đã chọn không hợp lệ.'], 422);
                }
            } else {
                // Upload CV mới → chỉ lưu tạm, không block request
                $filename = 'job' . $job->id . '_' . uniqid() . '.pdf';
                $tempPath = $request->file('cv_file')->storeAs('tmp', $filename);

                Log::info('Upload CV mới tạm thành công', [
                    'user_id' => Auth::id(),
                    'job_id' => $job->id,
                    'path' => $tempPath,
                ]);
            }

            // Tạo application
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

            // Đẩy job xử lý CV mới (async)
            if ($cvChoice === 'upload' && $tempPath) {
                $finalPath = Storage::putFile('cvs', $request->file('cv_file'));

                // Cập nhật application ngay lập tức với CV đã lưu
                $application->update([
                    'image' => $finalPath,
                ]);

                Log::info('CV upload trực tiếp thành công', [
                    'user_id' => Auth::id(),
                    'job_id' => $job->id,
                    'path' => $finalPath,
                ]);
            }

            // Notify employer & admin
            if ($employer = $job->company->user ?? null) {
                $employer->notify(new NewApplicationNotification($job, Auth::user()));
            }
            User::where('role', 'admin')
                ->each(fn($admin) => $admin->notify(new JobseekerAppliedNotification($job, Auth::user())));

            return response()->json(['success' => 'Đơn ứng tuyển đã được gửi thành công!']);
        } catch (\Throwable $e) {
            Log::error('Job apply error', [
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'msg' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }
}
