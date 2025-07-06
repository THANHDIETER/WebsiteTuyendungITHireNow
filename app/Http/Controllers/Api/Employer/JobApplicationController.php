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
        // === VALIDATE ===
        $data = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in([
                    'pending',
                    'approved',
                    'rejected',
                    'cancelled',
                    'withdrawn',
                    'hired',
                    'archived'
                ]),
            ],
            'application_stage' => [
                'required',
                'string',
                Rule::in([
                    'new',
                    'cv_screening',
                    'phone_screen',
                    'interview_scheduled',
                    'interviewed',
                    'offer_made',
                    'offer_accepted',
                    'offer_declined',
                    'onboarding',
                    'completed'
                ]),
            ],
            'interview_date' => 'nullable|date',
            'note' => 'nullable|string',
            'is_shortlisted' => 'nullable|boolean',
        ]);

        $currentStatus = $jobApplication->status;
        $newStatus = $data['status'];
        $newStage = $data['application_stage'];

        // === MAP TRẠNG THÁI ↔ GIAI ĐOẠN HỢP LỆ ===
        $validStageMap = [
            'pending' => ['new', 'cv_screening', 'phone_screen', 'interview_scheduled'],
            'approved' => ['interview_scheduled', 'interviewed', 'offer_made'],
            'hired' => ['offer_accepted', 'onboarding', 'completed'],
            'rejected' => ['new'],
            'withdrawn' => ['new'],
            'cancelled' => ['new'],
            'archived' => ['completed'],
        ];

        // === RÀNG BUỘC NGHIỆP VỤ ===

        // 1. Đã bị từ chối → không cập nhật nữa
        if ($currentStatus === 'rejected' && $newStatus !== 'rejected') {
            return response()->json(['message' => 'Không thể cập nhật đơn đã bị từ chối.'], 403);
        }

        // 2. Đã duyệt → không thay đổi trạng thái
        if ($currentStatus === 'approved' && $newStatus !== 'approved') {
            return response()->json(['message' => 'Trạng thái đơn đã duyệt không thể thay đổi.'], 403);
        }

        // 3. Ràng buộc stage phù hợp với status
        if (!in_array($newStage, $validStageMap[$newStatus])) {
            return response()->json([
                'message' => "Giai đoạn '{$newStage}' không hợp lệ với trạng thái '{$newStatus}'."
            ], 422);
        }

        // 4. Nếu ngày phỏng vấn đã qua → không cho chuyển về pending/cancelled/withdrawn
        if (
            !empty($data['interview_date']) &&
            now()->gt($data['interview_date']) &&
            in_array($newStatus, ['pending', 'cancelled', 'withdrawn'])
        ) {
            return response()->json([
                'message' => 'Không thể chuyển trạng thái về chờ xử lý sau khi ngày phỏng vấn đã trôi qua.'
            ], 422);
        }

        // === CẬP NHẬT ===
        $jobApplication->update($data);

        // === THÔNG BÁO ===
        $jobseeker = $jobApplication->user;
        $job = $jobApplication->job;

        if ($jobseeker && $job) {
            // Notify duyệt
            if ($currentStatus !== 'approved' && $newStatus === 'approved') {
                $jobseeker->notify(new ApplicationApprovedNotification($job));
            }

            // Notify từ chối
            if ($currentStatus !== 'rejected' && $newStatus === 'rejected') {
                $jobseeker->notify(new ApplicationRejectedNotification($job));
            }

            // Notify thay đổi lịch phỏng vấn
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
