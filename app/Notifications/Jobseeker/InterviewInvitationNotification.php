<?php

namespace App\Notifications\Jobseeker;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InterviewInvitationNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(
        public Job $job,
        public string|\DateTimeInterface $interviewDateTime
    ) {}

    public function via($notifiable): array
    {
        // broadcast để realtime, database để hiển thị lại sau
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $timeText = $this->formatTime($this->interviewDateTime);

        return [
            'type'         => 'jobseeker.interview_invitation',
            // --------- Các field “thân thiện UI” ----------
            'title'        => 'Mời phỏng vấn',
            'message'      => "Bạn được mời phỏng vấn cho vị trí “{$this->job->title}” vào lúc {$timeText}.",
            'icon'         => 'bi-bell',             // gợi ý icon để UI hiển thị
            // ----------------------------------------------
            'job_id'       => $this->job->id,
            'job_title'    => $this->job->title,
            // Nên trỏ tới trang chi tiết lịch hẹn/phỏng vấn của job (điều chỉnh route theo app của bạn)
            // Ví dụ nếu có route: jobseeker.interviews.show
            'link_url'     => route('notifications.index'),
            // -> nếu có route cụ thể, thay bằng:
            // 'link_url'     => route('jobseeker.interviews.show', ['job' => $this->job->id]),

            'scheduled_at' => Carbon::parse($this->interviewDateTime)->toIso8601String(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        // Giữ payload y hệt toArray() -> frontend nhận evt.id + evt.data.{...}
        return new BroadcastMessage($this->toArray($notifiable));
    }

    private function formatTime(string|\DateTimeInterface $datetime): string
    {
        return Carbon::parse($datetime)
            ->timezone(config('app.timezone'))   // đảm bảo theo timezone app
            ->format('H:i d/m/Y');
    }
}
