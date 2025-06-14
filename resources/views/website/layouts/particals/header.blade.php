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
                                    <a href="{{ route('blog') }}"><span>Blog</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('blog') }}">Blog Grid</a></li>
                                        <li><a href="{{ route('blog-grid') }}">Blog Left Sidebar</a></li>
                                        <li><a href="{{ route('blog-right-sidebar') }}">Blog Right Sidebar</a></li>
                                        <li><a href="{{ route('blog-details') }}">Chi Tiết Bài Viết</a></li>
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
                                <div class="user-info dropdown">
                                    <a href="#" class="user-info-toggle d-flex align-items-center"
                                        data-bs-toggle="dropdown">
                                        <span class="user-avatar me-2"><i class="icofont-user-alt-3"></i></span>
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
                                        @elseif (Auth::user()->role === 'employer')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('employer.details') }}">
                                                    <i class="icofont-building-alt me-1"></i> Quản lý nhà tuyển dụng
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <a class="dropdown-item" href="{{ url('profile.edit') }}">
                                                <i class="icofont-edit me-1"></i> Thay đổi thông tin
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
<<<<<<< HEAD
</header>
<<<<<<< HEAD
=======


>>>>>>> b112181 (luồng chính web)
=======



</header>
>>>>>>> c6f1b9f (sửa lại giao diện)
