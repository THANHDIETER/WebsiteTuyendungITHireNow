<?php

namespace App\Notifications\Employer;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class JobApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Job $job)
    {
        //
    }

    /**
     * Gửi qua DB + broadcast realtime.
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Payload chuẩn dùng cho cả DB (notifications.data) và broadcast.
     * - Luôn có 'message' và 'link_url'
     * - Fallback link theo thứ tự: employer.jobs.show -> employer.jobs.index -> employer.notifications.index -> /employer
     */
    public function toArray($notifiable): array
    {
        // Tiêu đề an toàn
        $title = trim((string) ($this->job->title ?? ''));
        if ($title === '') {
            $title = 'Tin tuyển dụng #' . ($this->job->getKey() ?? 'N/A');
        }

        // Link xem chi tiết: tuỳ tên route hiện có
        $link = Route::has('employer.jobs.show')
            ? route('employer.jobs.show', $this->job->getKey())
            : (Route::has('employer.jobs.index')
                ? route('employer.jobs.index')
                : (Route::has('employer.notifications.index')
                    ? route('employer.notifications.index')
                    : url('/employer')));

        return [
            'type'     => 'employer.job_approved',
            'job_id'   => $this->job->getKey(),
            'title'    => $title,
            // Nội dung rõ ràng, khớp UI (UI ưu tiên 'message', thiếu mới rơi về 'title')
            'message'  => "Tin tuyển dụng “{$title}” đã được phê duyệt và đang hiển thị tới ứng viên.",
            'link_url' => $link,
        ];
    }

    /**
     * Payload broadcast cho Pusher/Echo (dùng chung với DB).
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
