@extends('website.layouts.master1')

@section('title', 'Thông báo')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Header banner gọn -->
    <div class="page-header-area d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <main class="main-content py-4 mx-auto" style="max-width: 920px;">
        <!-- Toolbar -->
        <div class="mb-3">
            <div class="notify-toolbar card shadow-sm border-0 rounded-4 glassy">
                <div class="card-body py-3 px-3 px-md-4 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="tool-title d-inline-flex align-items-center gap-2 fw-semibold">
                            <i class="fas fa-bell text-primary"></i>
                            <span>Thông báo của bạn</span>
                        </span>
                        <span class="vr d-none d-md-inline mx-2 opacity-25"></span>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Bộ lọc">
                            <button class="btn btn-outline-primary active" id="filter-all" type="button">
                                Tất cả
                            </button>
                            <button class="btn btn-outline-primary" id="filter-unread" type="button">
                                Chưa đọc
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <div class="position-relative">
                            <input id="search-input" type="text" class="form-control form-control-sm rounded-pill ps-4"
                                placeholder="Tìm thông báo...">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted small"></i>
                        </div>
                        @auth
                            <button id="read-all-btn" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="bi bi-check2-all me-1"></i> Đánh dấu tất cả đã đọc
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline wrapper -->
        <div class="card border-0 shadow-sm rounded-4 glassy">
            <div class="card-body p-0">
                <div class="timeline-wrapper p-3 p-md-4">
                    <div id="notification-list" class="timeline-list">
                        @forelse($notifications as $noti)
                            @php
                                $msg = $noti->data['message'] ?? '';
                                if (is_array($msg)) {
                                    $msg = $msg['message'] ?? '';
                                }
                                if (is_object($msg)) {
                                    $msg = $msg->message ?? '';
                                }
                                $link = $noti->data['link_url'] ?? '#';
                                $isUnread = !$noti->read_at;
                            @endphp

                            <div class="timeline-item notification-card {{ $isUnread ? 'is-unread' : '' }}"
                                data-id="{{ $noti->id }}" data-unread="{{ $isUnread ? '1' : '0' }}">
                                <div class="timeline-dot {{ $isUnread ? 'dot-primary' : 'dot-muted' }}"></div>
                                <div class="timeline-line"></div>

                                <div
                                    class="timeline-card card shadow-xs border-0 rounded-3 {{ $isUnread ? 'bg-soft-accent' : '' }}">
                                    <div
                                        class="card-body py-3 px-3 px-md-4 d-flex justify-content-between align-items-start gap-3">
                                        <!-- Left: avatar + content -->
                                        <div class="d-flex align-items-start gap-3 flex-grow-1">
                                            <div class="notif-avatar {{ $isUnread ? 'glow-primary' : '' }}">
                                                <i class="bi bi-bell-fill"></i>
                                            </div>

                                            <div class="noti-content">
                                                <a href="{{ $link }}"
                                                    class="text-decoration-none text-reset noti-link">
                                                    <div class="mb-1 fw-semibold lh-sm">
                                                        <span class="message-full">{{ $msg }}</span>
                                                    </div>
                                                </a>
                                                <div class="small text-muted d-flex align-items-center gap-2">
                                                    <i class="bi bi-clock"></i>
                                                    <time datetime="{{ $noti->created_at->toIso8601String() }}">
                                                        {{ $noti->created_at->diffForHumans() }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right: status -->
                                        <div class="noti-status text-nowrap">
                                            @if ($isUnread)
                                                <span
                                                    class="badge rounded-pill bg-accent-strong text-accent-dark">Mới</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">
                                                    <i class="bi bi-check2"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <div class="empty-illustration mx-auto mb-3"></div>
                                <div class="fw-semibold">Bạn chưa có thông báo nào</div>
                                <div class="small">Khi có hoạt động mới, thông báo sẽ xuất hiện ở đây.</div>
                            </div>
                        @endforelse
                    </div>

                  
                    <div class="pagination-section mt-6 d-flex justify-content-center">
    {{ $notifications->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
</div>

                </div>
            </div>
        </div>
    </main>

    <style>
        /* ======== TÔNG MÀU SÁNG (PASTEL) ======== */
        :root {
            /* Chủ đạo xanh pastel */
            --primary: #ffffff;
            --primary-600: #0044ff;
            --primary-50: #eef7ff;
            /* nền cực nhạt */
            --primary-100: #e6f2ff;
            /* hover/nhấn nhẹ */
            --primary-200: #d7e9ff;

            /* Accent vàng nhạt cho thông báo mới */
            --accent-50: #fffdf2;
            --accent-100: #fff8db;
            /* nền item chưa đọc */
            --accent-150: #fff2bf;
            /* badge/hover */
            --accent-600: #a07a00;
            /* chữ badge */

            /* Nền tổng thể sáng */
            --page: #f6faff;
            /* xanh pastel rất nhạt */
            --surface: #ffffff;
            --surface-ghost: rgba(255, 255, 255, 0.9);

            --text: #000000;
            --muted: #009dff;
            --line: #e5e7eb;

            --ring: rgba(13, 110, 253, .14);
            --ring-strong: rgba(13, 110, 253, .22);
            --shadow-xs: 0 4px 14px rgba(13, 21, 65, .06);
            --shadow-hover: 0 10px 24px rgba(13, 21, 65, .10);
        }

        /* Nền trang sáng dịu */
        body {
            background: var(--page);
        }

        /* Hiệu ứng kính mờ nhẹ cho card */
        .glassy {
            background: var(--surface-ghost);
            backdrop-filter: blur(6px);
        }

        .shadow-xs {
            box-shadow: var(--shadow-xs);
        }

        /* Nền vàng nhạt cho item chưa đọc */
        .bg-soft-accent {
            background: var(--accent-100) !important;
        }

        .bg-accent-strong {
            background: var(--accent-150) !important;
        }

        .text-accent-dark {
            color: var(--accent-600) !important;
        }

        /* Tôn trọng người dùng giảm chuyển động */
        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
            }
        }

        /* ======== Toolbar ======== */
        .tool-title {
            font-size: .95rem;
            color: var(--text);
        }

        .btn-outline-primary {
            border-color: var(--primary-200);
            color: var(--primary-600);
            background: #ffffff;
        }

        .btn-outline-primary:hover {
            border-color: var(--primary-600);
            background: var(--primary-50);
            color: var(--primary-600);
        }

        .btn-outline-primary.active {
            background: linear-gradient(180deg, #0059ff, var(--primary-50));
            border-color: var(--primary-600);
            color: var(--primary-600);
        }

        /* ======== Timeline ======== */
        .timeline-wrapper {
            position: relative;
        }

        .timeline-list {
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding-left: 34px;
            margin-bottom: 14px;
        }

        .timeline-dot {
            position: absolute;
            left: 10px;
            top: 14px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 0 3px var(--ring);
        }

        .dot-primary {
            background: var(--primary);
        }

        .dot-muted {
            background: #cbd5e1;
            box-shadow: 0 0 0 3px rgba(148, 163, 184, .18);
        }

        .timeline-line {
            position: absolute;
            left: 15px;
            top: 32px;
            bottom: -6px;
            width: 2px;
            background: linear-gradient(180deg, var(--line), rgba(0, 0, 0, 0));
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        /* ======== Card & hover ======== */
        .timeline-card {
            background: var(--surface);
            transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
            border: 1px solid rgba(17, 24, 39, .03);
        }

        .timeline-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* ======== Avatar chuông ======== */
        .notif-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 1.1rem;
            background: #fff;
            color: var(--primary-600);
            border: 1px solid var(--primary-200);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex: 0 0 40px;
            box-shadow: 0 2px 8px rgba(13, 21, 65, .04);
        }

        .glow-primary {
            box-shadow: 0 0 0 3px var(--ring-strong),
                0 6px 16px var(--ring);
        }

        /* ======== Nội dung bên trong (tông sáng) ======== */
        .message-full {
            white-space: pre-wrap;
            word-break: break-word;
            color: var(--text);
        }

        .noti-content a.noti-link {
            color: var(--text);
        }

        .noti-content a.noti-link:hover {
            color: var(--primary-600);
            text-decoration: underline;
        }

        .small.text-muted {
            color: var(--muted) !important;
        }

        /* Unread: giữ chữ đậm, rõ ràng trên nền vàng nhạt */
        .bg-soft-accent .message-full {
            color: var(--text);
        }

        .bg-soft-accent .small.text-muted {
            color: var(--muted) !important;
        }

        /* ======== Empty state ======== */
        .empty-illustration {
            width: 110px;
            height: 90px;
            border-radius: 18px;
            background: linear-gradient(135deg, #f4f8ff, #e8f3ff);
            position: relative;
            box-shadow: inset 0 2px 8px rgba(13, 21, 65, .06);
        }

        .empty-illustration:before,
        .empty-illustration:after {
            content: '';
            position: absolute;
            border-radius: 10px;
            background: #fff;
        }

        .empty-illustration:before {
            width: 54px;
            height: 14px;
            left: 28px;
            top: 24px;
            box-shadow: 0 8px 0 0 #fff, 0 16px 0 0 #fff;
        }

        .empty-illustration:after {
            width: 10px;
            height: 10px;
            left: 18px;
            top: 24px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 16px 0 0 var(--primary);
        }
    </style>
@endsection

@push('scripts')
    <!-- Nếu layout đã có các file này thì bỏ -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        // Init Echo (bỏ nếu đã init ở layout)
        window.Pusher = window.Pusher || Pusher;
        window.Echo = window.Echo || new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
        });

        document.addEventListener('DOMContentLoaded', function() {
            const listEl = document.getElementById('notification-list');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const readAllBtn = document.getElementById('read-all-btn');
            const filterAll = document.getElementById('filter-all');
            const filterUnread = document.getElementById('filter-unread');
            const searchInput = document.getElementById('search-input');

            // FILTER & SEARCH (UI only)
            function applyFilter() {
                const showUnreadOnly = filterUnread.classList.contains('active');
                const q = (searchInput.value || '').toLowerCase().trim();

                listEl.querySelectorAll('.notification-card').forEach(card => {
                    const isUnread = card.getAttribute('data-unread') === '1';
                    const text = (card.querySelector('.message-full')?.textContent || '').toLowerCase();

                    let visible = true;
                    if (showUnreadOnly && !isUnread) visible = false;
                    if (q && !text.includes(q)) visible = false;

                    card.style.display = visible ? '' : 'none';
                });
            }
            filterAll?.addEventListener('click', () => {
                filterAll.classList.add('active');
                filterUnread.classList.remove('active');
                applyFilter();
            });
            filterUnread?.addEventListener('click', () => {
                filterUnread.classList.add('active');
                filterAll.classList.remove('active');
                applyFilter();
            });
            searchInput?.addEventListener('input', applyFilter);

            // Click 1 item: mark-as-read rồi điều hướng
            if (listEl) {
                listEl.addEventListener('click', async function(e) {
                    const link = e.target.closest('a.noti-link');
                    const card = e.target.closest('.notification-card[data-id]');
                    if (!link || !card) return;

                    if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                    e.preventDefault();

                    const id = card.getAttribute('data-id');
                    const href = link.getAttribute('href') || '#';

                    try {
                        const res = await fetch(`{{ url('/notifications') }}/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({})
                        });

                        if (res.ok) {
                            // cập nhật UI -> đã đọc
                            card.classList.remove('is-unread');
                            card.setAttribute('data-unread', '0');
                            const badge = card.querySelector('.noti-status .badge');
                            if (badge) {
                                badge.className = 'badge rounded-pill bg-secondary';
                                badge.innerHTML = '<i class="bi bi-check2"></i>';
                            }
                            const dot = card.querySelector('.timeline-dot');
                            dot?.classList.remove('dot-primary');
                            dot?.classList.add('dot-muted');
                            const avatar = card.querySelector('.notif-avatar');
                            avatar?.classList.remove('glow-primary');
                            card.querySelector('.timeline-card')?.classList.remove('bg-soft-accent');
                        }
                    } catch (err) {
                        console.error('Mark-as-read error:', err);
                    } finally {
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    }
                });
            }

            // Đánh dấu tất cả đã đọc
            if (readAllBtn) {
                readAllBtn.addEventListener('click', async function() {
                    try {
                        const res = await fetch(`{{ route('notifications.readAll') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({})
                        });
                        if (res.ok) {
                            listEl.querySelectorAll('.notification-card').forEach(card => {
                                card.classList.remove('is-unread');
                                card.setAttribute('data-unread', '0');
                                const badge = card.querySelector('.noti-status .badge');
                                if (badge) {
                                    badge.className = 'badge rounded-pill bg-secondary';
                                    badge.innerHTML = '<i class="bi bi-check2"></i>';
                                }
                                const dot = card.querySelector('.timeline-dot');
                                dot?.classList.remove('dot-primary');
                                dot?.classList.add('dot-muted');
                                const avatar = card.querySelector('.notif-avatar');
                                avatar?.classList.remove('glow-primary');
                                card.querySelector('.timeline-card')?.classList.remove(
                                    'bg-soft-accent');
                            });
                            const bellBadge = document.getElementById('notification-count');
                            if (bellBadge) {
                                bellBadge.textContent = '0';
                                bellBadge.style.display = 'none';
                            }
                            applyFilter();
                        }
                    } catch (e) {
                        console.error(e);
                    }
                });
            }

            // Realtime: thêm item mới (nền vàng nhạt + tông sáng)
            const userId = {{ auth()->id() ?? 'null' }};
            if (userId && window.Echo) {
                window.Echo.private(`App.Models.User.${userId}`)
                    .notification((notification) => {
                        const data = notification.data || {};
                        const message = (typeof data.message === 'string') ?
                            data.message :
                            (data.message && data.message.message) ? data.message.message :
                            'Bạn có thông báo mới';
                        const link = data.link_url || '#';

                        const item = document.createElement('div');
                        item.className = 'timeline-item notification-card is-unread';
                        item.setAttribute('data-id', notification.id);
                        item.setAttribute('data-unread', '1');

                        const dot = document.createElement('div');
                        dot.className = 'timeline-dot dot-primary';
                        const line = document.createElement('div');
                        line.className = 'timeline-line';

                        const card = document.createElement('div');
                        card.className = 'timeline-card card shadow-xs border-0 rounded-3 bg-soft-accent';

                        const body = document.createElement('div');
                        body.className =
                            'card-body py-3 px-3 px-md-4 d-flex justify-content-between align-items-start gap-3';

                        const leftWrap = document.createElement('div');
                        leftWrap.className = 'd-flex align-items-start gap-3 flex-grow-1';

                        const avatar = document.createElement('div');
                        avatar.className = 'notif-avatar glow-primary';
                        avatar.innerHTML = '<i class="bi bi-bell-fill"></i>';

                        const content = document.createElement('div');
                        content.className = 'noti-content';

                        const linkEl = document.createElement('a');
                        linkEl.href = link;
                        linkEl.className = 'text-decoration-none text-reset noti-link';

                        const titleDiv = document.createElement('div');
                        titleDiv.className = 'mb-1 fw-semibold lh-sm';
                        const spanMsg = document.createElement('span');
                        spanMsg.className = 'message-full';
                        spanMsg.textContent = message;
                        titleDiv.appendChild(spanMsg);

                        linkEl.appendChild(titleDiv);

                        const timeDiv = document.createElement('div');
                        timeDiv.className = 'small text-muted d-flex align-items-center gap-2';
                        timeDiv.innerHTML = '<i class="bi bi-clock"></i>';
                        const tm = document.createElement('time');
                        tm.textContent = new Date().toLocaleString('vi-VN');
                        timeDiv.appendChild(tm);

                        content.appendChild(linkEl);
                        content.appendChild(timeDiv);

                        leftWrap.appendChild(avatar);
                        leftWrap.appendChild(content);

                        const right = document.createElement('div');
                        right.className = 'noti-status text-nowrap';
                        const badge = document.createElement('span');
                        badge.className = 'badge rounded-pill bg-accent-strong text-accent-dark';
                        badge.textContent = 'Mới';
                        right.appendChild(badge);

                        body.appendChild(leftWrap);
                        body.appendChild(right);
                        card.appendChild(body);

                        item.appendChild(dot);
                        item.appendChild(line);
                        item.appendChild(card);

                        const emptyAlert = listEl?.querySelector('.alert.alert-info');
                        if (emptyAlert) emptyAlert.remove();

                        listEl?.insertBefore(item, listEl.firstChild);

                        const bellBadge = document.getElementById('notification-count');
                        if (bellBadge) {
                            let count = parseInt(bellBadge.textContent || '0');
                            count = isNaN(count) ? 0 : count + 1;
                            bellBadge.textContent = count > 99 ? '99+' : count;
                            bellBadge.style.display = 'inline-block';
                        }

                        applyFilter();
                    });
            }
        });
    </script>
@endpush
