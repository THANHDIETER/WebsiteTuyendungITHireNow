<?php

namespace App\Notifications\Employer;

use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Route;

class PackagePurchasedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(
        public string $packageName,
        public CarbonInterface $expiresAt
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
     * Dữ liệu lưu DB (cột `data`) và dùng chung cho broadcast.
     * Đảm bảo luôn có 'message' và 'link_url' + fallback route an toàn.
     */
    public function toArray($notifiable): array
    {
        $pkg = trim((string) ($this->packageName ?? 'Gói dịch vụ'));
        $expiresIso   = $this->expiresAt->toIso8601String();
        $expiresHuman = $this->expiresAt->format('d/m/Y');

        // Fallback link: packages.index -> employer.dashboard -> employer.notifications.index -> /employer
        $link = Route::has('employer.packages.index')
            ? route('employer.packages.index')
            : (Route::has('employer.dashboard')
                ? route('employer.dashboard')
                : (Route::has('employer.notifications.index')
                    ? route('employer.notifications.index')
                    : url('/employer')));

        return [
            'type'             => 'employer.package_purchased',
            'title'            => "Mua gói “{$pkg}” thành công",
            'package_name'     => $pkg,
            'expires_at'       => $expiresIso,
            'expires_at_human' => $expiresHuman,
            'message'          => "Bạn đã mua thành công gói “{$pkg}”. Thời hạn sử dụng đến ngày {$expiresHuman}.",
            'link_url'         => $link,
        ];
    }

    /**
     * Payload phát qua Pusher/Echo.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        // Phát đúng payload giống DB để dropdown hiển thị ngay nội dung (không còn “Có thông báo mới”)
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
