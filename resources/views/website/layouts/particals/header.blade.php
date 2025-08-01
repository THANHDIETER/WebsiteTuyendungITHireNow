<header class="header-area transparent">
    <div class="container">
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align " style="align-items: center; height: 80px;">
                    <div class="header-align-start">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                @php
                                    $clientLogo = \App\Models\Logo::where('type', 'client')
                                        ->where('is_active', true)
                                        ->first();
                                @endphp

                                <img src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : asset('images/default.png') }}"
                                    alt="Client Logo" style="height: 120px;" {{-- hoặc dùng class --}}>
                            </a>

                        </div>
                    </div>
                    <div class="header-align-center me-3">
                        <div class="header-navigation-area position-relative">
                            <ul class="main-menu nav">
                                <li><a href="{{ route('home') }}"><span>Trang Chủ</span></a></li>
                                <li class="has-submenu"><a href="{{ route('jobs.index') }}"><span>Tìm Việc
                                            Làm</span></a></li>
                                <li><a href="{{ route('chi-tiet-nhan-vien') }}">Chi Tiết Nhà Tuyển Dụng</a></li>
                                <li class="has-submenu">
                                    <a href="{{ route('ung-vien') }}">Ứng Cử Viên</a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('ung-vien') }}">Ứng Cử Viên</a></li>
                                        <li><a href="{{ route('chi-tiet-ung-vien') }}">Chi Tiết Ứng Viên</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="{{ route('blog') }}"><span>Blog</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('blog') }}">Blog Grid</a></li>
                                        <li><a href="{{ route('blog-grid') }}">Blog Left Sidebar</a></li>
                                        <li><a href="{{ route('blog-right-sidebar') }}">Blog Right Sidebar</a></li>
                                        <li><a href="">Chi Tiết Bài Viết</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('contact') }}">Liên Hệ</a></li>
                                <li class="has-submenu">
                                    <a href="#"><span>Trang Khác</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('about-us') }}">Thông Tin</a></li>
                                        <li><a href="{{ route('404') }}">Không tìm thấy trang</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-align-end">
                        <div class="header-action-area">
                            @guest
                                <a class="btn-registration" href="{{ route('showLoginForm') }}">
                                    Đăng Nhập
                                </a>
                            @else
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- 🔔 ICON THÔNG BÁO động -->
                                        <div class="me-3">
                                            <a href="{{ route('notifications.index') }}"
                                                class="btn btn-icon position-relative p-0 bg-transparent border-0"
                                                aria-label="Thông báo">
                                                <i id="notification-bell" class="bi bi-bell fs-4 text-white"></i>
                                                <span id="notification-dot"
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__bounce"
                                                    style="display: {{ auth()->user()->unreadNotifications->count() > 0 ? 'inline-block' : 'none' }}; font-size:10px; min-width:12px; height:12px; padding:0;">
                                                </span>
                                            </a>
                                        </div>
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
                                            console.log('ffff', window.Echo);

                                            const userId = {{ auth()->id() }};

                                            if (userId && window.Echo) {
                                                window.Echo.private(`App.Models.User.${userId}`)
                                                    .notification((notification) => {
                                                        console.log('Received new notification via Pusher:', notification);

                                                        // Hiện badge đỏ notification-dot
                                                        const notificationDot = document.getElementById('notification-dot');
                                                        if (notificationDot) {
                                                            notificationDot.style.display = 'inline-block';
                                                        }
                                                    });
                                            } else {
                                                console.warn('User is not logged in or Echo is not initialized.');
                                            }
                                        </script>

                                    </div>

                                    <!--icon chat nhắn tin  -->
                                    <div class="col-auto">
                                        <div class="dropdown me-3">
                                            <a class="btn btn-icon position-relative p-0 bg-transparent border-0"
                                                href="{{ route('chat.index') }}" id="chatDropdown" aria-label="Tin nhắn">
                                                <i id="chat-bubble" class="bi bi-chat-dots fs-4 text-white"></i>

                                                @if (isset($totalUnread) && $totalUnread > 0)
                                                    <span id="chat-dot"
                                                        class="position-absolute top-0 start-100 translate-middle bg-danger text-white d-flex justify-content-center align-items-center rounded-circle shadow"
                                                        style="font-size: 10px; min-width: 18px; height: 18px; padding: 0 4px; border: 2px solid #fff;">
                                                        {{ $totalUnread > 99 ? '99+' : $totalUnread }}
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- 👤 Menu người dùng --}}
                                        <div class="user-info dropdown me-3">
                                            <a href="#" class="user-info-toggle d-flex align-items-center"
                                                data-bs-toggle="dropdown">
                                                <span class="user-avatar me-2"><i class="icofont-user-alt-3"></i></span>
                                                <span class="user-role">{{ Auth::user()->role }}</span>
                                                <i class="icofont-caret-down ms-1"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 200px;">
                                                {{-- Tổng quan --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center {{ request()->is('dashboard') ? 'active text-primary' : '' }}"
                                                        href="{{ route('profile.dashboard') }}">
                                                        <i class="fa-solid fa-house me-2"></i> Tổng quan
                                                    </a>
                                                </li>
                                                {{-- Hồ sơ --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center {{ request()->is('profile/show') ? 'active text-primary' : '' }}"
                                                        href="{{ route('profile.show') }}">
                                                        <i class="fa-solid fa-file-lines me-2"></i> Hồ sơ HireNow
                                                    </a>
                                                </li>
                                                {{-- Việc làm của tôi --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center {{ request()->is('profile/my-jobs') ? 'active text-primary' : '' }}"
                                                        href="{{ route('profile.my-jobs') }}">
                                                        <i class="fa-solid fa-briefcase me-2"></i> Việc làm của tôi
                                                    </a>
                                                </li>
                                                {{-- Admin --}}
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('admin.dashboard') }}">
                                                            <i class="fa-solid fa-user-shield me-2 text-danger"></i> Trang
                                                            quản
                                                            trị
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Nhà tuyển dụng --}}
                                                @if (Auth::user()->role === 'employer' || Auth::user()->role === 'admin')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('employer.dashboard') }}">
                                                            <i class="fa-solid fa-building me-2 text-success"></i> Trang nhà
                                                            tuyển dụng
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->role === 'employer')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('employer.details') }}">
                                                            <i class="icofont-building-alt me-1"></i> Quản lý nhà tuyển dụng
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('profile.settings') }}">
                                                        <i class="fa-solid fa-gear me-2"></i> Cài đặt
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                                        <i class="icofont-logout me-1"></i> Đăng xuất
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endguest

                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu">
                                <i class="icofont-navigation-menu"></i>
                            </button>
                        </div>
                    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                    } else {
                        // Nếu chưa có sẵn badge, thì tạo mới
                        const aTag = document.getElementById('chatDropdown');
                        if (aTag) {
                            const badge = document.createElement('span');
                            badge.id = 'chat-dot';
                            badge.className =
                                'position-absolute top-0 start-100 translate-middle bg-danger text-white d-flex justify-content-center align-items-center rounded-circle shadow';
                            badge.style =
                                'font-size: 10px; min-width: 18px; height: 18px; padding: 0 4px; border: 2px solid #fff;';
                            badge.innerText = unread > 99 ? '99+' : unread;
                            aTag.appendChild(badge);
                        }
                    }
                });
            }
        }, 5000);

    </script>


</header>