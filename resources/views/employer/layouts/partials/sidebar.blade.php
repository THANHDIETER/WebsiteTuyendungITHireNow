<div class="overlay"></div>
<aside class="page-sidebar" data-sidebar-layout="stroke-svg">
    <!-- Mũi tên trái -->
    <div class="left-arrow" id="left-arrow" role="button">
        <i class="bi bi-chevron-left"></i>
    </div>
    <div id="sidebar-menu">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="sidebar-main-title">Chung</li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.jobs.applications') }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý ứng viên</span>
                </a>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-briefcase"></i>
                    <span>Quản lý tin tuyển dụng</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('employer.jobs.create') }}">Tạo tin tuyển dụng</a></li>
                    <li><a href="{{ route('employer.jobs.index') }}">Danh sách tin đã đăng</a></li>
                </ul>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.packages.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Mua gói dịch vụ</span>
                </a>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link" href="{{ route('employer.companies.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý công ty</span>
                </a>
            </li>
        </ul>
    </div>

</aside>
<style>
    .page-sidebar {
        top: 25px;
        width: 250px;
        background: #fff;
        color: #212529;
        border-right: 1px solid #e9ecef;
        min-height: 100vh;
        transition: background .2s, color .2s;
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

    .page-sidebar.dark-theme,
    .dark-theme .page-sidebar {
        background: #222831;
        color: #f4f4f4;
        border-color: #323a45;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 18px;
        color: inherit;
        text-decoration: none;
        border-radius: 6px;
        transition: background .2s, color .2s;
    }

    .sidebar-link:hover,
    .sidebar-list.active>.sidebar-link {
        background: #e9ecef;
        color: #0062cc;
    }

    .dark-theme .sidebar-link:hover,
    .dark-theme .sidebar-list.active>.sidebar-link {
        background: #303848;
        color: #00b4d8;
    }

    .sidebar-main-title {
        font-size: 1.08em;
        font-weight: 700;
        opacity: .8;
        letter-spacing: 0.5px;
    }

    .sidebar-submenu {
        list-style: none;
        padding-left: 38px;
        margin: 0;
        display: none;
    }

    .sidebar-list.active .sidebar-submenu {
        display: block;
    }

    .sidebar-submenu li a {
        display: block;
        padding: 7px 0;
        color: inherit;
        text-decoration: none;
        opacity: .85;
        transition: color .2s;
    }

    .sidebar-submenu li a:hover {
        color: #0d6efd;
    }

    .dark-theme .sidebar-submenu li a:hover {
        color: #00b4d8;
    }

    .left-arrow,
    .right-arrow {
        cursor: pointer;
        display: flex;
        align-items: center;
        height: 40px;
        padding: 0 10px;
        color: inherit;
        font-size: 1.3em;
        transition: color .2s;
    }

    .overlay {
        display: none;
        /* Show when sidebar is mobile open */
    }
</style>