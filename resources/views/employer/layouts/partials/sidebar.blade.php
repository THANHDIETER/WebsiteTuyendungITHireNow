<style>
    /* Default (Light Mode) */
    .page-sidebar {
        top: 24px;
        width: 250px;
        background: #fff;
        min-height: 100vh;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu a {
        text-decoration: none !important;
        transition: background-color 0.2s ease, color 0.2s ease;
        padding: 10px 14px;
        display: block;
        border-radius: 6px;
        color: #212529;
        font-weight: 500;
    }

    .sidebar-menu a:hover {
        background-color: #f0f8ff;
        color: #0d6efd !important;
    }

    .sidebar-main-title {
        font-size: 14px;
        font-weight: 600;
        padding: 10px 16px;
        color: #495057;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-submenu {
        margin-right: 24px;
    }

    /* 
    /* .sidebar-submenu li a {
        font-size: 13px;
        padding: 6px 10px;
    } */
    */ .badge-primary {
        background-color: #0d6efd;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
    }

    .sidebar-icon {
        margin-right: 8px;
        font-size: 16px;
    }

    /* DARK MODE */
    .dark .page-sidebar {
        background: #212529;
    }

    .dark .sidebar-main-title {
        color: #dee2e6;
        background: #343a40;
        border-top: 1px solid #495057;
        border-bottom: 1px solid #495057;
    }

    .dark .sidebar-menu a {
        color: #dee2e6;
    }

    .dark .sidebar-menu a:hover {
        background-color: #495057;
        color: #0d6efd !important;
    }
</style>

<aside class="page-sidebar" data-sidebar-layout="stroke-svg">
    <!-- Mũi tên trái -->
    <div class="left-arrow" id="left-arrow" role="button">
        <i class="bi bi-chevron-left"></i>
    </div>
    <div id="sidebar-menu">
        <li class="sidebar-main-title text-center">Chung</li>
        <ul class="sidebar-menu" id="simple-bar">
            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-briefcase"></i>
                    <span>Quản lý thống kê</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('employer.dashboard') }}">
                            <i class="bi bi-bar-chart-line me-2"></i> Thống kê v1
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employer.dashboard.filter') }}">
                            <i class="bi bi-graph-up-arrow me-2"></i> Thống kê v2
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-briefcase"></i>
                    <span>Quản lý tin tuyển dụng</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('employer.jobs.create') }}">
                            <!-- <i class="bi bi-plus-circle me-2"></i>  -->
                            Tạo tin tuyển dụng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employer.jobs.index') }}">
                            <!-- <i class="bi bi-list-ul me-2"></i>  -->
                            Danh sách tin đã đăng
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.jobs.applications') }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý ứng viên</span>
                </a>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.packages.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Mua gói dịch vụ</span>
                </a>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.companies.show', $employerCompany->id) }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý công ty</span>
                </a>
            </li>
             <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.company.branches.index', $employerCompany->id) }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý chi nhánh</span>
                </a>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.package.logs.index') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Lịch sử</span>
                </a>
            </li>
        </ul>
    </div>

</aside>