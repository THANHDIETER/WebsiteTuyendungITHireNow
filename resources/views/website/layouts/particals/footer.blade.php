<footer class="footer-area">
    <!--== Start Footer Top ==-->
    <div class="footer-top py-0 text-white" style="background-color: #00A8FF;">
        <div class="container">
            <div class="row align-items-center gy-3">
                <!-- Tiêu đề -->
                <div class="col-lg-5">
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-envelope-paper-heart-fill me-2"></i>Nhận bản tin việc làm mỗi ngày
                    </h4>
                    <p class="text-white fs-5 fw-medium mt-1">Cập nhật cơ hội nghề nghiệp mới nhất từ HireNow</p>
                </div>

                <!-- Form đăng ký -->
                <div class="col-lg-7">
                    <form class="d-flex flex-column flex-md-row gap-2">
                        <input type="email" class="form-control shadow-sm rounded-pill px-4"
                            placeholder="Nhập email của bạn" required>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-send-fill me-1"></i>Đăng ký ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--== End Footer Top ==-->

    <!--== Start Footer Main ==-->
    <div class="footer-main">
        <div class="container pt--0 pb--0">
            <div class="row">
                <!-- About -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item widget-about">
                        <div class="widget-logo-area">
                            <a href="{{ route('home') }}">
                                 @php
                                    $clientLogo = \App\Models\Logo::where('type', 'Footer')
                                        ->where('is_active', true)
                                        ->first();
                                @endphp
                                <img class="logo-main" src="{{ $clientLogo ? asset('storage/' . $clientLogo->image_path) : '' }}"
                                    alt="Logo" />
                            </a>
                        </div>
                        <p class="desc">HireNow - Nền tảng tuyển dụng IT chất lượng tại Việt Nam. Kết nối nhà tuyển dụng
                            với nhân tài công nghệ.</p>
                        <div class="social-icons d-flex gap-2 mb-3">
                            <!-- target="_blank" -->
                            <a href="#" rel="noopener">
                                <img src="https://dvpro.vn/uploads/23-09-2024/provider/d7c36c77-793d-4d4f-84f6-899477c69e7e.gif"
                                    alt="Facebook" style="width: 24px; height: 24px;" lazyload="lazy">
                            </a>
                            <a href="#"  rel="noopener">
                                <img src="https://dvpro.vn/uploads/23-09-2024/provider/0c345f0a-8c8e-44f7-969f-de5829b3c357.gif"
                                    alt="Instagram" style="width: 24px; height: 24px;" lazyload="lazy">
                            </a>
                            <a href="#"  rel="noopener">
                                <img src="https://dvpro.vn/uploads/23-09-2024/provider/5ffb8ca6-dc20-49a2-a419-10c7ee8377bc.gif"
                                    alt="Twitter" style="width: 24px; height: 24px;" lazyload="lazy" >
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Việc Làm -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item nav-menu-item1">
                        <h4 class="widget-title">Việc Làm</h4>
                        <div class="widget-collapse-body show">
                            <div class="widget-menu-wrap">
                                <ul class="nav-menu">
                                    <li><a href="/viec-lam/frontend-developer">Frontend Developer</a></li>
                                    <li><a href="/viec-lam/backend-developer">Backend Developer</a></li>
                                    <li><a href="/viec-lam/fullstack-developer">Fullstack Developer</a></li>
                                    <li><a href="/viec-lam/remote-jobs">Việc làm từ xa</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Điều Khoản -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item nav-menu-item3">
                        <h4 class="widget-title">Điều Khoản</h4>
                        <div class="widget-collapse-body show">
                            <div class="widget-menu-wrap">
                                <ul class="nav-menu">
                                    <li><a href="/dieu-khoan">Điều khoản sử dụng</a></li>
                                    <li><a href="/bao-mat">Chính sách bảo mật</a></li>
                                    <li><a href="/ban-quyen">Bản quyền & sở hữu trí tuệ</a></li>
                                    <li><a href="/quy-che-hoat-dong">Quy chế hoạt động</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liên hệ -->
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item nav-menu-item4">
                        <h4 class="widget-title">Liên Hệ</h4>
                        <div class="widget-collapse-body show">
                            <div class="widget-menu-wrap">
                                <ul class="nav-menu contact-list">
                                    <li><a href="tel:0123456789"><i class="bi bi-telephone-fill me-2"></i>0123 456
                                            789</a></li>
                                    <li><a href="mailto:contact@example.com"><i
                                                class="bi bi-envelope-fill me-2"></i>contact@example.com</a></li>
                                    <li><a href="https://goo.gl/maps/example" target="_blank"><i
                                                class="bi bi-geo-alt-fill me-2"></i>Trịnh Văn Bô, Hà Nội</a></li>
                                    <li><a href="/lien-he"><i class="bi bi-chat-left-text-fill me-2"></i>Gửi biểu mẫu
                                            liên hệ</a></li>
                                    <li><a href="https://www.facebook.com" target="_blank"><i
                                                class="bi bi-facebook me-2"></i>Facebook Fanpage</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Columns -->
            </div>
        </div>
    </div>
    <!--== End Footer Main ==-->

    <!--== Start Footer Bottom ==-->
    <div class="footer-bottom">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content">
                        © {{ date('Y') }} HireNow. Made with <i class="bi bi-heart-fill text-danger"></i> in Vietnam.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Footer Bottom ==-->
</footer>