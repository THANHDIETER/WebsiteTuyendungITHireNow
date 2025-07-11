<header class="header-area transparent">

    <div class="container">
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-start">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main" src="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}"
                                    alt="Logo" />
                                <img class="logo-light" src="{{ asset('client/assets/img/logo-ithirenow-glow.png') }}"
                                    alt="Logo" />
                            </a>
                        </div>
                    </div>

                    <div class="header-align-center">
                        <div class="header-navigation-area position-relative">
                            <ul class="main-menu nav">
                                <li><a href="{{ route('home') }}"><span>Trang Chủ</span></a></li>

                                <li class="has-submenu">
                                    <a href="{{ route('jobs.index') }}"><span>Tìm Việc Làm</span></a>
                                </li>

                                <li><a href="{{ route('chi-tiet-nhan-vien') }}">Chi Tiết Nhà Tuyển Dụng</a></li>

                                <li class="has-submenu">
                                    <a href="{{ route('ung-vien') }}">Ứng Cử Viên</a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('ung-vien') }}">Ứng Cử Viên</a></li>
                                        <li><a href="{{ route('chi-tiet-ung-vien') }}">Chi Tiết Ứng Viên</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="{{ route('blog.index') }}"><span>Blog</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('blog.index') }}">Blog Grid</a></li>
                                        <li><a href="{{ route('blog-grid') }}">Blog Left Sidebar</a></li>
                                        <li><a href="{{ route('blog.rightSidebar') }}">Blog Right Sidebar</a></li>
                                        @isset($blog)
                                            <a href="{{ route('blog.show', ['id' => $blog->id]) }}">Chi Tiết Bài Viết</a>
                                        @endisset

                                    </ul>
                                </li>

                                <li><a href="{{ route('contact') }}">Liên Hệ</a></li>

                                <li class="has-submenu">
                                    <a href="#"><span>Trang Khác</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('about-us') }}">Thông Tin</a></li>
                                        <li><a href="{{ route('showLoginForm') }}">Đăng Nhập</a></li>
                                        <li><a href="{{ route('register') }}">Đăng Ký</a></li>
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
                                <div class="row">
                                    <div class="col">
                                        {{-- 🔔 Chuông thông báo --}}
                                        <div class="dropdown me-3">
                                            <button class="btn btn-icon btn-notification position-relative " type="button"
                                                id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="icofont-notification fs-5 text-white"></i>
                                                @if (auth()->user()->unreadNotifications->count())
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                        id="noti-count">
                                                        {{ auth()->user()->unreadNotifications->count() }}
                                                    </span>
                                                @endif
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3"
                                                aria-labelledby="notificationDropdown"
                                                style="min-width: 320px; max-height: 400px; overflow-y: auto;"
                                                id="noti-list">
                                                <li
                                                    class="dropdown-header bg-light fw-semibold text-dark px-3 py-2 d-flex justify-content-between align-items-center">
                                                    <span>Thông báo</span>
                                                    <a href="{{ route('job_seeker.notifications.index') }}"
                                                        class="text-primary small">Xem tất cả</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider my-1">
                                                </li>
                                                @forelse(auth()->user()->unreadNotifications->take(5) as $noti)
                                                    <li data-id="{{ $noti->id }}">
                                                        <a class="dropdown-item d-flex align-items-start px-3 py-2 gap-2"
                                                            href="{{ $noti->data['link_url'] }}">
                                                            <div class="icon text-primary"><i class="icofont-bell fs-5"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="fw-semibold">{{ $noti->data['message'] }}</div>
                                                                <div class="small text-muted">
                                                                    {{ $noti->created_at->diffForHumans() }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li id="noti-empty">
                                                        <div class="text-center text-muted px-3 py-3">
                                                            Không có thông báo mới
                                                        </div>
                                                    </li>
                                                @endforelse

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- 👤 Menu người dùng --}}
                                        <div class="user-info dropdown">
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
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        {{ request()->is('profile/my-jobs') ? 'active text-primary' : '' }}
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
                                                            quản trị
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Nhà tuyển dụng --}}
                                                @if (Auth::user()->role === 'employer' || Auth::user()->role === 'admin')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="{{ route('employer.dashboard') }}">
                                                            <i class="fa-solid fa-building me-2 text-success"></i> Trang nhà
                                                            tuyển
                                                            dụng
                                                        @elseif (Auth::user()->role === 'employer')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('employer.details') }}">
                                                            <i class="icofont-building-alt me-1"></i> Quản lý nhà tuyển
                                                            dụng

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

    @if (session('access_token'))
        <script>
            localStorage.setItem('access_token', "{{ session('access_token') }}");
        </script>
    @endif

    <script>
        setInterval(() => {
            fetch('/seeker/notifications/latest')
                .then(res => res.json())
                .then(data => {
                    const list = document.getElementById("noti-list");
                    const count = document.getElementById("noti-count");

                    if (!list) return;

                    data.forEach(noti => {
                        // Kiểm tra nếu thông báo chưa có trong danh sách thì thêm mới
                        if (!list.querySelector(`li[data-id="${noti.id}"]`)) {
                            const html = `
                            <li data-id="${noti.id}">
                                <a class="dropdown-item d-flex align-items-start px-3 py-2 gap-2"
                                   href="${noti.link_url}">
                                    <div class="icon text-primary">
                                        <i class="icofont-bell fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">${noti.message}</div>
                                        <div class="small text-muted">${noti.time}</div>
                                    </div>
                                </a>
                            </li>`;

                            const empty = document.getElementById("noti-empty");
                            if (empty) empty.remove(); // xoá nếu có dòng "Không có thông báo"

                            // Thêm vào cuối danh sách
                            list.insertAdjacentHTML("beforeend", html);
                        }
                    });

                    // Cập nhật badge số lượng
                    if (count) {
                        count.innerText = data.length;
                        count.classList.toggle("d-none", data.length === 0);
                    }
                });
        }, 5000);
    </script>


</header>
