<header class="header-area transparent">
    <div class="container">
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align" style="align-items: center; height: 80px;">
                    <!-- Logo -->
                    <div class="header-align-start d-flex align-items-center">
                        <!-- Logo -->
                        <div class="header-logo-area me-3">
                            <a href="{{ route('home') }}">
                                @php
                                    $clientLogo = \App\Models\Logo::where('type', 'client')
                                        ->where('is_active', true)
                                        ->first();
                                @endphp
                                <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : '' }}"
                                    alt="Client Logo" style="height: 60px; width: auto;">
                            </a>
                        </div>

                        <!-- Menu -->
                        <div class="header-navigation-area position-relative ms-4">
                            <ul class="main-menu nav">
                                <li><a href="{{ route('home') }}"><span>Trang Chủ</span></a></li>
                                <li class="has-submenu"><a href="{{ route('jobs.index') }}"><span>Tìm Việc
                                            Làm</span></a></li>
                                <li><a href="{{ route('contact') }}">Liên Hệ</a></li>
                            </ul>
                        </div>
                    </div>



                    <!-- Action -->
                    <div class="header-align-end">
                        <div class="header-action-area">
                            @guest
                                <a class="btn-registration" href="{{ route('showLoginForm') }}">Đăng Nhập</a>
                            @else
                                <div class="row align-items-center">
                                    <!-- Notification -->
                                    @if (auth()->check() && auth()->user()->role === 'job_seeker')
                                        <div class="col-auto">
                                            <div class="dropdown me-3 notification-dropdown-wrapper">
                                                <a href="#" id="notification-bell-btn"
                                                    class="btn btn-icon position-relative p-0 bg-transparent border-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Thông báo">
                                                    <i class="bi bi-bell fs-4 text-white"></i>
                                                    @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                                                    <span id="notification-count"
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                        style="display: {{ $unreadCount > 0 ? 'inline-block' : 'none' }}; font-size:.75rem;">
                                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                                    </span>
                                                </a>

                                                @php
                                                    $notifications = auth()
                                                        ->user()
                                                        ->notifications()
                                                        ->latest()
                                                        ->take(30)
                                                        ->get();
                                                @endphp

                                                <div class="dropdown-menu dropdown-menu-end p-0 noti-card"
                                                    aria-labelledby="notification-bell-btn">
                                                    {{-- Header --}}
                                                    <div
                                                        class="noti-card__header d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div
                                                                class="noti-card__chip d-flex align-items-center justify-content-center">
                                                                <i class="bi bi-bell-fill"></i>
                                                            </div>
                                                            <div class="fw-semibold">Thông báo</div>
                                                        </div>
                                                        <a href="{{ route('notifications.index') }}" class="noti-card__link">Xem
                                                            tất cả</a>
                                                    </div>

                                                    {{-- Scroll list (luôn chỉ cao = 3 item) --}}
                                                    <div id="noti-scroll" class="noti-card__list">
                                                        <ul id="notification-list-items" class="list-unstyled m-0">
                                                            @if ($notifications->count())
                                                                @foreach ($notifications as $noti)
                                                                    @php
                                                                        $data = $noti->data ?? [];
                                                                        $msg = is_string(data_get($data, 'message'))
                                                                            ? data_get($data, 'message')
                                                                            : (data_get($data, 'message')
                                                                                ? json_encode(
                                                                                    data_get($data, 'message'),
                                                                                    JSON_UNESCAPED_UNICODE,
                                                                                )
                                                                                : (data_get($data, 'title') ?:
                                                                                    'Có thông báo mới!'));
                                                                        $link = data_get($data, 'link_url', '#');
                                                                        $isRead = !is_null($noti->read_at);
                                                                    @endphp
                                                                    <li class="noti-item {{ $isRead ? 'is-read' : '' }}"
                                                                        data-id="{{ $noti->id }}" data-read="{{ $isRead ? '1' : '0' }}">
                                                                        <a class="noti-item__inner" href="{{ $link }}">
                                                                            <div class="noti-item__avatar"><i class="bi bi-bell"></i>
                                                                            </div>
                                                                            <div class="noti-item__body">
                                                                                <div class="noti-item__title">
                                                                                    {{ $msg }}
                                                                                </div>
                                                                                <div class="noti-item__meta">
                                                                                    {{ $noti->created_at->diffForHumans() }}
                                                                                </div>
                                                                            </div>
                                                                            <span class="noti-item__dot" aria-hidden="true"></span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li class="noti-empty empty-row">
                                                                    <div class="noti-empty__icon"><i class="bi bi-bell-slash"></i>
                                                                    </div>
                                                                    <div class="noti-empty__text">Chưa có thông báo</div>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                    {{-- Footer sticky --}}
                                                    <div class="noti-card__footer">
                                                        <form id="read-all-form" action="{{ route('notifications.readAll') }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Đánh
                                                                dấu tất cả đã đọc</button>
                                                        </form>
                                                        <a href="{{ route('notifications.index') }}"
                                                            class="btn btn-sm btn-link text-secondary">Xem tất cả</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Chat -->
                                    <div class="col-auto">
                                        <div class="dropdown me-3">
                                            <a class="btn btn-icon position-relative p-0 bg-transparent border-0"
                                                href="{{ route('chat.index') }}" id="chatDropdown" aria-label="Tin nhắn">
                                                <i id="chat-bubble" class="bi bi-chat-dots fs-4 text-white"></i>
                                                @if (isset($totalUnread) && $totalUnread > 0)
                                                    <span id="chat-dot"
                                                        class="position-absolute top-0 start-100 translate-middle bg-danger text-white d-flex justify-content-center align-items-center rounded-circle shadow"
                                                        style="font-size:10px; min-width:18px; height:18px; padding:0 4px; border:2px solid #fff;">
                                                        {{ $totalUnread > 99 ? '99+' : $totalUnread }}
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                    </div>

                                    <!-- User Menu -->
                                    <div class="col">
                                        <div class="user-info dropdown me-3">
                                            <a href="#" class="user-info-toggle d-flex align-items-center"
                                                data-bs-toggle="dropdown">
                                                <span class="user-avatar me-2"><i class="bi bi-person-circle"></i></span>
                                                <i class="bi bi-caret-down-fill ms-1"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 200px;">
                                                 @auth
                                        @if (auth()->user()->role === 'job_seeker')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center {{ request()->is('dashboard') ? 'active' : '' }}"
                                                        href="{{ route('profile.dashboard') }}">
                                                        <i class="bi bi-house-door me-2"></i> Tổng quan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('favorites.index') ? 'active' : '' }}"
                                                        href="{{ route('favorites.index') }}">
                                                        <i class="bi bi-bookmark-heart-fill text-danger me-2"></i> Việc làm
                                                        yêu thích
                                                    </a>
                                                </li>
                                                 @endif
                                    @endauth
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('admin.dashboard') }}">
                                                            <i class="bi bi-shield-lock me-2 text-danger"></i> Trang quản trị
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->role === 'employer' || Auth::user()->role === 'admin')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('employer.dashboard') }}">
                                                            <i class="bi bi-building me-2 text-success"></i> Trang nhà tuyển
                                                            dụng
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('profile.settings') }}">
                                                        <i class="bi bi-gear me-2"></i> Cài đặt
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endguest

                            <!-- Mobile Menu -->
                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                    {{-- /Actions --}}
                </div>
            </div>
        </div>
    </div>
</header>

@if (session('access_token'))
    <script>
        localStorage.setItem('access_token', "{{ session('access_token') }}");
    </script>
@endif

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

<script>
    // Echo init
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1ea633f39dfb08c3c0c2', // thay env nếu cần
        cluster: 'ap1',
        forceTLS: true,
    });

    // Template URL chi tiết notification (để resolve payload nếu thiếu)
    const NOTI_DETAIL_URL_TMPL = "{{ url('/notifications') }}/__ID__/json";

    // Luôn set chiều cao = đúng 3 item đầu (gọi khi dropdown mở)
    function setNotiScrollHeight() {
        const scroll = document.getElementById('noti-scroll');
        const list = document.getElementById('notification-list-items');
        if (!scroll || !list) return;

        const items = list.querySelectorAll('.noti-item');
        if (items.length === 0) {
            scroll.style.maxHeight = '0px';
            return;
        }

        const firstRect = items[0].getBoundingClientRect();
        const target = items[Math.min(2, items.length - 1)];
        const targetRect = target.getBoundingClientRect();
        const visibleH = Math.max(0, targetRect.bottom - firstRect.top) + 10;

        scroll.style.maxHeight = visibleH + 'px';
        scroll.style.overflowY = 'auto';
    }

    // Nếu payload realtime thiếu message/link -> fetch JSON chi tiết
    async function resolveNotificationPayload(evt) {
        const d = evt?.data || {};
        let message = (typeof d.message === 'string' && d.message.trim() !== '') ? d.message : null;
        let link = (typeof d.link_url === 'string' && d.link_url.trim() !== '') ? d.link_url : null;

        if (message && link) return {
            message,
            link
        };

        try {
            const url = NOTI_DETAIL_URL_TMPL.replace('__ID__', evt.id);
            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
            if (res.ok) {
                const j = await res.json();
                return {
                    message: (j.message && j.message.trim() !== '') ? j.message : (message || d.title ||
                        'Có thông báo mới!'),
                    link: (j.link_url && j.link_url.trim() !== '') ? j.link_url : (link || '#'),
                };
            }
        } catch (_) { }

        return {
            message: message || d.title || 'Có thông báo mới!',
            link: link || '#'
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        const badge = document.getElementById('notification-count');
        const list = document.getElementById('notification-list-items');
        const scrollBox = document.getElementById('noti-scroll');
        const trigger = document.getElementById('notification-bell-btn');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (trigger) trigger.addEventListener('shown.bs.dropdown', setNotiScrollHeight);
        window.addEventListener('resize', setNotiScrollHeight);

        // Chỉ cuộn trong dropdown, không cuộn trang
        if (scrollBox) {
            scrollBox.addEventListener('wheel', function (e) {
                const atTop = this.scrollTop === 0;
                const atBottom = Math.ceil(this.scrollTop + this.clientHeight) >= this.scrollHeight;
                if ((atTop && e.deltaY < 0) || (atBottom && e.deltaY > 0)) e.preventDefault();
            }, {
                passive: false
            });
        }

        // Recalc khi list thay đổi và dropdown đang mở
        if (list) {
            new MutationObserver(() => {
                const menu = trigger?.nextElementSibling;
                if (menu?.classList.contains('show')) setNotiScrollHeight();
            }).observe(list, {
                childList: true
            });
        }

        // Realtime: push item mới (đã resolve message/link)
        const authId = {{auth()->id() ?? 'null'}};
        if (authId && window.Echo) {
            window.Echo.private('App.Models.User.' + authId)
                .notification(async function (evt) {
                    // Badge
                    if (badge) {
                        let raw = (badge.textContent || '').trim();
                        let c = (raw === '99+') ? 99 : parseInt(raw) || 0;
                        c = isNaN(c) ? 0 : c + 1;
                        badge.textContent = c > 99 ? '99+' : c;
                        badge.style.display = 'inline-block';
                    }

                    const payload = await resolveNotificationPayload(evt);

                    // List
                    if (list) {
                        list.querySelectorAll('.empty-row').forEach(el => el.remove());

                        const li = document.createElement('li');
                        li.className = 'noti-item';
                        li.setAttribute('data-id', evt.id || '');
                        li.setAttribute('data-read', '0');
                        li.innerHTML = `
              <a class="noti-item__inner" href="${payload.link}">
                <div class="noti-item__avatar"><i class="bi bi-bell"></i></div>
                <div class="noti-item__body">
                  <div class="noti-item__title">${payload.message}</div>
                  <div class="noti-item__meta">Vừa xong</div>
                </div>
                <span class="noti-item__dot" aria-hidden="true"></span>
              </a>
            `;

                        const first = list.querySelector('.noti-item');
                        if (first) list.insertBefore(li, first);
                        else list.prepend(li);

                        // Giới hạn ~50 item
                        const items = list.querySelectorAll('.noti-item');
                        if (items.length > 50)
                            for (let i = 50; i < items.length; i++) items[i].remove();
                    }
                });
        }

        // Click => mark-as-read => đổi style + điều hướng
        if (list) {
            list.addEventListener('click', async function (e) {
                const anchor = e.target.closest('a.noti-item__inner');
                const li = e.target.closest('.noti-item[data-id]');
                if (!anchor || !li) return;
                if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                e.preventDefault();

                const id = li.getAttribute('data-id');
                const href = anchor.getAttribute('href') || '#';

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
                        const data = await res.json();
                        if (badge) {
                            const c = parseInt(data.unread_count ?? 0);
                            badge.textContent = c > 99 ? '99+' : c;
                            badge.style.display = c > 0 ? 'inline-block' : 'none';
                        }
                        li.classList.add('is-read');
                        li.setAttribute('data-read', '1');
                    }
                } catch (err) {
                    console.error('Mark-as-read error:', err);
                } finally {
                    if (href && href !== '#') window.location.href = href;
                }
            });
        }

        // Đánh dấu tất cả đã đọc
        const readAllForm = document.getElementById('read-all-form');
        if (readAllForm) {
            readAllForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                try {
                    const res = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({})
                    });
                    if (res.ok) {
                        if (badge) {
                            badge.textContent = '0';
                            badge.style.display = 'none';
                        }
                        document.querySelectorAll('#notification-list-items .noti-item')
                            .forEach(el => {
                                el.classList.add('is-read');
                                el.setAttribute('data-read', '1');
                            });
                    }
                } catch (error) {
                    console.error(error);
                }
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const authId = {{ auth()->id() ?? 'null' }};

        if (window.Echo && authId) {
            window.Echo.private('user.' + authId)
                .listen('MessageNotification', (e) => {
                    console.log('New message notification:', e);
                    const unread = e.unread_total;
                    let chatDot = document.getElementById('chat-dot');

                    if (unread > 0) {
                        if (!chatDot) {
                            // Nếu chưa có badge -> tạo mới
                            const link = document.getElementById('chatDropdown');
                            chatDot = document.createElement('span');
                            chatDot.id = 'chat-dot';
                            chatDot.className =
                                'position-absolute top-0 start-100 translate-middle bg-danger text-white d-flex justify-content-center align-items-center rounded-circle shadow';
                            chatDot.style.cssText =
                                'font-size:10px; min-width:18px; height:18px; padding:0 4px; border:2px solid #fff;';
                            link.appendChild(chatDot);
                        }
                        chatDot.innerText = unread > 99 ? '99+' : unread;
                        chatDot.style.display = 'flex';
                    } else {
                        if (chatDot) chatDot.remove(); // ẩn = xoá khỏi DOM
                    }
                });
        }
    });
</script>

<style>
    .noti-card {
        width: 360px;
        border: none;
        border-radius: 14px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .16), 0 2px 4px rgba(0, 0, 0, .08);
        overflow: hidden;
    }

    .noti-card__header {
        padding: 10px 14px;
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
        color: #fff;
    }

    .noti-card__chip {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .18);
        backdrop-filter: blur(6px);
        font-size: 16px;
    }

    .noti-card__link {
        color: rgba(255, 255, 255, .9);
        text-decoration: none;
        font-size: .9rem;
    }

    .noti-card__link:hover {
        text-decoration: underline;
    }

    .noti-card__list {
        padding: 6px 0;
        background: var(--noti-bg, #fff);
        max-height: 320px;
        overflow-y: auto;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }

    .noti-card__footer {
        position: sticky;
        bottom: 0;
        display: flex;
        gap: .5rem;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: linear-gradient(180deg, rgba(0, 0, 0, .02), rgba(0, 0, 0, .06));
        backdrop-filter: blur(6px);
    }

    .noti-item {
        list-style: none;
    }

    .noti-item+.noti-item {
        border-top: 1px solid rgba(0, 0, 0, .05);
    }

    .noti-item__inner {
        display: grid;
        grid-template-columns: 36px 1fr auto;
        gap: 10px;
        align-items: start;
        padding: 10px 14px;
        text-decoration: none;
        transition: background .15s ease, transform .06s ease;
    }

    .noti-item__inner:hover {
        background: rgba(0, 0, 0, .04);
    }

    .noti-item__inner:active {
        transform: scale(.996);
    }

    .noti-item__avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eef2ff;
        color: #4f46e5;
        display: grid;
        place-items: center;
        font-size: 18px;
    }

    .noti-item__body {
        min-width: 0;
    }

    .noti-item__title {
        font-size: .95rem;
        line-height: 1.3;
        color: #111827;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .noti-item__meta {
        font-size: .8rem;
        color: #6b7280;
        margin-top: 2px;
    }

    .noti-item__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ef4444;
        margin-top: 4px;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, .18);
    }

    .noti-item.is-read .noti-item__title {
        font-weight: 500;
        color: #374151;
    }

    .noti-item.is-read .noti-item__dot {
        visibility: hidden;
    }

    .noti-empty {
        padding: 24px 12px;
        text-align: center;
        color: #6b7280;
    }

    .noti-empty__icon {
        font-size: 28px;
        opacity: .5;
        margin-bottom: 6px;
    }

    html.dark .noti-card__list {
        --noti-bg: #0b1220;
    }

    html.dark .noti-item__inner:hover {
        background: rgba(255, 255, 255, .06);
    }

    html.dark .noti-item__title {
        color: #e5e7eb;
    }

    html.dark .noti-item__meta {
        color: #9ca3af;
    }

    html.dark .noti-item.is-read .noti-item__title {
        color: #cbd5e1;
    }
</style>