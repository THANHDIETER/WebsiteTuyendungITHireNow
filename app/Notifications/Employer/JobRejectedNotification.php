<?php

namespace App\Notifications\Employer;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Route;

class JobRejectedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(
        public Job $job,
        public ?string $reason = null
    ) {
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
     * Dữ liệu lưu vào bảng notifications (cột `data`) và dùng chung cho broadcast.
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

        // Link xem chi tiết: ưu tiên trang chi tiết job
        $link = Route::has('employer.jobs.show')
            ? route('employer.jobs.show', $this->job->getKey())
            : (Route::has('employer.jobs.index')
                ? route('employer.jobs.index')
                : (Route::has('employer.notifications.index')
                    ? route('employer.notifications.index')
                    : url('/employer')));

        // Ghép message: có lý do thì nối thêm ở cuối
        $message = "Tin tuyển dụng “{$title}” đã bị từ chối duyệt.";
        $reason  = $this->reason ? trim($this->reason) : null;
        if (!empty($reason)) {
            $message .= " Lý do: {$reason}";
        }

        return [
            'type'     => 'employer.job_rejected',
            'job_id'   => $this->job->getKey(),
            'title'    => $title,
            'message'  => $message,
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
