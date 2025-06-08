@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Việc làm</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Việc làm</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area recent-job-inner-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="https://htmldemo.net/finate/finate/company-details.html">
                                        <img src="../client/assets/img/companies/w1.webp" width="75" height="75" alt="Logo công ty">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="https://htmldemo.net/finate/finate/company-details.html">Darkento Ltd.</a></h4>
                                    <p class="address">New York, Mỹ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Lập trình viên Front-end</a></h3>
                                <h5 class="work-type">Toàn thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>50.000.000đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                    <!--== Lặp lại các job-item khác tương tự, chỉ dịch phần nội dung ==-->
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="#"><img src="../client/assets/img/companies/w2.webp" width="75" height="75" alt="Logo công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="#">Inspire Fitness Co.</a></h4>
                                    <p class="address">New York, Mỹ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">UI Designer Senior</a></h3>
                                <h5 class="work-type" data-text-color="#ff7e00">Bán thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>30.000.000đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                    <!-- Các job khác dịch như trên... -->
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            <nav>
                                <ul class="page-numbers d-inline-flex">
                                    <li>
                                        <a class="page-number active" href="job.html">1</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="job.html">2</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="job.html">3</a>
                                    </li>
                                    <li>
                                        <a class="page-number next" href="job.html">
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
        <!--== Kết thúc danh sách việc làm ==-->
    </main>
@endsection
