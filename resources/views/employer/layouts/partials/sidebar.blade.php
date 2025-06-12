<!-- Bắt đầu sidebar trang -->
<div class="overlay"></div>
<aside class="page-sidebar" data-sidebar-layout="stroke-svg">
    <div class="left-arrow" id="left-arrow">
        <!-- Icon mũi tên trái -->
        <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>
    <div id="sidebar-menu">
        <ul class="sidebar-menu" id="simple-bar">

            <li class="sidebar-main-title">Chung</li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Quản lý tài khoản</span>
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('showLoginForm') }}">Đăng ký / Đăng nhập</a></li>
                          
                    <li><a href="#">Hồ sơ doanh nghiệp</a></li>
                    {{-- <li><a href="{{ route('employer.company.profile') }}">Hồ sơ doanh nghiệp</a></li> --}}
                </ul>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 4h6a2 2 0 012 2v1H7V6a2 2 0 012-2z" stroke="currentColor" stroke-width="2" />
                        <path d="M7 7h10v13a2 2 0 01-2 2H9a2 2 0 01-2-2V7z" stroke="currentColor" stroke-width="2" />
                        <path d="M9 11h6M9 15h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>Quản lý tin tuyển dụng</span>
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('employer.jobs.create') }}">Tạo tin tuyển dụng</a></li>
                    <li><a href="{{ route('employer.jobs.index') }}">Danh sách tin đã đăng</a></li>
                    <li><a href="#">Trạng thái tin tuyển dụng</a></li>
                    {{-- <li><a href="{{ route('employer.jobs.status') }}">Trạng thái tin tuyển dụng</a></li> --}}
                </ul>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="5" width="20" height="14" rx="2" ry="2"
                            stroke="currentColor" stroke-width="2" />
                        <path d="M2 10h20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>Mua và quản lý gói dịch vụ</span>
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('employer.packages.index') }}">Mua gói đăng tin</a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> RTL
                        </a></li>
                    <li><a href="{{ route('employer.subscriptions.index') }}">Quản lý gói đã mua</a></li>
                </ul>
            </li>
            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.jobs.applications') }}">
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="8.5" cy="7" r="4" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20 8v6M23 11h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>Quản lý ứng viên</span>
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    {{-- <li><a href="{{ route('employer.applications.index') }}">Nhận hồ sơ ứng tuyển</a></li>
                    <li><a href="{{ route('employer.applications.review') }}">Lọc và đánh giá</a></li>
                    <li><a href="{{ route('employer.applications.contact') }}">Liên hệ ứng viên</a></li> --}}
                </ul>
            </li>
            <li class="sidebar-list">
                {{-- <a class="sidebar-link" href="{{ route('employer.inbox') }}"> --}}
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="2" />
                        <path d="M4 4l8 8 8-8" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span>Hộp thư và thông báo</span>
                </a>
            </li>
            <li class="sidebar-list">
                {{-- <a class="sidebar-link" href="{{ route('employer.reports.index') }}">   --}}
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3v18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M9 17V9M15 17V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>Thống kê & báo cáo</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow">
        <!-- Icon mũi tên phải -->
        <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>
</aside>

