<?php

namespace App\Http\Controllers\Api\Employer;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;
use App\Notifications\Jobseeker\ApplicationApprovedNotification;
use App\Notifications\Jobseeker\ApplicationRejectedNotification;
use App\Notifications\Jobseeker\InterviewInvitationNotification;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with(['job', 'user', 'company']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
                ->orWhereHas('job', function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('company', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        $perPage = $request->input('per_page', 10);
        return $query->orderByDesc('id')->paginate($perPage);
    }


    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['applied_at'] = now();
        return Application::create($data);
    }

    public function show(JobApplication $jobApplication)
    {
        return $jobApplication->load(['job', 'user', 'company']);
        
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $data = $this->validateData($request);

        $currentStatus = $jobApplication->status;
        $newStatus = $data['status'] ?? $currentStatus;

        // 1. Không cho thay đổi nếu đã bị từ chối
        if ($currentStatus === 'rejected' && $newStatus !== 'rejected') {
            return response()->json(['message' => 'Không thể cập nhật đơn đã bị từ chối.'], 403);
        }

        // 2. Đã approved chỉ cho phép chuyển sang rejected hoặc giữ nguyên
        if ($currentStatus === 'approved' && !in_array($newStatus, ['approved'])) {
            return response()->json(['message' => 'Đơn đã duyệt không thể thay đổi.'], 403);
        }

        $jobApplication->update($data);
        // 4. Gửi thông báo nếu trạng thái thay đổi
        $jobseeker = $jobApplication->user;
        $job = $jobApplication->job;

        if ($jobseeker && $job) {
            if ($currentStatus !== 'approved' && $newStatus === 'approved') {
                $jobseeker->notify(new ApplicationApprovedNotification($job));
            }

            if ($currentStatus !== 'rejected' && $newStatus === 'rejected') {
                $jobseeker->notify(new ApplicationRejectedNotification($job));
            }
        }
        // Gửi thông báo mời phỏng vấn nếu có ngày mới
        if (
            !empty($data['interview_date']) &&
            $jobApplication->getOriginal('interview_date') !== $data['interview_date']
        ) {

            $jobseeker->notify(new InterviewInvitationNotification($job, $data['interview_date']));
        }

        return response()->json(['message' => 'Cập nhật thành công', 'data' => $jobApplication]);
    }


    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        return response()->json(['message' => 'Xoá thành công']);
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'image' => 'required|string',
            'cover_letter' => 'nullable|string',
            'status' => 'in:pending,approved,rejected',
            'is_shortlisted' => 'boolean',
            'source' => 'string|max:100',
            'application_stage' => 'nullable|string|max:50',
            'interview_date' => 'nullable|date',
            'note' => 'nullable|string'
        ]);
    }
}
