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
    <style>
        footer {
            display: none !important;
        }

        .sidebar-menu a {
            text-decoration: none !important;
            transition: background-color 0.2s ease, color 0.2s ease;
            padding: 8px 12px;
            display: block;
            border-radius: 6px;
        }

        .sidebar-menu a:hover {
            background-color: #f0f8ff;
            color: #379279 !important;
        }
    </style>
    <div id="sidebar-menu">
        <ul class="sidebar-menu" id="simple-bar">

            <!-- Phần Ghim -->
            <li class="pin-title sidebar-list p-0">
                <h5 class="sidebar-main-title">Đã ghim</h5>
            </li>
            <li class="line pin-line"></li>

            <!-- Phần Chung -->
            <li class="sidebar-main-title">Chung</li>

            <!-- Dashboard -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Trang chủ -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" stroke="currentColor" stroke-width="2"
                            stroke-linejoin="round" />
                        <path d="M9 21V12h6v9" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span>Bảng điều khiển</span>
                    <div class="badge badge-primary rounded-pill">3</div>
                    <!-- Icon mũi tên phải -->
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.dashboard') }}">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Mặc định
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Thương mại điện tử
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Dự án
                        </a></li>
                </ul>
            </li>

            <!-- Widgets -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Pie Chart -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <path d="M12 2v10h10" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span>Widgets</span>
                    <!-- Icon mũi tên phải -->
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Chung
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Biểu đồ
                        </a></li>
                </ul>
            </li>

            <!-- Bố cục trang -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Document -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="currentColor"
                            stroke-width="2" stroke-linejoin="round" />
                        <path d="M14 2v6h6" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span>Bố cục trang</span>
                    <!-- Icon mũi tên phải -->
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Bố cục hộp
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> RTL
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Giao diện tối
                        </a></li>
                </ul>
            </li>

            <li class="line"></li>

            <!-- Phần Ứng dụng -->
            <li class="sidebar-main-title">Ứng dụng</li>

            <!-- Dự án -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Info Circle -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <line x1="12" y1="16" x2="12" y2="12" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" />
                        <circle cx="12" cy="8" r="1" fill="currentColor" />
                    </svg>
                    <span>Dự án</span>
                    <!-- Icon mũi tên phải -->
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Danh sách dự án
                        </a></li>
                    <li><a href="#">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Tạo mới
                        </a></li>
                </ul>
            </li>

            <!-- Quản lý file -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Paper -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l7 7v9a2 2 0 01-2 2z" stroke="currentColor"
                            stroke-width="2" stroke-linejoin="round" />
                        <path d="M14 2v7h7" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span>Quản lý file</span>
                </a>
            </li>

            <!-- Duyệt tin tuyển dụng -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="{{ route('admin.jobs.index') }}">
                    <!-- Icon Wallet -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"
                            stroke="currentColor" stroke-width="2" />
                        <path d="M16 3v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M22 11h-6a2 2 0 00-2 2v4" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Duyệt tin tuyển dụng</span>
                </a>
            </li>

            <!-- Duyệt CV ứng viên -->
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                </svg>
                <a class="sidebar-link" href="{{ route('admin.resumes.index') }}">
                    <!-- Icon mới ở đây -->
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                    </svg>
                    <span>Duyệt CV ứng viên</span>
                </a>
            </li>
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                </svg>
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                    </svg>
                    <span>Quản lý users</span>
                </a>
            </li>
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                </svg>
                <a class="sidebar-link" href="{{ route('admin.reports.index') }}">
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                    </svg>
                    <span>Quản lý nội dung vi phạm</span>
                </a>
            </li>
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z" />
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    <line x1="12" y1="22.08" x2="12" y2="12" />
                </svg>
                <a class="sidebar-link" href="{{ route('admin.service-packages.index') }}">
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z" />
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                        <line x1="12" y1="22.08" x2="12" y2="12" />
                    </svg>
                    <span>Quản lý gói dịch vụ</span>
                </a>
            </li>
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                </svg>
                <a class="sidebar-link" href="{{ route('admin.seekerprofile.index') }}">
                    <!-- Icon mới ở đây -->
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                    </svg>
                    <span>Duyệt CV ứng viên</span>
                </a>
            </li>
            <li class="sidebar-list">
                <svg class="pinned-icon" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                </svg>
                <a class="sidebar-link" href="{{ route('admin.payment.index') }}">
                    <!-- Icon mới ở đây -->
                    <svg class="stroke-icon" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0113 0"></path>
                    </svg>
                    <span>Payments</span>
                </a>
            </li>



            <!-- Gửi Thông Báo Hệ Thống -->
            <li class="sidebar-list">
                <!-- Icon Ghim -->
                <svg class="pinned-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2l-2 2-4 14-4-14-2-2 2-2 2 2 4 14 4-14 2-2z" stroke="currentColor" stroke-width="2"
                        stroke-linejoin="round" fill="none" />
                </svg>
                <a class="sidebar-link" href="#">
                    <!-- Icon Info Circle -->
                    <svg class="stroke-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <line x1="12" y1="16" x2="12" y2="12" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" />
                        <circle cx="12" cy="8" r="1" fill="currentColor" />
                    </svg>
                    <span>Hệ Thống Thông Báo</span>
                    <!-- Icon mũi tên phải -->
                    <svg class="feather" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('admin.notifications.index') }}">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> DS Thông Báo
                        </a></li>
                    <li><a href="{{ route('admin.notifications.create') }}">
                            <svg class="svg-menu" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Thêm Thông Báo
                        </a></li>
                </ul>
            </li>


            <li class="line"></li>
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
<!-- Kết thúc sidebar trang -->
