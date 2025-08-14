<?php

namespace App\Notifications\Jobseeker;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Route;

class ApplicationRejectedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(
        public Job $job,
        public ?string $reason = null
    ) {}

    /**
     * Lưu DB + phát realtime.
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Payload lưu DB và phát qua broadcast.
     */
    public function toArray($notifiable): array
    {
        $jobTitle = $this->job->title ?? 'Vị trí';
        $link     = $this->resolveLink();

        // Ghép message thân thiện UI
        $msg = "Rất tiếc, đơn ứng tuyển của bạn cho vị trí “{$jobTitle}” chưa được chấp nhận";
        if ($this->reason && trim($this->reason) !== '') {
            // Có thể cắt ngắn lý do nếu quá dài (tuỳ chọn)
            $reason = mb_strimwidth($this->reason, 0, 300, '…', 'UTF-8');
            $msg   .= ". Lý do: {$reason}";
        }
        $msg .= ". Cảm ơn bạn đã quan tâm và ứng tuyển.";

        return [
            'type'       => 'jobseeker.application_rejected',

            // Thêm field UI
            'title'      => 'Đơn ứng tuyển chưa được chấp nhận',
            'icon'       => 'bi-x-circle-fill',
            'message'    => $msg,

            // Tham chiếu
            'job_id'     => $this->job->id,
            'job_title'  => $jobTitle,
            'reason'     => $this->reason,

            // Điều hướng
            'link_url'   => $link,
        ];
    }

    /**
     * Phát qua Pusher/Echo (giữ y hệt toArray()).
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Ưu tiên route chi tiết job nếu có; fallback về trang thông báo.
     */
    private function resolveLink(): string
    {
        if (Route::has('jobs.show')) {
            return route('jobs.show', $this->job->id);
        }

        if (Route::has('job.show')) {
            return route('job.show', $this->job->id);
        }

        return route('notifications.index');
    }
}
