<?php

namespace App\Notifications\Admin;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class JobseekerAppliedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Job $job, public User $jobseeker)
    {
        //
    }

    /**
     * Kênh gửi thông báo
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Dữ liệu lưu vào DB (notifications.data) và dùng cho broadcast.
     * Bổ sung title/icon + đảm bảo luôn có message/link_url theo tiêu chuẩn dropdown.
     */
    public function toArray($notifiable): array
    {
        $jobTitle    = (string)($this->job->title ?? 'Vị trí chưa đặt tên');
        $seekerName  = trim((string)($this->jobseeker->name ?? '')) !== ''
            ? (string)$this->jobseeker->name
            : (string)($this->jobseeker->email ?? 'Ứng viên');

        // Ưu tiên điều hướng tới trang quản trị danh sách ứng tuyển có filter theo job_id.
        // Nếu route không tồn tại, fallback về trang danh sách thông báo admin.
        $link = Route::has('admin.job-application.index')
            ? route('admin.job-application.index', ['job_id' => $this->job->id])
            : (Route::has('admin.notifications.index')
                ? route('admin.notifications.index')
                : url('/admin'));

        return [
            'type'             => 'admin.jobseeker_applied',
            'title'            => 'Ứng tuyển mới',               // 👈 tiêu đề ngắn gọn để UI hiển thị đẹp
            'icon'             => 'bi-person-check-fill',        // 👈 gợi ý icon cho UI (Bootstrap Icons)
            'job_id'           => $this->job->id,
            'job_title'        => $jobTitle,
            'jobseeker_id'     => $this->jobseeker->id,
            'jobseeker_name'   => $seekerName,
            'message'          => "Ứng viên “{$seekerName}” vừa ứng tuyển vào vị trí “{$jobTitle}”. Vui lòng kiểm tra và xử lý hồ sơ.",
            'link_url'         => $link,
        ];
    }

    /**
     * Payload broadcast realtime (Pusher/Echo)
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
