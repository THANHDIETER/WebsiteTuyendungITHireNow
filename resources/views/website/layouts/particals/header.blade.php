<header class="header-area transparent">
    <div class="container">
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-start">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main" src="../client/assets/img/logo-light.webp" alt="Logo" />
                                <img class="logo-light" src="../client/assets/img/logo-light.webp" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="header-align-center">
                        <div class="header-navigation-area position-relative">
                            <ul class="main-menu nav">
                                <li><a href="{{ route('home') }}"><span>Trang chủ</span></a></li>
                                <li class="has-submenu"><a href="{{ route('jobs.index') }}"><span>Tìm việc</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('jobs.index') }}"><span>Danh sách việc làm</span></a></li>
                                        <li><a href="{{ route('chi-tiet-cong-viec') }}"><span>Chi tiết việc làm</span></a></li>
                                    </ul>
                                </li>
                                <!-- ... các menu khác ... -->
                            </ul>

                            <!-- Nút Việc đã lưu -->
                            <ul class="navbar-nav">
                                @auth
                                <li class="nav-item">
                                    <a href="{{ route('jobs.saved') }}" class="nav-link">
                                        <i class="icofont-heart"></i> Việc đã lưu
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <div class="header-align-end">
                        <div class="header-action-area">
                            @guest
                                <a class="btn-registration" href="{{ route('register') }}">
                                    <span>+</span> Đăng ký
                                </a>
                            @else
                                <div class="user-info dropdown">
                                    <a href="#" class="user-info-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="user-avatar me-2">
                                            <i class="icofont-user-alt-3"></i>
                                        </span>
                                        <span class="user-role">{{ Auth::user()->role }}</span>
                                        <i class="icofont-caret-down ms-1"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 180px;">
                                        @if (Auth::user()->role === 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                    <i class="icofont-ui-settings me-1"></i> Trang quản trị
                                                </a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->role === 'employer' || Auth::user()->role === 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('employer.dashboard') }}">
                                                    <i class="icofont-ui-settings me-1"></i> Trang nhà tuyển dụng
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ url('profile.edit') }}">
                                                <i class="icofont-edit me-1"></i> Thay đổi thông tin
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                                <i class="icofont-logout me-1"></i> Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
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
</header>
