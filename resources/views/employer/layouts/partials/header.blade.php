<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="Edmin admin is super flexible, powerful, clean &amp; modern responsive  admin template with unlimited possibilities.">
<meta name="keywords"
    content="admin template, Edmin admin template, best javascript admin, dashboard template,  admin template, responsive admin template, web app">
<meta name="author" content="pixelstrap">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Admin' }}</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (kèm Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Favicon icon-->
<link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
<!-- Google font-->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
    rel="stylesheet">
<!-- Font awesome icon css -->
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/brands.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/solid.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendors/%40fortawesome/fontawesome-free/css/regular.css') }}">
<!-- Ico Icon css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
<!-- Flag Icon css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
<!-- Themify Icon css -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/themify-icons/themify-icons/css/themify.css') }}">
<!-- Animation css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css/animate.css') }}">
<!-- Whether Icon css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
<!-- Apex Chart css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/apexcharts.css') }}">
<!-- Data Table css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-datatables/dist/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
<!-- App css-->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<style>
    .svg-color {
        color: #000;
        transition: color 0.3s ease;
    }

    html.dark .svg-color {
        color: #ddd;
    }
</style>
<meta property="og:url" content="{{ url()->current() }}">
<header class="page-header row justify-content-between align-items-center bg-white">
    <div class="logo-wrapper d-flex align-items-center col-4" style="padding-left: 80px; ">
        <div class="d-flex justify-content-center align-items-center" style="height: 70px; width: 90px;"> @php
            $clientLogo = \App\Models\Logo::where('type', 'header')->where('is_active', true)->first();
        @endphp

            <a href="{{ route('home') }}">
                <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
                    alt="Client Logo" style="height: 120px;" {{-- hoặc dùng class --}}>
            </a>
        </div>

        <a class="close-btn ms-4" href="javascript:void(0)">
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
                <!-- Dark mode toggle -->
                <li class="modes d-flex">
                    <a href="#" class="dark-mode text-primary" title="Chế độ tối">
                        <i class="bi bi-moon-fill fs-5 svg-color"></i>
                    </a>
                </li>
                <!-- Trang chủ -->
                <li class="modes d-flex">
                    <a href="{{ route('home') }}" class="text-dark" title="Trang chủ">
                        <i class="bi bi-house-door-fill svg-color fs-5 svg-color"></i>
                    </a>
                </li>
                <!-- Trang quản trị -->
                <li class="modes d-flex">
                    <a href="{{ route('admin.dashboard') }}" class="text-dark" title="Trang quản trị">
                        <i class="bi bi-speedometer2 svg-color fs-5"></i>
                    </a>
                </li>

                <!-- Notification menu -->
                <li class="custom-dropdown">
                    <a href="javascript:void(0)" id="notification-toggle" title="Thông báo">
                        <i class="bi bi-bell-fill svg-color circle-color fs-5"></i>
                    </a>
                    <span class="badge rounded-pill badge-secondary" id="noti-count">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>

                    <div class="custom-menu notification-dropdown py-0 overflow-hidden">
                        <h5 class="title bg-primary-light">
                            Notifications
                            <a href="{{ route('employer.notifications.index') }}">
                                <span class="font-primary">View</span>
                            </a>
                        </h5>
                        <ul class="activity-update" id="noti-list">
                            @php $unreads = auth()->user()->unreadNotifications->take(5); @endphp
                            @if ($unreads->count())
                                @foreach ($unreads as $noti)
                                    <li class="d-flex align-items-center b-l-primary" data-id="{{ $noti->id }}">
                                        <div class="flex-grow-1">
                                            <span>{{ $noti->created_at->diffForHumans() }}</span>
                                            <a href="{{ $noti->data['link_url'] ?? '#' }}">
                                                <h5>{{ $noti->data['message'] ?? 'Có thông báo mới!' }}</h5>
                                            </a>
                                            <h6>{{ config('app.name') }}</h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/default.jpg') }}"
                                                alt="">
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="d-flex justify-content-center p-2 text-muted">
                                    Không có thông báo mới
                                </li>
                            @endif
                            <li class="mt-3 d-flex justify-content-center">
                                <div class="button-group">
                                    <a class="btn btn-secondary"
                                        href="{{ route('employer.notifications.index') }}">AllNotification</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- tin nhắn chat -->
                <li class="custom-dropdown">
                    <a href="{{ route('chat.index') }}" title="Tin nhắn">
                        <i class="bi bi-chat-dots-fill svg-color fs-5"></i>
                    </a>
                    <span id="chat-dot" class="badge rounded-pill badge-tertiary">
                        {{ $totalUnread > 99 ? '99+' : $totalUnread }}
                    </span>
                </li>

                <!-- thông tin profile -->
                <li class="profile-dropdown custom-dropdown position-relative">
                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                        <img loading="lazy" src="{{ asset('assets/images/profile.png') }}" alt="Profile"
                            class="rounded-circle" width="36" height="36">
                        <div>
                            <h6 class="mb-0 fw-semibold">
                                @if (auth()->check())
                                    {{ auth()->user()->name }}
                                    <sup class="text-danger" style="font-size: 0.7em;">{{ auth()->user()->id }}</sup>
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </h6>
                            <small class="text-muted">
                                @if (auth()->check())
                                    {{ auth()->user()->role }}
                                @else
                                    Chưa đăng nhập
                                @endif
                            </small>
                        </div>
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

<!-- Laravel Echo & Pusher -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

<script>
    // 1. Dark mode toggle, giữ trạng thái
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeBtn = document.querySelector('.dark-mode');
        if (darkModeBtn) {
            darkModeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ?
                    'dark' : 'light');
            });
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        }
    });

    // 2. Khởi tạo Echo/Pusher
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1ea633f39dfb08c3c0c2',
        cluster: 'ap1',
        forceTLS: true,
    });

    // 3. Thông báo realtime cho dropdown
    const userId = {{ auth()->id() }};
    if (userId && window.Echo) {
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                // Cập nhật badge
                const notiCount = document.getElementById('noti-count');
                if (notiCount) {
                    let count = parseInt(notiCount.textContent) || 0;
                    notiCount.textContent = (count + 1) > 99 ? '99+' : (count + 1);
                    notiCount.style.display = 'inline-block';
                }
                // Thêm notification mới vào dropdown
                const notiList = document.getElementById('noti-list');
                if (notiList) {
                    // Xóa dòng "Không có thông báo mới" nếu có
                    let emptyLi = notiList.querySelector('.text-muted');
                    if (emptyLi) notiList.removeChild(emptyLi);

                    // Tạo notification mới
                    const li = document.createElement('li');
                    li.className = 'd-flex align-items-center b-l-primary';
                    li.setAttribute('data-id', notification.id);
                    li.innerHTML = `
                        <div class="flex-grow-1">
                            <span>Vừa xong</span>
                            <a href="${notification.link_url}">
                                <h5>${notification.message}</h5>
                            </a>
                            <h6>{{ config('app.name') }}</h6>
                        </div>
                        <div class="flex-shrink-0">
                            <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/default.jpg') }}" alt="">
                        </div>
                    `;
                    // Chèn notification mới lên đầu, giữ nút AllNotification ở cuối
                    const allBtnLi = notiList.lastElementChild;
                    notiList.insertBefore(li, allBtnLi);

                    // Giữ tối đa 5 notification mới nhất (trước nút AllNotification)
                    let notiItems = notiList.querySelectorAll('li[data-id]');
                    if (notiItems.length > 5) {
                        notiList.removeChild(notiItems[notiItems.length - 1]);
                    }
                }
            });
    }

    // 4. Global notification (giữ nguyên)
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('global-notification')
            .listen('.global.notification', function (data) {
                showGlobalNotification(data.message, data.link);
            });
    }

    function showGlobalNotification(message, link) {
        const old = document.getElementById('global-toast');
        if (old) old.remove();
        let html = `<div id="global-toast" style="
            position:fixed;top:24px;right:24px;z-index:99999;
            background:#232323;color:#fff;padding:16px 32px;
            border-radius:8px;font-size:1.1rem;box-shadow:0 2px 12px #0006;
            display:flex;align-items:center;
        ">
            <span>${message}</span>
            ${link ? `<a href="${link}" style="color:#ffd700;text-decoration:underline;margin-left:12px;">Xem</a>` : ''}
            <span style="cursor:pointer;float:right;font-weight:bold;margin-left:16px;" onclick="this.parentNode.remove()">×</span>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', html);
        setTimeout(() => {
            const gt = document.getElementById('global-toast');
            if (gt) gt.remove();
        }, 10000);
    }

    // 5. Chat badge (giữ nguyên)
    document.addEventListener('DOMContentLoaded', function () {
        const chatDot = document.getElementById('chat-dot');
        const authId = {{ auth()->id() }};
        if (window.Echo && authId) {
            window.Echo.private('user.' + authId)
                .listen('MessageNotification', (e) => {
                    const unread = e.unread_total;
                    if (chatDot) {
                        if (unread > 0) {
                            chatDot.innerText = unread > 99 ? '99+' : unread;
                            chatDot.style.display = 'flex';
                        } else {
                            chatDot.style.display = 'none';
                        }
                    }
                });
        }
    });
</script>