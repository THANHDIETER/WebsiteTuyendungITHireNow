@extends('website.layouts.master')

@section('content')
    <main class="main-content">
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

        <!--== Start Employers Details Area Wrapper ==-->
        <section class="employers-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="employers-details-wrap">
                            <div class="employers-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/companies/11.webp" width="130" height="130"
                                        alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Mukianso IT Sulution Ltd.</h4>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Hoa Kỳ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                    <button type="button" class="btn-theme">Theo dõi</button>
                                    <button type="button" class="btn-theme btn-white">Thêm đánh giá</button>
                                </div>
                            </div>

                            <div class="employers-counter">
                                <div class="counter-item">
                                    <h4 class="counter">86</h4>
                                    <h5 class="title">Tổng số công việc</h5>
                                </div>
                                <div class="counter-item">
                                    <h4 class="counter">27</h4>
                                    <h5 class="title">Lượt đánh giá</h5>
                                </div>
                                <div class="counter-item">
                                    <h4 class="counter">452</h4>
                                    <h5 class="title">Lượt xem</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="employers-details-item">
                            <div class="content">
                                <h4 class="title">Giới thiệu</h4>
                                <p class="desc">
                                    Theo một thực tế lâu đời rằng người đọc sẽ bị phân tâm bởi nội dung trang khi nhìn vào
                                    bố cục. Lorem Ipsum được sử dụng vì có phân bố chữ cái gần giống với văn bản thật, thay
                                    vì chỉ sử dụng các gói xuất bản nội dung hoặc trình chỉnh sửa trang web.
                                </p>
                                <p class="desc">
                                    Nội dung này chỉ mang tính minh họa cho thiết kế giao diện; bạn có thể thay thế bằng
                                    thông tin thực tế.
                                </p>
                                <ul class="employers-details-list">
                                    <li><i class="icofont-check"></i> Phát triển theme tùy chỉnh (theo tiêu chuẩn
                                        WordPress.org & ThemeForest)</li>
                                    <li><i class="icofont-check"></i> Thiết kế website responsive</li>
                                    <li><i class="icofont-check"></i> Làm việc theo tiến độ nghiêm ngặt</li>
                                    <li><i class="icofont-check"></i> Phát triển theme tối ưu tốc độ tải trang</li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="content mb--0 pb-2">
                                        <h4 class="title">Vị trí tuyển dụng</h4>
                                    </div>
                                </div>

                                <!-- Recent Job Item 1 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w1.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content mb--0">
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
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Job Item 2 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w2.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content mb--0">
                                                <h4 class="name"><a href="company-details.html">Inspire Fitness Co.</a>
                                                </h4>
                                                <p class="address">New York, Hoa Kỳ</p>
                                            </div>
                                        </div>
                                        <div class="main-content">
                                            <h3 class="title"><a href="job-details.html">Chuyên viên Thiết kế UI cao
                                                    cấp</a></h3>
                                            <h5 class="work-type">Bán thời gian</h5>
                                            <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                        </div>
                                        <div class="recent-job-info">
                                            <div class="salary">
                                                <h4>$5000</h4>
                                                <p>/tháng</p>
                                            </div>
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Job Item 3 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w4.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h4 class="name"><a href="company-details.html">Obelus Concepts</a></h4>
                                                <p class="address">New York, Hoa Kỳ</p>
                                            </div>
                                        </div>
                                        <div class="main-content">
                                            <h3 class="title"><a href="job-details.html">Chuyên viên Nghiên cứu UX</a>
                                            </h3>
                                            <h5 class="work-type">Toàn thời gian</h5>
                                            <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                        </div>
                                        <div class="recent-job-info">
                                            <div class="salary">
                                                <h4>$5000</h4>
                                                <p>/tháng</p>
                                            </div>
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Job Item 4 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w5.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h4 class="name"><a href="company-details.html">Sanguine Skincare</a>
                                                </h4>
                                                <p class="address">New York, Hoa Kỳ</p>
                                            </div>
                                        </div>
                                        <div class="main-content">
                                            <h3 class="title"><a href="job-details.html">Lập trình viên Android</a></h3>
                                            <h5 class="work-type">Làm việc từ xa</h5>
                                            <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                        </div>
                                        <div class="recent-job-info">
                                            <div class="salary">
                                                <h4>$5000</h4>
                                                <p>/tháng</p>
                                            </div>
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Job Item 5 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w7.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h4 class="name"><a href="company-details.html">Darkento Ltd.</a></h4>
                                                <p class="address">New York, Hoa Kỳ</p>
                                            </div>
                                        </div>
                                        <div class="main-content">
                                            <h3 class="title"><a href="job-details.html">Lập trình viên Front-end</a>
                                            </h3>
                                            <h5 class="work-type">Toàn thời gian</h5>
                                            <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                        </div>
                                        <div class="recent-job-info">
                                            <div class="salary">
                                                <h4>$5000</h4>
                                                <p>/tháng</p>
                                            </div>
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Job Item 6 -->
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="company-details.html">
                                                    <img src="../client/assets/img/companies/w8.webp" width="75"
                                                        height="75" alt="Logo công ty">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h4 class="name"><a href="company-details.html">Inspire Fitness Co.</a>
                                                </h4>
                                                <p class="address">New York, Hoa Kỳ</p>
                                            </div>
                                        </div>
                                        <div class="main-content">
                                            <h3 class="title"><a href="job-details.html">Chuyên viên Thiết kế UI cao
                                                    cấp</a></h3>
                                            <h5 class="work-type">Bán thời gian</h5>
                                            <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                        </div>
                                        <div class="recent-job-info">
                                            <div class="salary">
                                                <h4>$5000</h4>
                                                <p>/tháng</p>
                                            </div>
                                            <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.row -->
                        </div>
                    </div><!-- /.col -->

                    <div class="col-lg-5 col-xl-4">
                        <div class="employers-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Thông tin</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Danh mục</td>
                                                <td class="dotted">:</td>
                                                <td>Thiết kế & Phần mềm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Thành lập</td>
                                                <td class="dotted">:</td>
                                                <td>1996</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Lượt xem</td>
                                                <td class="dotted">:</td>
                                                <td>568+</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Đánh giá</td>
                                                <td class="dotted">:</td>
                                                <td>(4.8) <span class="rating"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Tổng số công việc</td>
                                                <td class="dotted">:</td>
                                                <td>87+</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Địa điểm</td>
                                                <td class="dotted">:</td>
                                                <td>New York, Hoa Kỳ</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Thành viên</td>
                                                <td class="dotted">:</td>
                                                <td>300–500</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Tỷ lệ thành công</td>
                                                <td class="dotted">:</td>
                                                <td>98%</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Điện thoại</td>
                                                <td class="dotted">:</td>
                                                <td>+00 568 467 843</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Email</td>
                                                <td class="dotted">:</td>
                                                <td>yourmail@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Trang web</td>
                                                <td class="dotted">:</td>
                                                <td data-text-color="#ff6000">www.website.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Chia sẻ</h3>
                                </div>
                                <div class="social-icons">
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener"><i
                                            class="icofont-facebook"></i></a>
                                    <a href="https://twitter.com" target="_blank" rel="noopener"><i
                                            class="icofont-twitter"></i></a>
                                    <a href="https://www.skype.com" target="_blank" rel="noopener"><i
                                            class="icofont-skype"></i></a>
                                    <a href="https://www.pinterest.com" target="_blank" rel="noopener"><i
                                            class="icofont-pinterest"></i></a>
                                    <a href="https://dribbble.com/" target="_blank" rel="noopener"><i
                                            class="icofont-dribbble"></i></a>
                                </div>
                            </div>

                            <div class="widget-item widget-contact">
                                <div class="widget-title">
                                    <h3 class="title">Liên hệ ngay</h3>
                                </div>
                                <div class="widget-contact-form">
                                    <form id="contact-form" action="https://whizthemes.com/mail-php/raju/arden/mail.php"
                                        method="POST">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="con_name"
                                                        placeholder="Họ và tên:">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="email" name="con_email"
                                                        placeholder="Email:">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="con_message" placeholder="Tin nhắn"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb--0">
                                                    <button class="btn-theme d-block w-100" type="submit">Gửi tin
                                                        nhắn</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--== Thông báo kết quả ==-->
                                    <div class="form-message"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section>

        <!--== End Employers Details Area Wrapper ==-->
    </main>
@endsection
