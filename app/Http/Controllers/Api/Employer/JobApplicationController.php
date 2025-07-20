<?php

namespace App\Http\Controllers\Api\Employer;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\Jobseeker\ApplicationApprovedNotification;
use App\Notifications\Jobseeker\ApplicationRejectedNotification;
use App\Notifications\Jobseeker\InterviewInvitationNotification;
use Illuminate\Support\Facades\Auth;

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

        // ❌ Trạng thái không hợp lệ
        if ($currentIndex === false || $newIndex === false) {
            return response()->json(['message' => 'Trạng thái không hợp lệ.'], 400);
        }


        // ❌ Không cho quay lại trạng thái trước
        if ($newIndex < $currentIndex) {
            return response()->json(['message' => 'Không thể quay lại trạng thái trước.'], 422);
        }


        // ❌ Đơn đã bị từ chối thì không cập nhật nữa
        if ($currentStatus === 'rejected' && $newStatus !== 'rejected') {
            return response()->json(['message' => 'Không thể cập nhật đơn đã bị từ chối.'], 403);
        }

        // ❌ Đơn đã nhận việc thì không cập nhật nữa
        if ($currentStatus === 'hired' && $newStatus !== 'hired') {
            return response()->json(['message' => 'Ứng viên đã nhận việc, không thể thay đổi trạng thái.'], 403);
        }

        // ❌ Đơn đã trúng tuyển thì không thể cập nhật (trừ khi giữ nguyên)
        if ($currentStatus === 'offered' && $newStatus !== 'offered') {
            return response()->json(['message' => 'Ứng viên đã trúng tuyển, không thể thay đổi trạng thái.'], 403);
        }

        // ❌ Nếu đã phỏng vấn rồi, không quay về các bước trước phỏng vấn
        $preInterviewStatuses = [
            'pending',
            'viewed',
            'under_review',
            'contacting',
            'interview_scheduled'
        ];
        if (
            in_array($currentStatus, ['interviewed', 'offered', 'hired']) &&
            in_array($newStatus, $preInterviewStatuses)
        ) {
            return response()->json([
                'message' => 'Không thể quay lại trạng thái trước phỏng vấn.'
            ], 422);
        }

        // ❌ Nếu đã qua ngày phỏng vấn, không được về lại trạng thái trước phỏng vấn
        if (
            !empty($data['interview_date']) &&
            now()->gt($data['interview_date']) &&
            in_array($newStatus, $preInterviewStatuses)
        ) {
            return response()->json([
                'message' => 'Không thể chuyển về trạng thái trước phỏng vấn sau khi ngày phỏng vấn đã trôi qua.'
            ], 422);
        }


        // ✅ Cập nhật
        $jobApplication->update($data);

        // ✅ Gửi thông báo nếu cần
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


        // ✅ Gửi thông báo nếu cần
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
            'message' => 'Cập nhật trạng thái thành công.',
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