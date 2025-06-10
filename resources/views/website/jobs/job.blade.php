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
                    {{-- Job 1 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">

                                    <a href="company-details.html"><img src="../client/assets/img/companies/w1.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Darkento Ltd.</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>

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

                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 2 --}}

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

                                    <a href="company-details.html"><img src="../client/assets/img/companies/w2.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Inspire Fitness Co.</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Chuyên viên Thiết kế UI cao cấp</a></h3>
                                <h5 class="work-type">Bán thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 3 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w3.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Cogent Data</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Nhà thiết kế đồ họa</a></h3>
                                <h5 class="work-type">Làm việc từ xa</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 4 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w4.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Obelus Concepts</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Chuyên viên Nghiên cứu UX</a></h3>
                                <h5 class="work-type">Toàn thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 5 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w5.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Sanguine Skincare</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Lập trình viên Ứng dụng Android</a></h3>
                                <h5 class="work-type">Làm việc từ xa</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 6 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w6.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Flux Water Gear</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Nhà thiết kế sản phẩm</a></h3>
                                <h5 class="work-type">Toàn thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 7 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w7.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Darkento Ltd.</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Lập trình viên Front-end</a></h3>
                                <h5 class="work-type">Toàn thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 8 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w8.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Inspire Fitness Co.</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Chuyên viên Thiết kế UI cao cấp</a></h3>
                                <h5 class="work-type">Bán thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>
                    </div>
                    {{-- Job 9 --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="company-details.html"><img src="../client/assets/img/companies/w9.webp"
                                            width="75" height="75" alt="Logo Công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="company-details.html">Cogent Data</a></h4>
                                    <p class="address">New York, Hoa Kỳ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Nhà thiết kế đồ họa</a></h3>
                                <h5 class="work-type">Bán thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>$5000</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển</a>
                            </div>
                        </div>

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
                                    <li><a class="page-number active" href="job.html">1</a></li>
                                    <li><a class="page-number" href="job.html">2</a></li>
                                    <li><a class="page-number" href="job.html">3</a></li>
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
