
@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
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
        <section class="blog-area blog-grid-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/2.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời này<br>đều
                                        có mức giá phải chăng!</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/3.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                        WooLentor<br>để tạo nội dung…</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/4.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                        WooLentor<br>để tạo nội dung…</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/5.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Giúp cửa hàng của bạn nổi bật<br>giữa các
                                        cửa hàng khác bằng cách chuyển đổi</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/6.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời này<br>đều
                                        có mức giá phải chăng!</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/7.webp" alt="Image"
                                        width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                        WooLentor<br>để tạo nội dung…</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản giả dùng trong ngành in ấn và dàn trang, đã được sử dụng từ
                                    rất lâu.</p>
                                <div class="meta">
                                    <span class="post-date">03 tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            <nav>
                                <ul class="page-numbers d-inline-flex">
                                    <li><a class="page-number active" href="blog.html">1</a></li>
                                    <li><a class="page-number" href="blog.html">2</a></li>
                                    <li><a class="page-number" href="blog.html">3</a></li>
                                    <li><a class="page-number" href="blog.html">4</a></li>
                                    <li>
                                        <a class="page-number next" href="blog.html">
                                            <i class="icofont-long-arrow-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--== End Blog Area Wrapper ==-->
    </main>
@endsection
