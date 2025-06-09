<header class="header-area transparent">

    <div class="container">
        <div class="row no-gutter align-items-center position-relative">
            <div class="col-12">
                <div class="header-align">
                    <div class="header-align-start">
                        <div class="header-logo-area">
                            <a href="index.html">
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
                                        <li><a href="{{ route('chi-tiet-cong-viec') }}"><span>Chi tiết việc
                                                    làm</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('chi-tiet-nhan-vien') }}"><span>Chi tiết nhà tuyển dụng</span></a>
                                </li>
                                <li class="has-submenu"><a href="{{ route('ung-vien') }}"><span>Ứng viên</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('ung-vien') }}"><span>Danh sách ứng viên</span></a></li>
                                        <li><a href="{{ route('chi-tiet-ung-vien') }}"><span>Chi tiết ứng
                                                    viên</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu"><a href="{{ route('blog') }}"><span>Tin tức</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('blog') }}">Lưới tin tức</a></li>
                                        <li><a href="{{ route('blog-grid') }}">Blog (sidebar trái)</a></li>
                                        <li><a href="{{ route('blog-right-sidebar') }}">Blog (sidebar phải)</a></li>
                                        <li><a href="{{ route('blog-details') }}">Chi tiết bài viết</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="index.html#/"><span>Trang khác</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('about-us') }}"><span>Giới thiệu</span></a></li>
                                        @guest
                                            <li><a href="{{ route('showLoginForm') }}"><span>Đăng nhập</span></a></li>
                                            <li><a href="{{ route('register') }}"><span>Đăng ký</span></a></li>
                                        @endguest
                                        <li><a href="{{ route('404') }}"><span>Không tìm thấy trang</span></a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('contact') }}"><span>Liên hệ</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-align-end">
                        <div class="header-action-area">
                            @guest
                                <!-- Nếu chưa đăng nhập -->
                                <a class="btn-registration" href="{{ route('register') }}">
                                    <span>+</span> Đăng ký
                                </a>
                            @else
                                <!-- Nếu đã đăng nhập -->
                                <div class="user-info dropdown">
                                    <a href="#" class="user-info-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                                        aria-expanded="false">
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
                                        <li>
                                            <a class="dropdown-item" href="{{ url('profile.edit') }}">
                                                <i class="icofont-edit me-1"></i> Thay đổi thông tin
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="{{route('logout')}}">
                                                <i class="icofont-logout me-1"></i> Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            @endguest


                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
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
