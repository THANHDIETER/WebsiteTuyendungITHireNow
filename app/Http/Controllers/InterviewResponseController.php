<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InterviewResponse;
use App\Notifications\Employer\InterviewRespondedNotification;
use App\Notifications\Jobseeker\InterviewResponseConfirmedNotification;

class InterviewResponseController extends Controller
{
    public function store(Request $request, $interviewId)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined',
            'note' => 'nullable|string|max:500',
        ]);

        $interview = Interview::with(['job.company.user'])->findOrFail($interviewId);

        // Đảm bảo chỉ jobseeker được phép phản hồi
        if (Auth::id() !== $interview->jobseeker_id) {
            abort(403, 'Bạn không có quyền phản hồi thư mời này.');
        }

        // ⚠ Kiểm tra đã phản hồi chưa
        $existingResponse = InterviewResponse::where('interview_id', $interview->id)
            ->where('jobseeker_id', Auth::id())
            ->first();

        if ($existingResponse) {
            return redirect()->back()->with('error', 'Bạn đã phản hồi buổi phỏng vấn này rồi.');
        }

        // ✅ Lưu phản hồi
        InterviewResponse::create([
            'interview_id' => $interview->id,
            'jobseeker_id' => Auth::id(),
            'response' => $request->response,
            'note' => $request->note,
        ]);

        // 🔔 Gửi thông báo cho nhà tuyển dụng
        $employer = optional(optional($interview->job)->company)->user;
        if ($employer) {
            $employer->notify(new InterviewRespondedNotification($interview, $request->response, $request->note));
        }

        // 🔔 Gửi xác nhận cho ứng viên
        Auth::user()->notify(new InterviewResponseConfirmedNotification($interview));

        return redirect()->back()->with('success', 'Phản hồi của bạn đã được ghi nhận.');
    }
}
 