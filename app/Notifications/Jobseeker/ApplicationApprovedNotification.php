<?php

namespace App\Notifications\Jobseeker;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Route;

class ApplicationApprovedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(public Job $job)
    {
        //
    }

    /**
     * Gửi qua DB (để lưu) + broadcast (realtime).
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Dữ liệu lưu DB (cột `data`) và cũng là payload phát qua broadcast.
     * Bổ sung title/icon để UI render đẹp hơn.
     */
    public function toArray($notifiable): array
    {
        $jobTitle = $this->job->title ?? 'Vị trí';
        $link     = $this->resolveLink();

        return [
            'type'      => 'jobseeker.application_approved',
            'title'     => 'Hồ sơ được phê duyệt',
            'message'   => "Chúc mừng! Hồ sơ của bạn đã được phê duyệt cho vị trí “{$jobTitle}”. Vui lòng kiểm tra email để xem hướng dẫn tiếp theo hoặc liên hệ nhà tuyển dụng khi cần.",
            'icon'      => 'bi-check-circle-fill', // gợi ý icon cho UI

            // Thông tin tham chiếu
            'job_id'    => $this->job->id,
            'job_title' => $jobTitle,

            // Điều hướng
            'link_url'  => $link,
        ];
    }

    /**
     * Payload phát qua Pusher/Echo (giữ y hệt toArray() để frontend nhận đủ dữ liệu).
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
    