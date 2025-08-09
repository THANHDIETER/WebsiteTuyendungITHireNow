@extends('employer.layouts.default')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-primary fw-bold">
            <i class="bi bi-bell-fill me-2 text-warning"></i> Tất cả thông báo
        </h2>

        <div id="notification-list">
            @forelse($notifications as $noti)
                <div
                    class="notification-item card shadow-sm mb-3 border-start @if ($noti->read_at) border-secondary @else border-warning @endif border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ $noti->data['link_url'] ?? '#' }}" class="text-decoration-none">
                                <h5 class="mb-1">
                                    <i
                                        class="bi bi-info-circle-fill me-2 @if ($noti->read_at) text-secondary @else text-warning @endif"></i>
                                    {{ $noti->data['message'] }}
                                </h5>
                            </a>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <span
                            class="badge rounded-pill px-3 py-2 fw-semibold 
                            @if ($noti->read_at) bg-secondary text-light
                            @else bg-warning text-dark @endif">
                            {{ $noti->read_at ? 'Đã đọc' : 'Chưa đọc' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    <i class="bi bi-inbox-fill fs-4"></i> <br>
                    Hiện tại bạn chưa có thông báo nào.
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '1ea633f39dfb08c3c0c2',
            cluster: 'ap1',
            forceTLS: true,
        });
    </script>
    <script>
        // Khởi tạo Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });

        // Kênh private dành cho user hiện tại
        const channel = pusher.subscribe('private-App.Models.User.{{ auth()->id() }}');
        console.log(channel);
        console.log('ffff', window.Echo);

        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
            const message = data.notification.message ?? 'Bạn có thông báo mới';
            const link = data.notification.link_url ?? '#';
            const createdAt = new Date().toLocaleString('vi-VN');

            const html = `
                <div class="notification-item card shadow-sm mb-3 border-start border-warning border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <a href="${link}" class="text-decoration-none">
                                <h5 class="mb-1">
                                    <i class="bi bi-info-circle-fill me-2 text-warning"></i>
                                    ${message}
                                </h5>
                            </a>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i> ${createdAt}
                            </small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold bg-warning text-dark">
                            Mới
                        </span>
                    </div>
                </div>
            `;

            // Thêm vào đầu danh sách
            const list = document.getElementById('notification-list');
            list.insertAdjacentHTML('afterbegin', html);
        });
    </script>
@endpush
