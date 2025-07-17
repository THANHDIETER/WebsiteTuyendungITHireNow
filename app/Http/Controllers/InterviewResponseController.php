<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\InterviewResponse;
use App\Notifications\Employer\InterviewRespondedNotification;
use App\Notifications\Jobseeker\InterviewResponseConfirmedNotification;
use Illuminate\Support\Facades\Auth;

class InterviewResponseController extends Controller
{
    public function store(Request $request, $interviewId)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined',
            'note' => 'nullable|string|max:500'
        ]);

        $interview = Interview::findOrFail($interviewId);

        if (Auth::id() !== $interview->jobseeker_id) {
            abort(403, 'Bạn không có quyền phản hồi thư mời này.');
        }

        // Lưu phản hồi
        InterviewResponse::updateOrCreate(
            [
                'interview_id' => $interview->id,
                'jobseeker_id' => Auth::id()
            ],
            [
                'response' => $request->response,
                'note' => $request->note
            ]
        );

        // Gửi thông báo đến nhà tuyển dụng (lấy thông qua job → company → user)
        $employer = $interview->job->company->user ?? null;

        if ($employer) {
            $employer->notify(
                new InterviewRespondedNotification($interview, $request->response, $request->note)
            );
        }

        // Gửi thông báo xác nhận cho ứng viên
        Auth::user()->notify(new InterviewResponseConfirmedNotification($interview));

        return redirect()->back()->with('success', 'Phản hồi của bạn đã được gửi.');
    }
}
