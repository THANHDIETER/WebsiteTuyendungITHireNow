<aside class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h1 class="d-none" id="offcanvasExampleLabel">Menu bên</h1>
        <button class="btn btn-link text-decoration-none d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Đóng menu">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Đóng menu
        </button>
    </div>
    <div class="offcanvas-body">
        <!-- Menu di động -->
        <div class="mobile-menu-items">
            <ul class="nav-menu list-unstyled">
                <li><a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Trang chủ</a></li>

                <li>
                    <a href="{{ route('cong-viec') }}"><i class="bi bi-search me-2"></i>Tìm việc</a>
                    <ul class="sub-menu list-unstyled ms-3">
                        <li><a href="{{ route('cong-viec') }}"><i class="bi bi-list-ul me-2"></i>Danh sách việc làm</a></li>
                        <li><a href="{{ route('chi-tiet-cong-viec') }}"><i class="bi bi-file-earmark-text me-2"></i>Chi tiết việc làm</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('chi-tiet-nhan-vien') }}"><i class="bi bi-building me-2"></i>Chi tiết nhà tuyển dụng</a></li>

                <li>
                    <a href="{{ route('ung-vien') }}"><i class="bi bi-person-lines-fill me-2"></i>Ứng viên</a>
                    <ul class="sub-menu list-unstyled ms-3">
                        <li><a href="{{ route('ung-vien') }}"><i class="bi bi-people me-2"></i>Danh sách ứng viên</a></li>
                        <li><a href="{{ route('chi-tiet-ung-vien') }}"><i class="bi bi-person-vcard me-2"></i>Chi tiết ứng viên</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('blog') }}"><i class="bi bi-newspaper me-2"></i>Tin tức</a>
                    <ul class="sub-menu list-unstyled ms-3">
                        <li><a href="{{ route('blog') }}"><i class="bi bi-grid-3x3-gap me-2"></i>Lưới tin tức</a></li>
                        <li><a href="{{ route('blog-grid') }}"><i class="bi bi-layout-sidebar me-2"></i>Blog (sidebar trái)</a></li>
                        <li><a href="{{ route('blog-right-sidebar') }}"><i class="bi bi-layout-sidebar-reverse me-2"></i>Blog (sidebar phải)</a></li>
                        <li><a href="{{ route('blog-details', ['id' => $id ?? null]) }}"><i class="bi bi-file-text me-2"></i>Chi tiết bài viết</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="bi bi-layers me-2"></i>Trang khác</a>
                    <ul class="sub-menu list-unstyled ms-3">
                        <li><a href="{{ route('about-us') }}"><i class="bi bi-info-circle me-2"></i>Giới thiệu</a></li>
                        <li><a href="{{ route('404') }}"><i class="bi bi-exclamation-triangle me-2"></i>Không tìm thấy trang</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('contact') }}"><i class="bi bi-telephone me-2"></i>Liên hệ</a></li>
            </ul>
        </div>
    </div>
</aside>
