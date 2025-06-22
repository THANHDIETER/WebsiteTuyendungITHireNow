@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/banner/15.png">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="job-search-wrap">
                                <div class="job-search-form">
                                    <form action="index.html#">
                                        <div class="row row-gutter-10">
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Tiêu đề việc làm hoặc từ khóa">
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="1" selected>Chọn Thành Phố</option>
                                                        <option value="2">Hà Nội</option>
                                                        <option value="3">Hồ Chí Minh</option>
                                                        <option value="4">Đà Nẵng</option>
                                                        <option value="5">Huế</option>
                                                        <option value="6">Hà Nam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="1" selected>Loại Công Việc</option>
                                                        <option value="2">Web Designer</option>
                                                        <option value="3">Web Developer</option>
                                                        <option value="4">Graphic Designer</option>
                                                        <option value="5">App Developer</option>
                                                        <option value="6">UI &amp; UX Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn-form-search"><i
                                                            class="icofont-search-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Blog Area Wrapper ==-->
        <section class="blog-details-area">
            <div class="post-details-item">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="post-details-info text-center">
                                <div class="meta">
                                    <span class="author">Bởi <a href="blog.html">Harold Leonard</a></span>
                                    <span class="dots"></span>
                                    <span class="post-date">03 tháng 4, 2021</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                                <h4 class="title">
                                    Cấu trúc giá đơn giản giúp bạn linh hoạt trong việc phát triển doanh nghiệp một cách
                                    hiệu quả.
                                </h4>
                                <div class="widget-tags">
                                    <ul>
                                        <li><a href="blog.html">Cơ quan</a></li>
                                        <li><a class="active" href="blog.html">Tuần hoàn</a></li>
                                        <li><a href="blog.html">Kinh doanh</a></li>
                                        <li><a href="blog.html">Doanh nghiệp</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-details-thumb">
                                <img class="w-100" src="../client/assets/img/blog/details1.webp" alt="Hình ảnh"
                                    width="1170" height="550">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="post-details-content">
                                <h4 class="desc-title">
                                    Giải pháp công nghệ bảng việc làm cho những ai muốn thiết lập và vận hành bảng việc làm
                                    của riêng mình, cũng như những ai đã có bảng việc làm.
                                </h4>
                                <p>
                                    Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    thế kỷ 16 khi một nhà in vô danh trộn văn bản mẫu để tạo cuốn mẫu chữ.
                                </p>
                                <p>
                                    Lorem Ipsum đơn giản là văn bản giả và đã trở thành tiêu chuẩn ngành in ấn kể từ khi các
                                    tấm Letraset chứa đoạn Lorem Ipsum được phát hành vào những năm 1960.
                                </p>

                                <div class="post-details-content-list">
                                    <h4 class="title">Mục lục:</h4>
                                    <ul class="list-style">
                                        <li>
                                            <a href="blog-details.html"><i class="icofont-double-right"></i>Nó đã trở nên
                                                phổ biến vào những năm 1960 với việc phát hành các tấm Letraset chứa đoạn
                                                Lorem Ipsum</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html"><i class="icofont-double-right"></i>Nhiều gói xuất
                                                bản bản in và trình chỉnh sửa trang web hiện nay sử dụng Lorem Ipsum</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html"><i class="icofont-double-right"></i>Nó đã trở nên
                                                phổ biến vào những năm 1960 với việc phát hành các tấm Letraset chứa đoạn
                                                Lorem Ipsum</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html"><i class="icofont-double-right"></i>Nhiều gói xuất
                                                bản bản in và trình chỉnh sửa trang web hiện nay sử dụng Lorem Ipsum</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html"><i class="icofont-double-right"></i>Nó đã trở nên
                                                phổ biến vào những năm 1960 với việc phát hành các tấm Letraset chứa đoạn
                                                Lorem Ipsum</a>
                                        </li>
                                    </ul>
                                </div>

                                <p>
                                    Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    thế kỷ 16 khi một nhà in vô danh trộn văn bản mẫu để tạo cuốn mẫu chữ.
                                </p>
                                <h4 class="desc-title2">
                                    Công ty chúng tôi đã gặp thất bại trong thử nghiệm thực tế theo nhiều cách.
                                </h4>
                                <p>
                                    Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    thế kỷ 16 khi một nhà in vô danh trộn văn bản mẫu để tạo cuốn mẫu chữ.
                                </p>
                                <p>
                                    Lorem Ipsum đơn giản là văn bản giả và đã trở thành tiêu chuẩn ngành in ấn kể từ khi các
                                    tấm Letraset chứa đoạn Lorem Ipsum được phát hành vào những năm 1960.
                                </p>

                                <div class="content-thumb">
                                    <img class="w-100" src="../client/assets/img/blog/details2.webp" alt="Hình ảnh"
                                        width="970" height="450">
                                </div>

                                <h4 class="desc-title3">
                                    Thật vậy, đó không phải là điều bất thường duy nhất mà 37Signals đã làm trên con đường
                                    thăng tiến.
                                </h4>
                                <p>
                                    Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    thế kỷ 16 khi một nhà in vô danh trộn văn bản mẫu để tạo cuốn mẫu chữ.
                                </p>
                                <p>
                                    Lorem Ipsum đơn giản là văn bản giả và đã trở thành tiêu chuẩn ngành in ấn kể từ khi các
                                    tấm Letraset chứa đoạn Lorem Ipsum được phát hành vào những năm 1960.
                                </p>

                                <blockquote class="blockquote-item">
                                    <div class="content">
                                        <p>2,83k người nhận bản tin hàng tuần liên quan đến WordPress của chúng tôi.</p>
                                    </div>
                                </blockquote>

                                <p>
                                    Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    thế kỷ 16 khi một nhà in vô danh trộn văn bản mẫu để tạo cuốn mẫu chữ. Nó đã tồn tại hơn
                                    năm thế kỷ và vẫn được giữ nguyên khi chuyển sang dạng gõ điện tử.
                                </p>

                                <div class="post-details-footer">
                                    <div class="widget-social-icons">
                                        <span>Chia sẻ bài viết này:</span>
                                        <div class="social-icons">
                                            <a href="https://www.facebook.com" target="_blank" rel="noopener"><i
                                                    class="icofont-facebook"></i></a>
                                            <a href="https://www.skype.com" target="_blank" rel="noopener"><i
                                                    class="icofont-skype"></i></a>
                                            <a href="https://twitter.com" target="_blank" rel="noopener"><i
                                                    class="icofont-twitter"></i></a>
                                            <a href="https://www.linkedin.com/signup" target="_blank" rel="noopener"><i
                                                    class="icofont-linkedin"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="related-posts-area related-post-area bg-color-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="post-title-wrap">
                                <h4 class="title">Bạn cũng có thể quan tâm</h4>
                                <div class="swiper-btn-wrap">
                                    <div class="related-post-swiper-btn-prev"><i class="icofont-long-arrow-left"></i>
                                    </div>
                                    <div class="related-post-swiper-btn-next"><i class="icofont-long-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="related-posts">
                                <div class="swiper related-post-slider-container">
                                    <div class="swiper-wrapper related-post-slider">
                                        <!-- Slide 1 -->
                                        <div class="swiper-slide">
                                            <div class="post-item2">
                                                <div class="thumb">
                                                    <a href="blog-details.html"><img
                                                            src="../client/assets/img/blog/10.webp" alt="Hình ảnh"
                                                            width="350" height="270"></a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="author">Bởi <a href="blog.html">Walter Houston</a></h5>
                                                    <h4 class="title"><a href="blog-details.html">Tại sao phúc lợi động
                                                            vật hoang dã cùng với động vật chăn nuôi…</a></h4>
                                                    <div class="meta">
                                                        <span class="post-date">03 tháng 4, 2022</span>
                                                        <span class="dots"></span>
                                                        <span class="post-time">10 phút đọc</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Slide 2 -->
                                        <div class="swiper-slide">
                                            <div class="post-item2">
                                                <div class="thumb">
                                                    <a href="blog-details.html"><img
                                                            src="../client/assets/img/blog/11.webp" alt="Hình ảnh"
                                                            width="350" height="270"></a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="author">Bởi <a href="blog.html">Walter Houston</a></h5>
                                                    <h4 class="title"><a href="blog-details.html">Các tổ chức và nhà vận
                                                            động cá nhân trên toàn cầu…</a></h4>
                                                    <div class="meta">
                                                        <span class="post-date">03 tháng 4, 2022</span>
                                                        <span class="dots"></span>
                                                        <span class="post-time">10 phút đọc</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Slide 3 -->
                                        <div class="swiper-slide">
                                            <div class="post-item2">
                                                <div class="thumb">
                                                    <a href="blog-details.html"><img
                                                            src="../client/assets/img/blog/12.webp" alt="Hình ảnh"
                                                            width="350" height="270"></a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="author">Bởi <a href="blog.html">Walter Houston</a></h5>
                                                    <h4 class="title"><a href="blog-details.html">Hiện tại chúng tôi
                                                            không thể có cái nhìn đầy đủ.</a></h4>
                                                    <div class="meta">
                                                        <span class="post-date">03 tháng 4, 2022</span>
                                                        <span class="dots"></span>
                                                        <span class="post-time">10 phút đọc</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Slide 4 -->
                                        <div class="swiper-slide">
                                            <div class="post-item2">
                                                <div class="thumb">
                                                    <a href="blog-details.html"><img
                                                            src="../client/assets/img/blog/3.webp" alt="Hình ảnh"
                                                            width="350" height="270"></a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="author">Bởi <a href="blog.html">Walter Houston</a></h5>
                                                    <h4 class="title"><a href="blog-details.html">Tại sao phúc lợi động
                                                            vật hoang dã cùng với động vật chăn nuôi…</a></h4>
                                                    <div class="meta">
                                                        <span class="post-date">03 tháng 4, 2022</span>
                                                        <span class="dots"></span>
                                                        <span class="post-time">10 phút đọc</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comment-area">
                <div class="container pt--0 pb--0">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="comment-view-area">
                                <h2 class="main-title">Bình luận (03)</h2>
                                <div class="comment-content">
                                    <div class="single-comment">
                                        <div class="author-info d-flex">
                                            <div class="thumb me-3"><img src="../client/assets/img/blog/a1.webp"
                                                    alt="Hình ảnh" width="72" height="72"></div>
                                            <div class="author-details">
                                                <h4 class="title">Sara Alexander</h4>
                                                <ul>
                                                    <li>Nhà thiết kế sản phẩm, Hoa Kỳ || <span>35 phút trước</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="desc">Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn
                                            trang, đã được sử dụng từ rất lâu.</p>
                                        <a class="btn-reply" href="#"><i class="icofont-reply"></i>Trả lời</a>
                                    </div>
                                    <div class="single-comment comment-reply">
                                        <div class="author-info d-flex">
                                            <div class="thumb me-3"><img src="../client/assets/img/blog/a2.webp"
                                                    alt="Hình ảnh" width="72" height="72"></div>
                                            <div class="author-details">
                                                <h4 class="title">Robert Morgan</h4>
                                                <ul>
                                                    <li>Nhà thiết kế sản phẩm, Hoa Kỳ || <span>35 phút trước</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="desc">Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn
                                            trang, đã được sử dụng từ rất lâu.</p>
                                        <a class="btn-reply" href="#"><i class="icofont-reply"></i>Trả lời</a>
                                    </div>
                                    <div class="single-comment comment-reply mb--0">
                                        <div class="author-info d-flex">
                                            <div class="thumb me-3"><img src="../client/assets/img/blog/a3.webp"
                                                    alt="Hình ảnh" width="72" height="72"></div>
                                            <div class="author-details">
                                                <h4 class="title">Rochelle Hunt</h4>
                                                <ul>
                                                    <li>Nhà thiết kế sản phẩm, Hoa Kỳ || <span>35 phút trước</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="desc">Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn
                                            trang, đã được sử dụng từ rất lâu.</p>
                                        <a class="btn-reply" href="#"><i class="icofont-reply"></i>Trả lời</a>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-form-wrap">
                                <h2 class="main-title">Để lại bình luận</h2>
                                <form class="comment-form" action="#">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><input class="form-control" type="text"
                                                    placeholder="Họ và tên"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><input class="form-control" type="email"
                                                    placeholder="Email"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" placeholder="Tin nhắn"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group text-center mb--0"><button class="btn btn-theme"
                                                    type="submit">Gửi ngay <i
                                                        class="icofont-long-arrow-right"></i></button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--== End Blog Area Wrapper ==-->
    </main>
@endsection
