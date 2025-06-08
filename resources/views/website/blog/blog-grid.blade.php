@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Bài viết Blog</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Bài viết Blog</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header ==-->

        <!--== Bắt đầu khu vực Blog ==-->
        <section class="blog-area blog-grid-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <!--== Bắt đầu Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/2.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời<br>với giá hợp lý!</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== Kết thúc Blog Post Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/3.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Thiết kế kéo-thả với WooLentor...</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/4.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Thiết kế kéo-thả với WooLentor...</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/5.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Giúp cửa hàng của bạn nổi bật<br>so với đối thủ</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/6.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời<br>với giá hợp lý!</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/7.webp" alt="Ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Thiết kế kéo-thả với WooLentor...</a></h4>
                                <p>Lorem Ipsum chỉ là văn bản mẫu được sử dụng trong ngành in ấn và thiết kế. Nội dung này dùng để trình bày bố cục.</p>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            <nav>
                                <ul class="page-numbers d-inline-flex">
                                    <li>
                                        <a class="page-number active" href="blog.html">1</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="blog.html">2</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="blog.html">3</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="blog.html">4</a>
                                    </li>
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
        <!--== Kết thúc khu vực Blog ==-->
    </main>
@endsection
