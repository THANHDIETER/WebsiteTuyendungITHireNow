


<aside class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h1 class="d-none" id="offcanvasExampleLabel">Menu bên</h1>
        <button class="btn-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">đóng menu <i
                class="icofont-simple-left"></i></button>
    </div>
    <div class="offcanvas-body">
        <!-- Bắt đầu menu di động -->
        <div class="mobile-menu-items">
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>

                <li><a href="{{ route('cong-viec') }}">Tìm việc</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('cong-viec') }}">Danh sách việc làm</a></li>

                        <li><a href="{{ route('chi-tiet-cong-viec') }}">Chi tiết việc làm</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('chi-tiet-nhan-vien') }}">Chi tiết nhà tuyển dụng</a></li>
                <li><a href="{{ route('ung-vien') }}">Ứng viên</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('ung-vien') }}">Danh sách ứng viên</a></li>
                        <li><a href="{{ route('chi-tiet-ung-vien') }}">Chi tiết ứng viên</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('blog') }}">Tin tức</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('blog') }}">Lưới tin tức</a></li>
                        <li><a href="{{ route('blog-grid') }}">Blog (sidebar trái)</a></li>
                        <li><a href="{{ route('blog-right-sidebar') }}">Blog (sidebar phải)</a></li>
                        <li><a href="{{ route('blog-details', ['id' =>$id ?? null ]) }}">Chi tiết bài viết</a></li>
                    </ul>
                </li>
                <li><a href="index.html#">Trang khác</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('about-us') }}">Giới thiệu</a></li>
                        <li><a href="{{ route('404') }}">Không tìm thấy trang</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('contact') }}">Liên hệ</a></li>
            </ul>
        </div>
        <!-- Kết thúc menu di động -->
    </div>
</aside>
