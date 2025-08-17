@extends('employer.layouts.default')

@section('content')
    <div class="container py-5 d-flex justify-content-center align-items-start" style="min-height: 75vh;">
        <div class="notification-page-wrapper-card w-100" style="max-width: 900px;">
            <div class="p-4">
                <h2 class="mb-4 text-primary fw-bold d-flex align-items-center">
                    <i class="bi bi-bell-fill me-2 text-warning fs-2"></i> Tất cả thông báo
                </h2>
                <div id="notification-list">
                    @forelse($notifications as $noti)
                        <div class="notification-item card shadow-none mb-3 border-0 notification-hover"
                            data-id="{{ $noti->id }}" style="cursor:pointer;">
                            <div
                                class="d-flex align-items-center gap-3 px-3 py-3 rounded-3 border 
                            @if ($noti->read_at) border-secondary bg-light text-secondary 
                            @else border-warning bg-warning bg-opacity-10 text-dark @endif
                            position-relative">
                                {{-- Avatar/icon --}}
                                <div class="notif-avatar flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center 
                                @if ($noti->read_at) bg-light text-secondary @else bg-warning bg-opacity-75 text-warning @endif
                                shadow-sm"
                                    style="width:48px;height:48px;font-size:1.6rem;">
                                    <i class="bi bi-bell"></i>
                                </div>
                                {{-- Nội dung --}}
                                <div class="flex-grow-1">
                                    <div class="fw-semibold fs-6 mb-1 d-flex align-items-center">
                                        <span class="truncate-2">{!! $noti->data['message'] ?? '<em>Bạn có thông báo mới!</em>' !!}</span>
                                        @if (!empty($noti->data['link_url']))
                                            <a href="{{ $noti->data['link_url'] }}"
                                                class="ms-2 text-primary fs-6 d-inline-flex align-items-center"
                                                title="Xem chi tiết">
                                                {{-- <i class="bi bi-arrow-right-circle-fill"></i> --}}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="small text-muted d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                {{-- Trạng thái --}}
                                <div class="ms-2">
                                    <span
                                        class="badge rounded-pill px-3 py-2 fw-semibold align-middle border-0 shadow-sm
                                    @if ($noti->read_at) bg-secondary text-light
                                    @else bg-warning text-dark @endif"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="{{ $noti->read_at ? 'Đã đọc' : 'Thông báo mới' }}">
                                        <i
                                            class="bi 
                                        @if ($noti->read_at) bi-envelope-open-fill text-light
                                        @else bi-envelope-fill animate__animated animate__heartBeat animate__repeat-2 text-warning @endif"></i>
                                        <span class="align-middle ms-1">{{ $noti->read_at ? 'Đã đọc' : 'Mới' }}</span>
                                    </span>
                                </div>
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
        </div>
    </div>
    <style>
        body {
            background: linear-gradient(100deg, #f0f4fd 10%, #e2ecff 100%);
        }

        .notification-page-wrapper-card {
            border: 3px solid #5e72e4;
            border-radius: 22px;
            box-shadow: 0 6px 36px #0d21410a, 0 1.5px 6px #0055ff15;
            background: #fcfcfd;
            margin: 0 auto;
            min-height: 400px;
            overflow: hidden;
            transition: box-shadow .22s;
        }

        .notification-page-wrapper-card:hover {
            box-shadow: 0 8px 40px #0d21412a, 0 2px 12px #0055ff22;
        }

        .notification-item:hover .border-warning,
        .notification-item:hover .border-secondary {
            border-left-width: 8px !important;
        }

        .notification-item:hover {
            box-shadow: 0 4px 24px #1a2b5912;
            z-index: 3;
            transform: translateY(-2px) scale(1.012);
            background: #f8fafd;
        }

        .notif-avatar {
            box-shadow: 0 2px 9px #ffc10726;
            font-weight: bold;
            transition: background .15s;
        }

        .truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 340px;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        // Khởi tạo Echo
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '1ea633f39dfb08c3c0c2',
            cluster: 'ap1',
            forceTLS: true,
        });

        // Realtime notification (realtime render)
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ auth()->id() }};
            const list = document.getElementById('notification-list');

            if (window.Echo && userId && list) {
                window.Echo.private(`App.Models.User.${userId}`)
                    .notification(function(notification) {
                        let html = `
                    <div class="notification-item card shadow-none mb-3 border-0 notification-hover" data-id="${notification.id}" style="cursor:pointer;">
                        <div class="d-flex align-items-center gap-3 px-3 py-3 rounded-3 border border-warning bg-warning bg-opacity-10 position-relative">
                            <div class="notif-avatar flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-75 text-warning shadow-sm" style="width:48px;height:48px;font-size:1.6rem;">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold fs-6 mb-1 d-flex align-items-center">
                                    <span class="truncate-2">${notification.data.message || '<em>Bạn có thông báo mới!</em>'}</span>
                                    ${notification.data.link_url ? `<a href="${notification.data.link_url}" class="ms-2 text-primary fs-6 d-inline-flex align-items-center" title="Xem chi tiết"><i class="bi bi-arrow-right-circle-fill"></i></a>` : ''}
                                </div>
                                <div class="small text-muted d-flex align-items-center">
                                    <i class="bi bi-clock me-1"></i> Vừa xong
                                </div>
                            </div>
                            <div class="ms-2">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold bg-warning text-dark align-middle border-0 shadow-sm"
                                    data-bs-toggle="tooltip" data-bs-title="Thông báo mới">
                                    <i class="bi bi-envelope-fill animate__animated animate__heartBeat animate__repeat-2 text-warning"></i>
                                    <span class="align-middle ms-1">Mới</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    `;
                        list.insertAdjacentHTML('afterbegin', html);

                        // Giữ tối đa 10 notification đầu trang
                        const items = list.querySelectorAll('.notification-item');
                        if (items.length > 10) {
                            items[items.length - 1].remove();
                        }
                        // Tooltip Bootstrap nếu có
                        if (window.bootstrap) {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                                '[data-bs-toggle="tooltip"]'));
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        }
                    });
            }

            // Đánh dấu đã đọc riêng lẻ (ajax)
            document.getElementById('notification-list').addEventListener('click', function(e) {
                let card = e.target.closest('.notification-item');
                if (!card) return;

                let id = card.dataset.id;
                if (!id) return;

                // Gọi AJAX đánh dấu đã đọc
                fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Đổi style giao diện
                            let inner = card.querySelector('.d-flex.align-items-center');
                            inner.classList.remove('border-warning', 'bg-warning', 'bg-opacity-10',
                                'text-dark');
                            inner.classList.add('border-secondary', 'bg-light', 'text-secondary');
                            let badge = card.querySelector('.badge');
                            badge.innerHTML =
                                `<i class="bi bi-envelope-open-fill text-light"></i> <span class="align-middle ms-1">Đã đọc</span>`;
                            badge.classList.remove('bg-warning', 'text-dark');
                            badge.classList.add('bg-secondary', 'text-light');
                            let icon = card.querySelector('.notif-avatar');
                            if (icon) {
                                icon.classList.remove('bg-warning', 'bg-opacity-75', 'text-warning');
                                icon.classList.add('bg-light', 'text-secondary');
                            }
                        }
                    });
            });

            // Bootstrap Tooltip cho badge
            if (window.bootstrap) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });
    </script>
@endpush