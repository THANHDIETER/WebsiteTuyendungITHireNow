@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Chi tiết ứng viên</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Chi tiết ứng viên</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu khu vực chi tiết ứng viên ==-->
        <section class="team-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="team-details-wrap">
                            <div class="team-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/team/details1.webp" width="130" height="130" alt="Ảnh ứng viên">
                                </div>
                                <div class="content">
                                    <h4 class="title">Frida Marchand</h4>
                                    <h5 class="sub-title">Lập trình viên Web</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Mỹ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="team-details-btn">
                                <button type="button" class="btn-theme btn-light">Thêm vào danh sách lọc</button>
                                <button type="button" class="btn-theme">Tải CV</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="team-details-item">
                            <div class="content">
                                <h4 class="title">Giới thiệu ứng viên</h4>
                                <p class="desc">Ứng viên có nhiều năm kinh nghiệm trong lĩnh vực phát triển web, tư duy logic tốt, sáng tạo trong thiết kế và luôn cầu tiến trong công việc. Tinh thần làm việc nhóm, trách nhiệm cao và khả năng thích nghi nhanh với môi trường mới.</p>
                                <p class="desc">Luôn cập nhật công nghệ mới, sẵn sàng học hỏi và phát triển bản thân nhằm đáp ứng các yêu cầu của doanh nghiệp hiện đại.</p>
                            </div>
                            <div class="candidate-details-wrap">
                                <h4 class="content-title">Học vấn</h4>
                                <div class="candidate-details-content">
                                    <div class="content-item">
                                        <h4 class="title">Thiết kế đồ họa <span>//</span> <span>2015 - 2018</span></h4>
                                        <h5 class="sub-title">Đại học Michigan, Ann Arbor</h5>
                                        <p class="desc">Tốt nghiệp xuất sắc chuyên ngành Thiết kế đồ họa, thành thạo các phần mềm thiết kế và tư duy mỹ thuật sáng tạo.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Phát triển Web <span>//</span> <span>2019 - 2020</span></h4>
                                        <h5 class="sub-title">Franklin and Marshall College</h5>
                                        <p class="desc">Được đào tạo bài bản về lập trình web, nắm vững các công nghệ mới về frontend và backend.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Chứng chỉ Mỹ thuật ứng dụng <span>//</span> <span>2020 - 2022</span></h4>
                                        <h5 class="sub-title">Franklin and Marshall College</h5>
                                        <p class="desc">Bổ sung kiến thức về mỹ thuật ứng dụng, sáng tạo trong thiết kế giao diện người dùng.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="candidate-details-wrap">
                                <h4 class="content-title">Kinh nghiệm làm việc</h4>
                                <div class="candidate-details-content">
                                    <div class="content-item">
                                        <h4 class="title">Nhân viên máy tính <span>//</span> <span>2014 - 2016</span></h4>
                                        <h5 class="sub-title">Sanguine Skincare Ltd.</h5>
                                        <p class="desc">Xử lý dữ liệu, hỗ trợ kỹ thuật và tham gia quản trị hệ thống CNTT nội bộ.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Nhà thiết kế giao diện người dùng <span>//</span> <span>2017 - 2020</span></h4>
                                        <h5 class="sub-title">Lambent Illumination Ltd.</h5>
                                        <p class="desc">Thiết kế giao diện website, xây dựng trải nghiệm người dùng (UX) tối ưu cho khách hàng.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">UI Designer Senior <span>//</span> <span>2020 - Hiện tại</span></h4>
                                        <h5 class="sub-title">Karibian IT Solution Ltd.</h5>
                                        <p class="desc">Dẫn dắt nhóm thiết kế, phát triển các sản phẩm số, chịu trách nhiệm về định hướng thiết kế sáng tạo của dự án.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="content-list-wrap">
                                <div class="content mb--0">
                                    <h4 class="title">Kỹ năng chuyên môn</h4>
                                    <ul class="team-details-list mb--0">
                                        <li><i class="icofont-check"></i> Thiết kế ứng dụng web</li>
                                        <li><i class="icofont-check"></i> Thiết kế giao diện người dùng (UI)</li>
                                        <li><i class="icofont-check"></i> Thiết kế ứng dụng di động</li>
                                        <li><i class="icofont-check"></i> Thiết kế landing page</li>
                                        <li><i class="icofont-check"></i> Thiết kế giao diện web</li>
                                        <li><i class="icofont-check"></i> Thiết kế tương tác</li>
                                        <li><i class="icofont-check"></i> Tối ưu trải nghiệm người dùng (UX)</li>
                                        <li><i class="icofont-check"></i> Thiết kế đồ họa</li>
                                        <li><i class="icofont-check"></i> Xây dựng thương hiệu & nhận diện</li>
                                        <li><i class="icofont-check"></i> Lập kế hoạch dự án</li>
                                        <li><i class="icofont-check"></i> Thiết kế prototype</li>
                                        <li><i class="icofont-check"></i> Giải quyết vấn đề</li>
                                    </ul>
                                </div>
                                <div class="content mb--0">
                                    <h4 class="title">Kỹ năng phần mềm</h4>
                                    <ul class="team-details-list mb--0">
                                        <li><i class="icofont-check"></i> Adobe Photoshop</li>
                                        <li><i class="icofont-check"></i> Adobe Illustrator</li>
                                        <li><i class="icofont-check"></i> Adobe XD</li>
                                        <li><i class="icofont-check"></i> Figma</li>
                                        <li><i class="icofont-check"></i> Sketch</li>
                                        <li><i class="icofont-check"></i> InVision Studio</li>
                                        <li><i class="icofont-check"></i> UXPin</li>
                                        <li><i class="icofont-check"></i> MockFlow</li>
                                        <li><i class="icofont-check"></i> Balsamiq</li>
                                        <li><i class="icofont-check"></i> Microsoft Word</li>
                                        <li><i class="icofont-check"></i> Microsoft Excel</li>
                                        <li><i class="icofont-check"></i> Microsoft PowerPoint</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="team-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Thông tin chung</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Lĩnh vực</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển phần mềm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Mức lương mong muốn</td>
                                                <td class="dotted">:</td>
                                                <td>50.000.000đ / tháng</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>5 năm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngoại ngữ</td>
                                                <td class="dotted">:</td>
                                                <td>Tiếng Anh, Tiếng Đức</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Độ tuổi</td>
                                                <td class="dotted">:</td>
                                                <td>27-30</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Giới tính</td>
                                                <td class="dotted">:</td>
                                                <td>Nữ</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Bằng cấp</td>
                                                <td class="dotted">:</td>
                                                <td>BSC, MSC</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Cấp bậc</td>
                                                <td class="dotted">:</td>
                                                <td>Senior</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Lượt xem</td>
                                                <td class="dotted">:</td>
                                                <td>8.567</td>
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
                                    <div class="form-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc khu vực chi tiết ứng viên ==-->
    </main>
@endsection
