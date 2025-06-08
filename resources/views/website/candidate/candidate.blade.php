@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
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
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/1.webp" width="160" height="160" alt="Ảnh ứng viên">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Lauran Benitez</a></h4>
                                <h5 class="sub-title">Thiết kế Web</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
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
                                    <img src="../client/assets/img/team/2.webp" width="160" height="160" alt="Ảnh ứng viên">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Valentine Anders</a></h4>
                                <h5 class="sub-title">Thiết kế UI/UX</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
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
                                    <li>
                                        <a class="page-number active" href="candidate.html">1</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="candidate.html">2</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="candidate.html">3</a>
                                    </li>
                                    <li>
                                        <a class="page-number next" href="candidate.html">
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
        <!--== Kết thúc khu vực danh sách ứng viên ==-->
    </main>
@endsection
