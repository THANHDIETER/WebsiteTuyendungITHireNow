{{-- resources/views/layouts/partials/employer-header.blade.php --}}
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="Edmin admin is super flexible, powerful, clean & modern responsive admin template with unlimited possibilities.">
<meta name="keywords"
    content="admin template, Edmin admin template, best javascript admin, dashboard template, admin template, responsive admin template, web app">
<meta name="author" content="pixelstrap">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Employer' }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/brands.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/solid.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/regular.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/themify-icons/themify-icons/css/themify.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css/animate.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/apexcharts.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-datatables/dist/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<meta property="og:url" content="{{ url()->current() }}">

<header class="page-header row justify-content-between align-items-center bg-white">
    <div class="logo-wrapper d-flex align-items-center col-4">
        <a href="{{ route('home') }}">
            @php
                $clientLogo = \App\Models\Logo::where('type', 'header')->where('is_active', true)->first();
            @endphp
            <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
                alt="Client Logo" style="height: 120px;">
        </a>

        <a class="close-btn" href="javascript:void(0)">
            <div class="toggle-sidebar">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </a>
    </div>

    <div class="page-main-header d-flex align-items-center col-auto">
        <div class="nav-right">
            <ul class="header-right">
                <li class="modes d-flex">
                    <a class="dark-mode">
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>

                {{-- 🔔 Notifications: 3 item đầu + cuộn + nút "Đánh dấu tất cả đã đọc" --}}
                <li class="custom-dropdown" id="employer-noti-dropdown">
                    <a href="javascript:void(0)" id="notification-toggle" aria-label="Thông báo">
                        <svg class="svg-color circle-color" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    @php
                        $unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
                        $notifications = auth()->check()
                            ? auth()->user()->notifications()->latest()->take(30)->get()
                            : collect();
                    @endphp

                    <span class="badge rounded-pill badge-secondary" id="noti-count">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>

                    <div class="custom-menu notification-dropdown py-0 noti-card shadow">
                        {{-- Header --}}
                        <div class="noti-card__header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="noti-card__chip d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <div class="fw-semibold">Thông báo</div>
                            </div>
                            <a href="{{ route('employer.notifications.index') }}" class="noti-card__link">Xem tất
                                cả</a>
                        </div>

                        {{-- List (JS sẽ set chiều cao đúng 3 item đầu) --}}
                        <div id="noti-scroll" class="noti-card__list">
                            <ul class="list-unstyled m-0" id="noti-list">
                                @if ($notifications->count())
                                    @foreach ($notifications as $noti)
                                        @php
                                            $data = $noti->data ?? [];
                                            $msg = is_string(data_get($data, 'message'))
                                                ? data_get($data, 'message')
                                                : (data_get($data, 'message')
                                                    ? json_encode(data_get($data, 'message'), JSON_UNESCAPED_UNICODE)
                                                    : (data_get($data, 'title') ?:
                                                    'Bạn có thông báo mới!'));
                                            $link = data_get($data, 'link_url', '#');
                                            $isRead = !is_null($noti->read_at);
                                        @endphp
                                        <li class="noti-item {{ $isRead ? 'is-read' : '' }}"
                                            data-id="{{ $noti->id }}" data-read="{{ $isRead ? '1' : '0' }}">
                                            <a class="noti-item__inner" href="{{ $link }}">
                                                <div class="noti-item__avatar"><i class="bi bi-bell"></i></div>
                                                <div class="noti-item__body">
                                                    <div class="noti-item__title">{{ $msg }}</div>
                                                    <div class="noti-item__meta">
                                                        {{ $noti->created_at->diffForHumans() }}</div>
                                                </div>
                                                <span class="noti-item__dot" aria-hidden="true"></span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="noti-empty empty-row">
                                        <div class="noti-empty__icon"><i class="bi bi-bell-slash"></i></div>
                                        <div class="noti-empty__text">Chưa có thông báo</div>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- Footer --}}
                        <div class="noti-card__footer">
                            {{-- dùng trực tiếp route, không phụ thuộc Route::has để tránh null --}}
                            <button id="emp-read-all-btn" type="button" class="btn btn-sm btn-outline-secondary"
                                data-action="{{ route('employer.notifications.readAll') }}"
                                {{ $unreadCount > 0 ? '' : 'disabled' }}>
                                Đánh dấu tất cả đã đọc
                            </button>
                            <a href="{{ route('employer.notifications.index') }}"
                                class="btn btn-sm btn-link text-secondary">Xem tất cả</a>
                        </div>
                    </div>
                </li>

                {{-- CART giữ nguyên --}}
                <li class="custom-dropdown">
                    <a href="javascript:void(0)">
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 2l3 0a3 3 0 016 0l3 0a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"
                                stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="none" />
                            <path d="M6 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </a>
                    <div class="custom-menu cart-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">Cart<span>Total : <span
                                    class="font-primary">4350.9</span></span></h5>
                        <ul>
                            <li class="cartbox d-flex bg-light-primary">
                                <div class="flex-shrink-0 border-primary">
                                    <img loading="lazy" src="{{ asset('assets/images/dashboard2/product/1.png') }}"
                                        alt="">
                                </div>
                                <div class="touchpin-details">
                                    <a href="">
                                        <h5>Apple Computers</h5>
                                    </a><span>$2600.00</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-primary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="cartbox d-flex bg-light-secondary">
                                <div class="flex-shrink-0 border-secondary">
                                    <img loading="lazy" src="{{ asset('assets/images/dashboard2/product/2.png') }}"
                                        alt="">
                                </div>
                                <div class="touchpin-details">
                                    <a href="">
                                        <h5>Microwave</h5>
                                    </a><span>$1450.45</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-secondary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="cartbox d-flex bg-light-tertiary">
                                <div class="flex-shrink-0 border-tertiary">
                                    <img loading="lazy" src="{{ asset('assets/images/dashboard2/product/3.png') }}"
                                        alt="">
                                </div>
                                <div class="touchpin-details">
                                    <a href="">
                                        <h5>Mackup Kit</h5>
                                    </a><span>$300.45</span>
                                    <div class="touchspin-wrapper">
                                        <button class="decrement-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input class="form-control input-touchspin bg-light-tertiary" type="number"
                                            value="5">
                                        <button class="increment-touchspin btn-touchspin">
                                            <svg class="svg-color" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <line x1="12" y1="5" x2="12" y2="19"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <line x1="5" y1="12" x2="19" y2="12"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn-close"></button>
                                </div>
                            </li>
                            <li class="mt-3 p-0 d-flex justify-content-center">
                                <div><a class="btn btn-secondary" href="">Checkout</a></div>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- CHAT --}}
                <li class="custom-dropdown">
                    <a href="{{ route('chat.index') }}">
                        <svg class="svg-color" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z" stroke="currentColor"
                                stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <span id="chat-dot" class="badge rounded-pill badge-tertiary">
                        {{ ($totalUnread ?? 0) > 99 ? '99+' : $totalUnread ?? 0 }}
                    </span>
                </li>

                {{-- PROFILE --}}
                <li class="profile-dropdown custom-dropdown">
                    <div class="d-flex align-items-center">
                        <img loading="lazy" src="{{ asset('assets/images/profile.png') }}" alt="">
                        <div class="flex-grow-1">
                            <h5>
                                @if (auth()->check())
                                    {{ auth()->user()->role }}
                                    <sup style="font-size:.7em;color:red;">{{ auth()->user()->id }}</sup>
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </h5>
                            @if (auth()->check())
                                <span>{{ auth()->user()->email }}</span>
                            @else
                                <span class="text-muted">Chưa đăng nhập</span>
                            @endif
                        </div>
                    </div>
                    <div class="custom-menu overflow-hidden">
                        <ul class="list-unstyled m-0 p-0">
                            <li><a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="7" r="4" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M5.5 21h13a8.38 8.38 0 00-13 0z" stroke="currentColor"
                                            stroke-width="2" stroke-linejoin="round" />
                                    </svg><span>Account</span></a>
                            </li>
                            <li><a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg><span>Inbox</span></a>
                            </li>
                            <li><a href="#"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                        <path d="M14 2v6h6" stroke="currentColor" stroke-width="2" />
                                    </svg><span>Task</span></a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="d-flex align-items-center px-3 py-2 text-decoration-none text-dark rounded menu-link">
                                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" stroke="currentColor"
                                            stroke-width="2" stroke-linejoin="round" />
                                        <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                        <path d="M15 12H3" stroke="currentColor" stroke-width="2"
                                            stroke-linejoin="round" stroke-linecap="round" />
                                    </svg><span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>

@if (session('access_token'))
    <script>
        localStorage.setItem('access_token', "{{ session('access_token') }}");
    </script>
@endif

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

<script>
    // ====== ROUTES cho AJAX ======
    const NOTI_JSON_URL_TMPL = "{{ route('employer.notifications.json', ['id' => '__ID__']) }}";
    const NOTI_READ_URL_TMPL = "{{ route('employer.notifications.read', ['id' => '__ID__']) }}";
    const NOTI_READALL_URL = "{{ route('employer.notifications.readAll') }}";

    // ====== Fallback payload ======
    async function resolveNotificationPayload(evt) {
        const d = evt?.data || {};
        let message = (typeof d.message === 'string' && d.message.trim() !== '') ? d.message : null;
        let link = (typeof d.link_url === 'string' && d.link_url.trim() !== '') ? d.link_url : null;
        if (message && link) return {
            message,
            link
        };

        try {
            const url = NOTI_JSON_URL_TMPL.replace('__ID__', evt.id);
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
                        'Bạn có thông báo mới!'),
                    link: (j.link_url && j.link_url.trim() !== '') ? j.link_url : (link || '#')
                };
            }
        } catch (_) {}
        return {
            message: message || d.title || 'Bạn có thông báo mới!',
            link: link || '#'
        };
    }

    // ====== Dark mode ======
    document.addEventListener("DOMContentLoaded", function() {
        const darkModeBtn = document.querySelector('.dark-mode');
        if (!darkModeBtn) return;
        darkModeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' :
                'light');
        });
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    });

    // ====== Echo/Pusher ======
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1ea633f39dfb08c3c0c2', // TODO: env
        cluster: 'ap1',
        forceTLS: true,
    });

    // ====== Tính chiều cao vùng cuộn (3 item đầu) ======
    function setNotiScrollHeight() {
        const scroll = document.getElementById('noti-scroll');
        const list = document.getElementById('noti-list');
        if (!scroll || !list) return;

        const items = list.querySelectorAll('li[data-id]');
        if (items.length === 0) return;

        const firstRect = items[0].getBoundingClientRect();
        const target = items[Math.min(2, items.length - 1)];
        const bottom = target.getBoundingClientRect().bottom;
        const visibleH = Math.max(0, bottom - firstRect.top) + 8;
        scroll.style.maxHeight = visibleH + 'px';
        scroll.style.overflowY = 'auto';
    }
    document.addEventListener('DOMContentLoaded', setNotiScrollHeight);
    window.addEventListener('resize', setNotiScrollHeight);
    document.getElementById('employer-noti-dropdown')?.addEventListener('mouseenter', setNotiScrollHeight);

    // Chặn cuộn trang khi cuộn trong dropdown
    document.addEventListener('DOMContentLoaded', () => {
        const scrollBox = document.getElementById('noti-scroll');
        if (scrollBox) {
            scrollBox.addEventListener('wheel', function(e) {
                const atTop = this.scrollTop === 0;
                const atBottom = Math.ceil(this.scrollTop + this.clientHeight) >= this.scrollHeight;
                if ((atTop && e.deltaY < 0) || (atBottom && e.deltaY > 0)) e.preventDefault();
            }, {
                passive: false
            });
        }
    });

    // ====== Realtime notifications ======
    (function initRealtimeEmployerNoti() {
        const userId = {{ auth()->id() ?? 'null' }};
        if (!userId || !window.Echo) return;

        window.Echo.private(`App.Models.User.${userId}`)
            .notification(async (evt) => {
                const badge = document.getElementById('noti-count');
                const list = document.getElementById('noti-list');
                const readAllBtn = document.getElementById('emp-read-all-btn');

                if (badge) {
                    let txt = (badge.textContent || '').trim();
                    let c = (txt === '99+') ? 99 : parseInt(txt) || 0;
                    c = isNaN(c) ? 0 : c + 1;
                    badge.textContent = c > 99 ? '99+' : c;
                    badge.style.display = 'inline-block';
                }
                if (readAllBtn) readAllBtn.disabled = false;

                const payload = await resolveNotificationPayload(evt);

                if (list) {
                    const empty = list.querySelector('.noti-empty');
                    if (empty) empty.remove();

                    const li = document.createElement('li');
                    li.className = 'noti-item';
                    li.dataset.id = evt.id || '';
                    li.dataset.read = '0';
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
                    const first = list.querySelector('li[data-id]');
                    if (first) list.insertBefore(li, first);
                    else list.prepend(li);

                    const items = list.querySelectorAll('li[data-id]');
                    if (items.length > 50)
                        for (let i = 50; i < items.length; i++) items[i].remove();

                    setNotiScrollHeight();
                }
            });
    })();

    // ====== Click 1 item => mark-as-read => update badge => điều hướng ======
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('noti-list');
        const badge = document.getElementById('noti-count');
        const readAllBtn = document.getElementById('emp-read-all-btn');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        if (!list) return;

        list.addEventListener('click', async function(e) {
            const a = e.target.closest('a.noti-item__inner');
            const li = e.target.closest('li[data-id]');
            if (!a || !li) return;

            if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            e.preventDefault();

            const id = li.getAttribute('data-id');
            const href = a.getAttribute('href') || '#';

            try {
                const res = await fetch(NOTI_READ_URL_TMPL.replace('__ID__', id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                });

                if (res.ok) {
                    const data = await res.json().catch(() => ({}));
                    const unread = parseInt((data && data.unread_count) ?? 0);

                    if (badge) {
                        badge.textContent = unread > 99 ? '99+' : unread;
                        badge.style.display = unread > 0 ? 'inline-block' : 'none';
                    }
                    if (readAllBtn) readAllBtn.disabled = (unread === 0);

                    li.classList.add('is-read');
                    li.setAttribute('data-read', '1');
                } else {
                    console.warn('Mark-as-read failed:', res.status);
                }
            } catch (err) {
                console.error('Mark-as-read error:', err);
            } finally {
                if (href && href !== '#') window.location.href = href;
            }
        });
    });

    // ====== Nút "Đánh dấu tất cả đã đọc" ======
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('emp-read-all-btn');
        const list = document.getElementById('noti-list');
        const badge = document.getElementById('noti-count');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        if (!btn) return;

        btn.addEventListener('click', async function() {
            const action = btn.getAttribute('data-action') || NOTI_READALL_URL;
            if (btn.disabled || !action) return;

            const oldHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

            try {
                const res = await fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                });

                if (res.ok) {
                    const data = await res.json().catch(() => ({}));
                    const unread = parseInt((data && data.unread_count) ?? 0);

                    // Cập nhật badge
                    if (badge) {
                        badge.textContent = unread > 99 ? '99+' : unread;
                        badge.style.display = unread > 0 ? 'inline-block' : 'none';
                    }

                    // Đánh dấu toàn bộ item trong dropdown
                    if (list) {
                        list.querySelectorAll('li[data-id][data-read="0"]').forEach(li => {
                            li.classList.add('is-read');
                            li.setAttribute('data-read', '1');
                        });
                    }
                } else {
                    // Trường hợp 419/401 sẽ rơi vào đây
                    console.warn('Mark-all-as-read failed:', res.status);
                    alert('Không thể đánh dấu tất cả đã đọc. Vui lòng tải lại trang và thử lại.');
                }
            } catch (err) {
                console.error('Mark-all-as-read error:', err);
                alert('Có lỗi mạng khi đánh dấu tất cả đã đọc.');
            } finally {
                btn.innerHTML = oldHtml;
                // sau khi xử lý xong, nếu còn unread thì enable, nếu hết thì disable
                const currentBadge = (badge?.textContent || '0').trim();
                const currentUnread = (currentBadge === '99+') ? 99 : parseInt(currentBadge) || 0;
                btn.disabled = currentUnread === 0;
            }
        });
    });

    // ====== Chat badge ======
    document.addEventListener('DOMContentLoaded', function() {
        const chatDot = document.getElementById('chat-dot');
        const authId = {{ auth()->id() ?? 'null' }};
        if (window.Echo && authId) {
            window.Echo.private('user.' + authId)
                .listen('MessageNotification', (e) => {
                    const unread = e.unread_total;
                    if (!chatDot) return;
                    if (unread > 0) {
                        chatDot.innerText = unread > 99 ? '99+' : unread;
                        chatDot.style.display = 'flex';
                    } else {
                        chatDot.style.display = 'none';
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
