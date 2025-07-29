<style>
    .page-sidebar {
        top: 25px;
        width: 250px;
        background: #fff;

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
        padding-left: 24px;
    }

    .sidebar-submenu li a {
        font-size: 13px;
        padding: 6px 10px;
    }

    .badge-primary {
        background-color: #0d6efd;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
    }

    .sidebar-icon {
        margin-right: 8px;
        font-size: 16px;
    }
</style>

<aside class="page-sidebar">
    <ul class="sidebar-menu">

        <li class="sidebar-main-title">Chức năng chính</li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer sidebar-icon"></i> Bảng điều khiển
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.jobs.index') }}">
                <i class="bi bi-briefcase sidebar-icon"></i> Duyệt tin tuyển dụng
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.seekerprofile.index') }}">
                <i class="bi bi-person-lines-fill sidebar-icon"></i> Duyệt CV ứng viên
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.service-packages.index') }}">
                <i class="bi bi-box sidebar-icon"></i> Gói dịch vụ
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.notifications.index') }}">
                <i class="bi bi-bell sidebar-icon"></i> Thông báo hệ thống
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people sidebar-icon"></i> Quản lý người dùng
            </a>
        </li>
        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.job-application.index') }}">
                <i class="bi bi-file-earmark-person sidebar-icon"></i> Quản lý đơn ứng tuyển
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.payment.index') }}">
                <i class="bi bi-credit-card sidebar-icon"></i> Quản lý thanh toán
            </a>
        </li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.reports.index') }}">
                <i class="bi bi-flag sidebar-icon"></i> Nội dung vi phạm
            </a>
        </li>

        <li class="sidebar-main-title">Khác</li>

        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear sidebar-icon"></i> Cài đặt hệ thống
            </a>
        </li>
        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.bank_account.index') }}">
                <i class="bi bi-bank sidebar-icon"></i> Quản lý ngân hàng
            </a>
        </li>
        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.bank_log.index') }}">
                <i class="bi bi-journal-arrow-down sidebar-icon"></i> Lịch sử Nhận tiền
            </a>
        </li>
        <li class="sidebar-list">
            <a class="sidebar-link" href="{{ route('admin.logos.index') }}">
                <i class="bi bi-image sidebar-icon"></i> Logo
            </a>
        </li>


    </ul>
</aside>
