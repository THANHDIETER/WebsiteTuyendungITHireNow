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
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu khu vực Blog ==-->
        <section class="blog-area blog-grid-area">
            <div class="container">
                <div class="row justify-content-between flex-xl-row-reverse">
                    <div class="col-xl-8">
                        <div class="row row-gutter-70">
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/2.webp" alt="Ảnh bài viết"
                                                width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Tất cả các tính năng tuyệt vời này<br>với giá hợp lý!</a></h4>
                                        <p>Lorem Ipsum chỉ là đoạn văn giả, được sử dụng trong ngành in ấn và dàn trang. Nội dung dùng làm mẫu cho bố cục thiết kế.</p>
                                        <div class="meta">
                                            <span class="post-date">03 Tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--== Các post-item khác dịch nội dung tương tự ==-->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/3.webp" alt="Ảnh bài viết"
                                                width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Thiết kế kéo thả với WooLentor...</a></h4>
                                        <p>Lorem Ipsum chỉ là đoạn văn giả, được sử dụng trong ngành in ấn và dàn trang. Nội dung dùng làm mẫu cho bố cục thiết kế.</p>
                                        <div class="meta">
                                            <span class="post-date">03 Tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Dịch các post-item còn lại theo mẫu trên -->
                            <div class="col-12 text-left">
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
                    <div class="col-xl-4">
                        <div class="blog-sidebar blog-sidebar-left">
                            <div class="widget-item">
                                <div class="widget-body">
                                    <div class="widget-search-box">
                                        <form action="blog.html#" method="post">
                                            <div class="form-input-item">
                                                <input type="search" id="search2" placeholder="Tìm kiếm bài viết...">
                                                <button type="submit" class="btn-src">
                                                    <i class="icofont-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Danh mục</h3>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-categories">
                                        <ul>
                                            <li><a href="job.html">Chuyển nhà văn phòng <span>(16)</span></a></li>
                                            <li><a href="job.html">Dịch vụ vận chuyển hàng không <span>(03)</span></a></li>
                                            <li><a href="job.html">Dịch vụ Drone <span>(08)</span></a></li>
                                            <li><a href="job.html">Vận chuyển đường bộ <span>(18)</span></a></li>
                                            <li><a href="job.html">Kho vận <span>(02)</span></a></li>
                                            <li><a href="job.html">Tư vấn lưu kho <span>(14)</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Bài viết mới</h3>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-post">
                                        <div class="widget-blog-post">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img src="../client/assets/img/blog/s1.webp"
                                                        alt="Ảnh bài viết" width="71" height="70"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Bao gồm vận chuyển nguyên liệu...</a></h4>
                                                <div class="meta">
                                                    <span class="post-date"><i class="icofont-ui-calendar"></i> 10/08/2022</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Các widget-blog-post khác dịch tương tự -->
                                    </div>
                                </div>
                            </div>
                            <div class="widget-item mb-md-0">
                                <div class="widget-title">
                                    <h3 class="title">Từ khóa nổi bật</h3>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-tags">
                                        <ul>
                                            <li><a href="job.html">Động vật</a></li>
                                            <li><a class="tags-padding mr-0" href="job.html">Chim</a></li>
                                            <li><a class="tags-padding" href="job.html">Từ thiện</a></li>
                                            <li><a class="mr-0" href="job.html">Rừng</a></li>
                                            <li><a href="job.html">Nước</a></li>
                                            <li><a class="tags-padding mr-0" href="job.html">Trẻ em</a></li>
                                            <li><a class="tags-padding" href="job.html">Con người</a></li>
                                            <li><a href="job.html">Rừng già</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc khu vực Blog ==-->
    </main>
@endsection
