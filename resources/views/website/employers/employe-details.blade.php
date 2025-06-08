@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Chi tiết nhà tuyển dụng</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Nhà tuyển dụng</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu khu vực chi tiết nhà tuyển dụng ==-->
        <section class="employers-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="employers-details-wrap">
                            <div class="employers-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/companies/11.webp" width="130" height="130" alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Mukianso IT Solution Ltd.</h4>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Mỹ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                    <button type="button" class="btn-theme">Theo dõi</button>
                                    <button type="button" class="btn-theme btn-white">Đánh giá công ty</button>
                                </div>
                            </div>
                            <div class="employers-counter">
                                <div class="counter-item">
                                    <h4 class="counter">86</h4>
                                    <h5 class="title">Việc làm đã đăng</h5>
                                </div>
                                <div class="counter-item">
                                    <h4 class="counter">27</h4>
                                    <h5 class="title">Đánh giá</h5>
                                </div>
                                <div class="counter-item">
                                    <h4 class="counter">452</h4>
                                    <h5 class="title">Lượt xem</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="employers-details-item">
                            <div class="content">
                                <h4 class="title">Giới thiệu công ty</h4>
                                <p class="desc">
                                    Chúng tôi là doanh nghiệp công nghệ với nhiều năm kinh nghiệm phát triển các giải pháp phần mềm cho khách hàng toàn cầu. Đội ngũ chuyên môn cao, luôn sẵn sàng sáng tạo, đổi mới và hướng đến hiệu quả thực tiễn cho đối tác.
                                </p>
                                <ul class="employers-details-list">
                                    <li><i class="icofont-check"></i> Phát triển theme WordPress chuẩn quốc tế (WordPress.org & ThemeForest).</li>
                                    <li><i class="icofont-check"></i> Thiết kế giao diện website tương tác, hiện đại.</li>
                                    <li><i class="icofont-check"></i> Cam kết tiến độ, làm việc chuyên nghiệp.</li>
                                    <li><i class="icofont-check"></i> Luôn tối ưu hiệu suất website.</li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="content mb--0 pb-2">
                                        <h4 class="title">Vị trí đang tuyển</h4>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="recent-job-item recent-job-style3-item">
                                        <div class="company-info">
                                            <div class="logo">
                                                <a href="#"><img src="../client/assets/img/companies/w1.webp" width="75" height="75" alt="Logo công ty"></a>
                                            </div>
                                            <div class="content mb--0">
                                                <h4 class="name"><a href="#">Darkento Ltd.</a></h4>
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
                                <!-- Các vị trí khác: dịch nội dung tương tự như trên -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="employers-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Thông tin công ty</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Lĩnh vực</td>
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
                                                <td class="table-name">Tổng số việc làm</td>
                                                <td class="dotted">:</td>
                                                <td>87+</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Địa chỉ</td>
                                                <td class="dotted">:</td>
                                                <td>New York, Mỹ</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Thành viên</td>
                                                <td class="dotted">:</td>
                                                <td>300-500</td>
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
                                                <td class="table-name">Website</td>
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
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener"><i class="icofont-facebook"></i></a>
                                    <a href="https://twitter.com" target="_blank" rel="noopener"><i class="icofont-twitter"></i></a>
                                    <a href="https://www.skype.com" target="_blank" rel="noopener"><i class="icofont-skype"></i></a>
                                    <a href="https://www.pinterest.com" target="_blank" rel="noopener"><i class="icofont-pinterest"></i></a>
                                    <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="icofont-dribbble"></i></a>
                                </div>
                            </div>
                            <div class="widget-item widget-contact">
                                <div class="widget-title">
                                    <h3 class="title">Liên hệ ngay</h3>
                                </div>
                                <div class="widget-contact-form">
                                    <form id="contact-form" action="https://whizthemes.com/mail-php/raju/arden/mail.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="con_name" placeholder="Họ và tên:">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="email" name="con_email" placeholder="Email:">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="con_message" placeholder="Nội dung"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb--0">
                                                    <button class="btn-theme d-block w-100" type="submit">Gửi liên hệ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--== Thông báo gửi liên hệ ==-->
                                    <div class="form-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc khu vực chi tiết nhà tuyển dụng ==-->
    </main>
@endsection
