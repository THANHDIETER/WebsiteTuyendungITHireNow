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
                            <h2 class="title">Ứng viên</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Ứng viên</li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu khu vực danh sách ứng viên ==-->
        <section class="team-area team-inner2-area">
            <div class="container">
                <div class="row">

                    <!-- Thành viên 1 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">

                                    <img src="../client/assets/img/team/1.webp" width="160" height="160"
                                        alt="HasTech">

                                    <img src="../client/assets/img/team/1.webp" width="160" height="160" alt="Ảnh ứng viên">

                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Lauran Benitez</a></h4>

                                <h5 class="sub-title">Nhà thiết kế Web</h5>

                                <h5 class="sub-title">Thiết kế Web</h5>

                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>

                                <p class="desc">CSS3, HTML5, JavaScript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Bookmark">
                            </div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 2 -->

                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Lưu"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp" alt="Lưu"></div>
                        </div>
                    </div>
                    <!--== Lặp lại các team-item khác, chỉ dịch phần nội dung ==-->

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">

                                    <img src="../client/assets/img/team/2.webp" width="160" height="160"
                                        alt="HasTech">

                                    <img src="../client/assets/img/team/2.webp" width="160" height="160" alt="Ảnh ứng viên">

                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Valentine Anders</a></h4>

                                <h5 class="sub-title">Nhà thiết kế UI/UX</h5>

                                <h5 class="sub-title">Thiết kế UI/UX</h5>

                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>

                                <p class="desc">Bootstrap, CSS3, HTML5, JavaScript, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Bookmark">
                            </div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 3 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/3.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Shakia Aguilera</a></h4>
                                <h5 class="sub-title">Nhà thiết kế Web</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">JavaScript, Bootstrap, jQuery, CSS3, HTML5</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 4 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/4.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Assunta Manson</a></h4>
                                <h5 class="sub-title">Lập trình viên Ứng dụng</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">HTML5, CSS3, jQuery, JavaScript, Bootstrap</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 5 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/5.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">David Silva</a></h4>
                                <h5 class="sub-title">Nhà thiết kế Web</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, JavaScript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 6 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/6.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Jason Holt</a></h4>
                                <h5 class="sub-title">Nhà thiết kế UI/UX</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, JavaScript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 7 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/7.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Elnora Morton</a></h4>
                                <h5 class="sub-title">Lập trình viên Ứng dụng</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, JavaScript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                    <!-- Thành viên 8 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/8.webp" width="160" height="160"
                                        alt="HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Leona Spencer</a></h4>
                                <h5 class="sub-title">Nhà thiết kế UI/UX</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, JavaScript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Bookmark"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Đã đánh dấu"></div>
                        </div>
                    </div>

                </div><!-- /.row -->

                                <p class="desc">Bootstrap, CSS3, HTML5, Javascript, Jquery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Lưu"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp" alt="Lưu"></div>
                        </div>
                    </div>
                    <!-- Các team-item còn lại dịch giống trên -->
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            <nav>
                                <ul class="page-numbers d-inline-flex">
                                    <li><a class="page-number active" href="candidate.html">1</a></li>
                                    <li><a class="page-number" href="candidate.html">2</a></li>
                                    <li><a class="page-number" href="candidate.html">3</a></li>
                                    <li>
                                        <a class="page-number next" href="candidate.html">
                                            <i class="icofont-long-arrow-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div><!-- /.row -->

            </div><!-- /.container -->
        </section>


        <!--== End Team Area Wrapper ==-->

    </main>
@endsection
