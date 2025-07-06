<?php

namespace App\Http\Controllers\Api\Employer;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;
use App\Notifications\Jobseeker\ApplicationApprovedNotification;
use App\Notifications\Jobseeker\ApplicationRejectedNotification;
use App\Notifications\Jobseeker\InterviewInvitationNotification;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with(['job', 'user', 'company']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('job', function ($q) use ($request) {
                        $q->where('title', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('company', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Lọc theo status nếu có
        if ($request->status) {
            $query->where('status', $request->status);
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
        $data = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in([
                    'pending',
                    'viewed',
                    'under_review',
                    'contacting',
                    'interview_scheduled',
                    'interviewed',
                    'offered',
                    'hired',
                    'candidate_declined',
                    'no_response',
                    'rejected'
                ]),
            ],
            'interview_date' => 'nullable|date',
            'note' => 'nullable|string',
            'is_shortlisted' => 'nullable|boolean',
        ]);

        $currentStatus = $jobApplication->status;
        $newStatus = $data['status'];

        $statusOrder = [
            'pending',
            'viewed',
            'under_review',
            'contacting',
            'interview_scheduled',
            'interviewed',
            'offered',
            'hired',
            'candidate_declined',
            'no_response',
            'rejected',
        ];

        $currentIndex = array_search($currentStatus, $statusOrder);
        $newIndex = array_search($newStatus, $statusOrder);

        // Trạng thái không hợp lệ
        if ($currentIndex === false || $newIndex === false) {
            return response()->json(['message' => 'Trạng thái không hợp lệ.'], 400);
        }

        // Bắt buộc nhập ngày phỏng vấn khi chuyển sang trạng thái 'interview_scheduled'
        if ($newStatus === 'interview_scheduled' && empty($data['interview_date'])) {
            return response()->json(['message' => 'Phải nhập ngày phỏng vấn khi mời phỏng vấn.'], 422);
        }

        // Không cho thay đổi ngày phỏng vấn nếu trạng thái hiện tại >= 'interview_scheduled'
        if (
            $currentIndex >= array_search('interview_scheduled', $statusOrder) &&
            isset($data['interview_date']) &&
            $jobApplication->interview_date != $data['interview_date']
        ) {
            return response()->json(['message' => 'Không được phép thay đổi ngày phỏng vấn khi trạng thái đã đến hoặc qua mời phỏng vấn.'], 422);
        }

        // Không cho quay về trạng thái trước
        if ($newIndex < $currentIndex) {
            return response()->json(['message' => 'Không thể quay lại trạng thái trước.'], 422);
        }

        // Không cho cập nhật đơn đã bị từ chối
        if ($currentStatus === 'rejected' && $newStatus !== 'rejected') {
            return response()->json(['message' => 'Không thể cập nhật đơn đã bị từ chối.'], 403);
        }

        // Không cho cập nhật đơn đã nhận việc
        if ($currentStatus === 'hired' && $newStatus !== 'hired') {
            return response()->json(['message' => 'Không thể thay đổi trạng thái sau khi ứng viên đã nhận việc.'], 403);
        }

        // Nếu đã qua ngày phỏng vấn, không được quay về trạng thái trước phỏng vấn
        if (
            !empty($data['interview_date']) &&
            now()->gt($data['interview_date']) &&
            in_array($newStatus, [
                'pending',
                'viewed',
                'under_review',
                'contacting',
                'interview_scheduled'
            ])
        ) {
            return response()->json([
                'message' => 'Không thể chuyển trạng thái về trước sau khi ngày phỏng vấn đã trôi qua.'
            ], 422);
        }

        // === CẬP NHẬT ===
        $jobApplication->update($data);

        // === GỬI THÔNG BÁO ===
        $jobseeker = $jobApplication->user;
        $job = $jobApplication->job;

        if ($jobseeker && $job) {
            if ($currentStatus !== 'offered' && $newStatus === 'offered') {
                $jobseeker->notify(new ApplicationApprovedNotification($job));
            }

            if ($currentStatus !== 'rejected' && $newStatus === 'rejected') {
                $jobseeker->notify(new ApplicationRejectedNotification($job));
            }

            if (
                !empty($data['interview_date']) &&
                $jobApplication->getOriginal('interview_date') !== $data['interview_date']
            ) {
                $jobseeker->notify(new InterviewInvitationNotification($job, $data['interview_date']));
            }
        }

        return response()->json([
            'message' => 'Cập nhật thành công.',
            'data' => $jobApplication->fresh()
        ]);
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
