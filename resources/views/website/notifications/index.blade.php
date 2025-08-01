@extends('website.layouts.master1')

@section('title', 'Thông báo')

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <main class="main-content py-4 mx-auto" style="max-width: 800px;">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h4 class="fw-bold text-primary mb-1">
                    <i class="fas fa-bell bell-ring text-warning me-2"></i> Thông báo của bạn
                </h4>
            </div>
        </div>

        <div id="notification-list">
            @forelse($notifications as $noti)
                <div class="notification-card card shadow-sm mb-2 rounded-3 border-start 
                @if (!$noti->read_at) border-warning border-3 bg-light-warning @endif"
                    style="transition: all 0.3s ease; font-size: 0.9rem;">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-start">
                        <div class="noti-content">
                            @php $msg = $noti->data['message'] ?? ''; @endphp
                            <a href="{{ $noti->data['link_url'] ?? '#' }}" class="text-decoration-none text-dark">
                                <h6 class="mb-1 fw-semibold">
                                    {{ is_array($msg) || is_object($msg) ? $msg['message'] ?? '' : $msg }}
                                </h6>
                            </a>
                            <small class="text-muted">{{ $noti->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="noti-status ms-3 text-end">
                            @if ($noti->read_at)
                                <span class="badge bg-secondary">✓</span>
                            @else
                                <span class="badge bg-warning text-dark">Mới</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center rounded-3 shadow-sm small">
                    <i class="bi bi-info-circle me-2"></i> Bạn chưa có thông báo nào.
                </div>
            @endforelse
        </div>

        <div class="mt-3 d-flex justify-content-center small">
            {{ $notifications->links() }}
        </div>
    </main>

    <style>
        .notification-card:hover {
            background-color: #f8f9fa;
            transform: scale(1.005);
        }

        .bg-light-warning {
            background-color: #fffbe6 !important;
        }

        .noti-content h6:hover {
            color: #007bff;
        }

        @keyframes ring {
            0% {
                transform: rotate(0);
            }

            1% {
                transform: rotate(30deg);
            }

            3% {
                transform: rotate(-28deg);
            }

            5% {
                transform: rotate(34deg);
            }

            7% {
                transform: rotate(-32deg);
            }

            9% {
                transform: rotate(30deg);
            }

            11% {
                transform: rotate(-28deg);
            }

            13% {
                transform: rotate(26deg);
            }

            15% {
                transform: rotate(-24deg);
            }

            17% {
                transform: rotate(22deg);
            }

            19% {
                transform: rotate(-20deg);
            }

            21% {
                transform: rotate(18deg);
            }

            23% {
                transform: rotate(-16deg);
            }

            25% {
                transform: rotate(14deg);
            }

            27% {
                transform: rotate(-12deg);
            }

            29% {
                transform: rotate(10deg);
            }

            31% {
                transform: rotate(-8deg);
            }

            33% {
                transform: rotate(6deg);
            }

            35% {
                transform: rotate(-4deg);
            }

            37% {
                transform: rotate(2deg);
            }

            39% {
                transform: rotate(-1deg);
            }

            41% {
                transform: rotate(1deg);
            }

            43% {
                transform: rotate(0);
            }
        }

        .bell-ring {
            display: inline-block;
            animation: ring 1.2s ease-in-out infinite;
            transform-origin: top center;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
        });

        const userId = {{ auth()->id() }};
        if (userId && window.Echo) {
            window.Echo.private(`App.Models.User.${userId}`)
                .notification((notification) => {
                    // Tăng badge số ở chuông
                    const countBadge = document.getElementById('notification-count');
                    if (countBadge) {
                        let currentCount = parseInt(countBadge.textContent || '0');
                        countBadge.textContent = currentCount + 1;
                        countBadge.style.display = 'inline-block';
                    }

                    // Thêm vào đầu danh sách nếu có notification-list
                    const list = document.getElementById('notification-list');
                    if (list) {
                        const message = notification.message ?? 'Bạn có thông báo mới';
                        const link = notification.link_url ?? '#';
                        const createdAt = new Date().toLocaleString('vi-VN');
                        const html = `
                        <div class="notification-card card shadow-sm mb-2 rounded-3 border-start border-warning border-3 bg-light-warning"
                            style="transition: all 0.3s ease; font-size: 0.9rem;">
                            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-start">
                                <div class="noti-content">
                                    <a href="${link}" class="text-decoration-none text-dark">
                                        <h6 class="mb-1 fw-semibold">${message}</h6>
                                    </a>
                                    <small class="text-muted">${createdAt}</small>
                                </div>
                                <div class="noti-status ms-3 text-end">
                                    <span class="badge bg-warning text-dark">Mới</span>
                                </div>
                            </div>
                        </div>
                    `;
                        list.insertAdjacentHTML('afterbegin', html);
                    }
                });
        }
    </script>
@endpush
