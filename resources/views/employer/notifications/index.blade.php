@extends('employer.layouts.default')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container py-5 d-flex justify-content-center align-items-start" style="min-height: 75vh;">
        <div class="notification-page-wrapper-card w-100" style="max-width: 900px;">
            <div class="p-4">
                <h2 class="mb-4 text-primary fw-bold d-flex align-items-center">
                    <i class="bi bi-bell-fill me-2 text-warning fs-2"></i> Tất cả thông báo
                </h2>

                <div id="notification-list">
                    @forelse($notifications as $noti)
                        @php
                            // Lấy toàn bộ message, không dùng fallback "Bạn có thông báo mới!"
                            $msg = $noti->data['message'] ?? '';
                            if (is_array($msg)) {
                                // Nếu là mảng, ưu tiên key 'message', nếu không thì stringify toàn bộ
                                $msg = $msg['message'] ?? json_encode($msg, JSON_UNESCAPED_UNICODE);
                            }
                            $link = $noti->data['link_url'] ?? '#';
                        @endphp

                        <div class="notification-item card shadow-none mb-3 border-0 notification-hover"
                             data-id="{{ $noti->id }}" data-link="{{ $link }}" style="cursor:pointer;">
                            <div
                                class="d-flex align-items-start gap-3 px-3 py-3 rounded-3 border
                                {{ $noti->read_at ? 'border-secondary bg-light text-secondary' : 'border-warning bg-warning bg-opacity-10 text-dark' }}
                                position-relative">

                                {{-- Avatar/icon --}}
                                <div class="notif-avatar flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center
                                    {{ $noti->read_at ? 'bg-light text-secondary' : 'bg-warning bg-opacity-75 text-warning' }} shadow-sm"
                                     style="width:48px;height:48px;font-size:1.6rem;">
                                    <i class="bi bi-bell"></i>
                                </div>

                                {{-- Nội dung --}}
                                <div class="flex-grow-1">
                                    <div class="fw-semibold fs-6 mb-1 d-flex align-items-center">
                                        {{-- Hiển thị toàn bộ nội dung, có xuống dòng nếu có --}}
                                        <span class="text-break message-full">{{ $msg }}</span>
                                        @if (!empty($link) && $link !== '#')
                                            <a href="{{ $link }}"
                                               class="ms-2 text-primary fs-6 d-inline-flex align-items-center noti-link"
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
                                        {{ $noti->read_at ? 'bg-secondary text-light' : 'bg-warning text-dark' }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="{{ $noti->read_at ? 'Đã đọc' : 'Thông báo mới' }}">
                                        <i class="bi {{ $noti->read_at ? 'bi-envelope-open-fill text-light' : 'bi-envelope-fill animate__animated animate__heartBeat animate__repeat-2 text-warning' }}"></i>
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

        /* Bỏ truncate, cho phép xuống dòng & giữ khoảng trắng */
        .message-full {
            white-space: pre-wrap; /* giữ xuống dòng nếu có \n */
            word-break: break-word; /* bẻ từ dài */
            max-width: 100%;
            display: inline;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        // Khởi tạo Echo (nếu layout chưa init)
        window.Pusher = window.Pusher || Pusher;
        window.Echo = window.Echo || new Echo({
            broadcaster: 'pusher',
            key: '1ea633f39dfb08c3c0c2',
            cluster: 'ap1',
            forceTLS: true,
        });

        document.addEventListener('DOMContentLoaded', function () {
            const userId = {{ auth()->id() }};
            const list = document.getElementById('notification-list');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // === Realtime: thêm thẻ mới, luôn hiển thị full message
            if (window.Echo && userId && list) {
                window.Echo.private(`App.Models.User.${userId}`)
                    .notification(function (notification) {
                        const data = notification.data || {};
                        let message = '';

                        // Không fallback "Bạn có thông báo mới!"
                        if (typeof data.message === 'string') {
                            message = data.message;
                        } else if (data.message && typeof data.message.message === 'string') {
                            message = data.message.message;
                        } else if (data.message && typeof data.message === 'object') {
                            // stringify nếu là object
                            try { message = JSON.stringify(data.message); } catch (_) { message = ''; }
                        }

                        const link = data.link_url || '#';

                        const wrapper = document.createElement('div');
                        wrapper.className = 'notification-item card shadow-none mb-3 border-0 notification-hover';
                        wrapper.style.cursor = 'pointer';
                        wrapper.setAttribute('data-id', notification.id);
                        wrapper.setAttribute('data-link', link);

                        const row = document.createElement('div');
                        row.className = 'd-flex align-items-start gap-3 px-3 py-3 rounded-3 border border-warning bg-warning bg-opacity-10 position-relative';

                        const avatar = document.createElement('div');
                        avatar.className = 'notif-avatar flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-75 text-warning shadow-sm';
                        avatar.style.width = '48px';
                        avatar.style.height = '48px';
                        avatar.style.fontSize = '1.6rem';
                        avatar.innerHTML = '<i class="bi bi-bell"></i>';

                        const content = document.createElement('div');
                        content.className = 'flex-grow-1';

                        const titleWrap = document.createElement('div');
                        titleWrap.className = 'fw-semibold fs-6 mb-1 d-flex align-items-center';

                        const title = document.createElement('span');
                        title.className = 'text-break message-full';
                        title.textContent = message || ''; // an toàn XSS
                        titleWrap.appendChild(title);

                        if (link && link !== '#') {
                            const a = document.createElement('a');
                            a.href = link;
                            a.className = 'ms-2 text-primary fs-6 d-inline-flex align-items-center noti-link';
                            a.title = 'Xem chi tiết';
                            // a.innerHTML = '<i class="bi bi-arrow-right-circle-fill"></i>';
                            titleWrap.appendChild(a);
                        }

                        const meta = document.createElement('div');
                        meta.className = 'small text-muted d-flex align-items-center';
                        meta.innerHTML = '<i class="bi bi-clock me-1"></i> Vừa xong';

                        content.appendChild(titleWrap);
                        content.appendChild(meta);

                        const state = document.createElement('div');
                        state.className = 'ms-2';
                        const badge = document.createElement('span');
                        badge.className = 'badge rounded-pill px-3 py-2 fw-semibold bg-warning text-dark align-middle border-0 shadow-sm';
                        badge.setAttribute('data-bs-toggle', 'tooltip');
                        badge.setAttribute('data-bs-title', 'Thông báo mới');
                        badge.innerHTML =
                            '<i class="bi bi-envelope-fill animate__animated animate__heartBeat animate__repeat-2 text-warning"></i><span class="align-middle ms-1">Mới</span>';
                        state.appendChild(badge);

                        row.appendChild(avatar);
                        row.appendChild(content);
                        row.appendChild(state);
                        wrapper.appendChild(row);

                        list.insertBefore(wrapper, list.firstChild);

                        // Giữ tối đa 10 item
                        const items = list.querySelectorAll('.notification-item');
                        if (items.length > 10) items[items.length - 1].remove();

                        // Bootstrap tooltip
                        if (window.bootstrap) {
                            const tts = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            tts.map(el => new bootstrap.Tooltip(el));
                        }
                    });
            }

            // === Click: mark-as-read rồi điều hướng (chỉ left-click, không modifier)
            list?.addEventListener('click', async function (e) {
                const card = e.target.closest('.notification-item');
                if (!card) return;

                // nếu click vào link riêng
                const linkEl = e.target.closest('a.noti-link');
                const href = linkEl ? linkEl.getAttribute('href') : (card.getAttribute('data-link') || '#');

                if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return; // only left click
                e.preventDefault();

                const id = card.dataset.id;
                if (!id) {
                    if (href && href !== '#') window.location.href = href;
                    return;
                }

                try {
                    const res = await fetch(`{{ url('employer/notifications') }}/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({})
                    });

                    if (res.ok) {
                        // Cập nhật UI: chuyển sang trạng thái đã đọc
                        const row = card.querySelector('.d-flex.align-items-start');
                        row?.classList.remove('border-warning', 'bg-warning', 'bg-opacity-10', 'text-dark');
                        row?.classList.add('border-secondary', 'bg-light', 'text-secondary');

                        const badge = card.querySelector('.badge');
                        if (badge) {
                            badge.classList.remove('bg-warning', 'text-dark');
                            badge.classList.add('bg-secondary', 'text-light');
                            badge.innerHTML =
                                '<i class="bi bi-envelope-open-fill text-light"></i> <span class="align-middle ms-1">Đã đọc</span>';
                            if (badge._tooltipInstance) {
                                badge._tooltipInstance.dispose();
                            }
                            badge.setAttribute('data-bs-title', 'Đã đọc');
                        }

                        const avatar = card.querySelector('.notif-avatar');
                        avatar?.classList.remove('bg-warning', 'bg-opacity-75', 'text-warning');
                        avatar?.classList.add('bg-light', 'text-secondary');
                    }
                } catch (err) {
                    console.error('Mark-as-read error:', err);
                } finally {
                    if (href && href !== '#') window.location.href = href;
                }
            });

            // Bootstrap Tooltip khởi tạo lần đầu (nếu có)
            if (window.bootstrap) {
                const tts = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tts.map(el => new bootstrap.Tooltip(el));
            }
        });
    </script>
@endpush
