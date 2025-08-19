<?php

namespace App\Notifications\Admin;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class JobEditedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Job $job)
    {
        //
    }

    /**
     * Kênh gửi notification.
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Dữ liệu lưu DB (table notifications.data) và dùng cho broadcast.
     */
    public function toArray($notifiable): array
    {
        $jobTitle    = (string)($this->job->title ?? 'Tin tuyển dụng');
        $companyName = (string)(optional($this->job->company)->name ?? '');

        // Link ưu tiên trang chi tiết job trong Admin, fallback về trang notifications hoặc /admin
        $link = Route::has('admin.jobs.show')
            ? route('admin.jobs.show', $this->job->id)
            : (Route::has('admin.notifications.index')
                ? route('admin.notifications.index')
                : url('/admin'));

        // Tiêu đề ngắn gọn hiển thị ở UI
        $uiTitle = 'Tin tuyển dụng được cập nhật';

        // Icon gợi ý cho UI (Bootstrap Icons)
        $icon = 'bi-pencil-square';

        // Message chuẩn, có kèm tên công ty nếu có
        $companySuffix = $companyName !== '' ? " của “{$companyName}”" : '';
        $message = "Tin tuyển dụng “{$jobTitle}”{$companySuffix} vừa được nhà tuyển dụng cập nhật. "
            . "Vui lòng xem xét và phê duyệt để đảm bảo nội dung đáp ứng đúng tiêu chuẩn và chính sách của hệ thống.";

        return [
            'type'        => 'admin.job_edited',
            'title'       => $uiTitle,         // 👈 tiêu đề ngắn cho UI
            'icon'        => $icon,            // 👈 icon cho UI
            'job_id'      => $this->job->id,
            'job_title'   => $jobTitle,
            'company'     => $companyName ?: null,
            'message'     => $message,
            'link_url'    => $link,
        ];
    }

    /**
     * Payload cho broadcast realtime (Pusher/Echo).
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
