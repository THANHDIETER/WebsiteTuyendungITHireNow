



@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
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
                            <!-- Bài viết 1 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">

                                        <a href="blog-details.html"><img src="../client/assets/img/blog/2.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời
                                                này<br>đều có mức giá phải chăng!</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>

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

                            <!-- Bài viết 2 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/3.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                                WooLentor<br>để tạo nội dung...</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>

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
                            <!-- Bài viết 3 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/4.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                                WooLentor<br>để tạo nội dung...</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bài viết 4 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/5.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Giúp cửa hàng của bạn nổi
                                                bật<br>trong số những cửa hàng khác bằng cách chuyển đổi</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bài viết 5 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/6.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Tất cả những tính năng tuyệt vời
                                                này<br>đều có mức giá phải chăng!</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bài viết 6 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/7.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                                WooLentor<br>để tạo nội dung...</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bài viết 7 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/8.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Với giao diện kéo &amp; thả của
                                                WooLentor<br>để tạo nội dung...</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bài viết 8 -->
                            <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="post-item">
                                    <div class="thumb">
                                        <a href="blog-details.html"><img src="../client/assets/img/blog/9.webp"
                                                alt="Hình ảnh" width="370" height="270"></a>
                                    </div>
                                    <div class="content">
                                        <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                        <h4 class="title"><a href="blog-details.html">Giúp cửa hàng của bạn nổi
                                                bật<br>trong số những cửa hàng khác bằng cách chuyển đổi</a></h4>
                                        <p>Lorem Ipsum đơn giản là văn bản giả &amp; chủ đề in ấn; đã được ngành in sử dụng
                                            từ lâu và được chèn vào bố cục trang.</p>
                                        <div class="meta">
                                            <span class="post-date">03 tháng 4, 2022</span>
                                            <span class="dots"></span>
                                            <span class="post-time">10 phút đọc</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Phân trang -->

                            </div>
                            <!-- Dịch các post-item còn lại theo mẫu trên -->

                            <div class="col-12 text-left">
                                <div class="pagination-area">
                                    <nav>
                                        <ul class="page-numbers d-inline-flex">
                                            <li><a class="page-number active" href="blog.html">1</a></li>
                                            <li><a class="page-number" href="blog.html">2</a></li>
                                            <li><a class="page-number" href="blog.html">3</a></li>
                                            <li><a class="page-number" href="blog.html">4</a></li>
                                            <li><a class="page-number next" href="blog.html"><i
                                                        class="icofont-long-arrow-right"></i></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="blog-sidebar blog-sidebar-left">
                            <!-- Tìm kiếm -->
                            <div class="widget-item">
                                <div class="widget-body">
                                    <div class="widget-search-box">
                                        <form action="blog.html#" method="post">
                                            <div class="form-input-item">

                                                <input type="search" id="search2" placeholder="Tìm kiếm">
                                                <button type="submit" class="btn-src"><i
                                                        class="icofont-search"></i></button>

                                                <input type="search" id="search2" placeholder="Tìm kiếm bài viết...">
                                                <button type="submit" class="btn-src">
                                                    <i class="icofont-search"></i>
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Danh mục bài viết -->
                            <div class="widget-item">
                                <div class="widget-title">

                                    <h3 class="title">Danh mục bài viết</h3>

                                    <h3 class="title">Danh mục</h3>

                                </div>
                                <div class="widget-body">
                                    <div class="widget-categories">
                                        <ul>

                                            <li><a href="job.html">Chuyển hàng thương mại<span>(16)</span></a></li>
                                            <li><a href="job.html">Dịch vụ vận tải hàng không<span>(03)</span></a></li>
                                            <li><a href="job.html">Dịch vụ Drone<span>(08)</span></a></li>
                                            <li><a href="job.html">Vận tải đường bộ<span>(18)</span></a></li>
                                            <li><a href="job.html">Kho bãi<span>(02)</span></a></li>
                                            <li><a href="job.html">Tư vấn lưu trữ<span>(14)</span></a></li>

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
                            <!-- Bài viết mới -->
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Bài viết mới</h3>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-post">
                                        <div class="widget-blog-post d-flex mb-3">
                                            <div class="thumb me-2">
                                                <a href="blog-details.html"><img src="../client/assets/img/blog/s1.webp"

                                                        alt="Hình ảnh" width="71" height="70"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Đây bao gồm việc vận chuyển nguyên liệu
                                                        thô.</a></h4>
                                                <div class="meta"><span class="post-date"><i
                                                            class="icofont-ui-calendar"></i> 10 tháng 8, 2022</span></div>
                                            </div>
                                        </div>
                                        <div class="widget-blog-post d-flex mb-3">
                                            <div class="thumb me-2">
                                                <a href="blog-details.html"><img src="../client/assets/img/blog/s2.webp"
                                                        alt="Hình ảnh" width="71" height="70"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Tất cả những tính năng tuyệt vời này đi kèm
                                                        mức giá.</a></h4>
                                                <div class="meta"><span class="post-date"><i
                                                            class="icofont-ui-calendar"></i> 18 tháng 8, 2022</span></div>
                                            </div>
                                        </div>
                                        <div class="widget-blog-post d-flex mb-3">
                                            <div class="thumb me-2">
                                                <a href="blog-details.html"><img src="../client/assets/img/blog/s3.webp"
                                                        alt="Hình ảnh" width="71" height="70"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Đây bao gồm việc vận chuyển nguyên liệu
                                                        thô.</a></h4>
                                                <div class="meta"><span class="post-date"><i
                                                            class="icofont-ui-calendar"></i> 19 tháng 8, 2022</span></div>
                                            </div>
                                        </div>
                                        <div class="widget-blog-post d-flex">
                                            <div class="thumb me-2">
                                                <a href="blog-details.html"><img src="../client/assets/img/blog/s4.webp"
                                                        alt="Hình ảnh" width="71" height="70"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Tất cả những tính năng tuyệt vời này đi kèm
                                                        mức giá.</a></h4>
                                                <div class="meta"><span class="post-date"><i
                                                            class="icofont-ui-calendar"></i> 10 tháng 8, 2022</span></div>

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
                            <!-- Thẻ phổ biến -->
                            <div class="widget-item mb-md-0">
                                <div class="widget-title">

                                    <h3 class="title">Thẻ phổ biến</h3>

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

                                            <li><a href="job.html">Nhiệt đới</a></li>

                                            <li><a href="job.html">Rừng già</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.widget-item -->
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--== End Blog Area Wrapper ==-->

        <!--== Kết thúc khu vực Blog ==-->

    </main>
@endsection
