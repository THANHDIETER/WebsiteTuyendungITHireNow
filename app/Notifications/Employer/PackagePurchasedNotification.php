<?php

namespace App\Notifications\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PackagePurchasedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $packageName;
    protected $expiresAt;

    public function __construct($packageName, $expiresAt)
    {
        $this->packageName = $packageName;
        $this->expiresAt = $expiresAt;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Bạn đã mua thành công gói "' . $this->packageName . '". Hạn sử dụng đến ngày ' . $this->expiresAt->format('d/m/Y') . '.',
            'link_url' => route('employer.packages.index'),
        ];
    }
}
