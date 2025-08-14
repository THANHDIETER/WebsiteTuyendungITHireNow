<?php

namespace App\Notifications\Employer;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Route;

class NewApplicationNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(
        public Job  $job,
        public User $jobseeker
    ) {
        //
    }

    /**
     * Kênh gửi: lưu DB + phát realtime.
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Dữ liệu lưu vào cột `data` (bảng notifications) — dùng chung cho broadcast.
     * - Luôn có 'message' và 'link_url'
     * - Fallback link: employer.jobs.applications -> employer.jobs.index -> employer.notifications.index -> /employer
     */
    public function toArray($notifiable): array
    {
        // Tiêu đề job an toàn
        $title = trim((string) ($this->job->title ?? ''));
        if ($title === '') {
            $title = 'Tin tuyển dụng #' . ($this->job->getKey() ?? 'N/A');
        }

        // Tên ứng viên an toàn
        $seekerName = trim((string) ($this->jobseeker->name ?? $this->jobseeker->email ?? 'Ứng viên'));

        // Link danh sách hồ sơ ứng tuyển (kèm filter job_id nếu muốn)
        $link = Route::has('employer.jobs.applications')
            ? route('employer.jobs.applications', ['job_id' => $this->job->getKey()])
            : (Route::has('employer.jobs.index')
                ? route('employer.jobs.index')
                : (Route::has('employer.notifications.index')
                    ? route('employer.notifications.index')
                    : url('/employer')));

        return [
            'type'         => 'employer.new_application',
            'job_id'       => $this->job->getKey(),
            'job_title'    => $title,
            'seeker_id'    => $this->jobseeker->getKey(),
            'seeker_name'  => $seekerName,
            'message'      => "Bạn vừa nhận được hồ sơ ứng tuyển mới: {$seekerName} đã ứng tuyển vào vị trí “{$title}”.",
            'link_url'     => $link,
        ];
    }

    /**
     * Payload broadcast cho Pusher/Echo.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
