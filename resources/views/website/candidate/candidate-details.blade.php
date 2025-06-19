



@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
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
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Team Details Area Wrapper ==-->
        <section class="team-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="team-details-wrap">
                            <div class="team-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/team/details1.webp" width="130" height="130"
                                        alt="Ảnh Frida Marchand">
                                </div>
                                <div class="content">
                                    <h4 class="title">Frida Marchand</h4>
                                    <h5 class="sub-title">Phát triển Web</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Hoa Kỳ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="team-details-btn">
                                <button type="button" class="btn-theme btn-light">Thêm vào danh sách</button>
                                <button type="button" class="btn-theme">Tải CV</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="team-details-item">
                            <div class="content">
                                <h4 class="title">Giới thiệu Ứng viên</h4>
                                <p class="desc">Đây là một thực tế lâu đời rằng người đọc sẽ bị phân tâm bởi nội dung
                                    trang khi nhìn vào bố cục của nó. Lorem Ipsum được sử dụng vì có phân bố chữ cái gần
                                    giống bản văn thật, thay vì chỉ dùng các gói xuất bản nội dung hoặc trình chỉnh sửa
                                    trang web. Đây là một thực tế lâu đời rằng người đọc sẽ bị phân tâm bởi nội dung trang
                                    khi nhìn vào bố cục. Lorem Ipsum giúp minh họa cho thiết kế và trình bày nội dung.</p>
                                <p class="desc">Nội dung này chỉ mang tính minh họa cho thiết kế; bạn có thể thay bằng
                                    thông tin thực tế của ứng viên.</p>
                            </div>

                            <div class="candidate-details-wrap">
                                <h4 class="content-title">Học vấn</h4>
                                <div class="candidate-details-content">
                                    <div class="content-item">
                                        <h4 class="title">Thiết kế Đồ họa <span>//</span> <span>2015 - 2018</span></h4>
                                        <h5 class="sub-title">Đại học Michigan, Ann Arbor</h5>
                                        <p class="desc">Nội dung này mang tính minh họa về chương trình học Thiết kế Đồ
                                            họa tại Đại học Michigan.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Phát triển Web <span>//</span> <span>2019 - 2020</span></h4>
                                        <h5 class="sub-title">Franklin and Marshall College</h5>
                                        <p class="desc">Nội dung này mang tính minh họa về chương trình học Phát triển Web
                                            tại Franklin and Marshall College.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Cử nhân Mỹ thuật <span>//</span> <span>2020 - 2022</span></h4>
                                        <h5 class="sub-title">Franklin and Marshall College</h5>
                                        <p class="desc">Nội dung này mang tính minh họa về chương trình Cử nhân Mỹ thuật
                                            tại Franklin and Marshall College.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="candidate-details-wrap">
                                <h4 class="content-title">Công việc &amp; Kinh nghiệm</h4>
                                <div class="candidate-details-content">
                                    <div class="content-item">
                                        <h4 class="title">Nhân viên Vận hành Máy tính <span>//</span> <span>2014 -
                                                2016</span></h4>
                                        <h5 class="sub-title">Sanguine Skincare Ltd.</h5>
                                        <p class="desc">Nội dung minh họa về vai trò Nhân viên Vận hành Máy tính tại
                                            Sanguine Skincare Ltd.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Nhà thiết kế Giao diện Người dùng <span>//</span> <span>2017 -
                                                2020</span></h4>
                                        <h5 class="sub-title">Lambent Illumination Ltd.</h5>
                                        <p class="desc">Nội dung minh họa về vai trò Nhà thiết kế Giao diện Người dùng tại
                                            Lambent Illumination Ltd.</p>
                                    </div>
                                    <div class="content-item">
                                        <h4 class="title">Chuyên viên Thiết kế UI cao cấp <span>//</span> <span>2020 - Hiện
                                                tại</span></h4>
                                        <h5 class="sub-title">Karibian IT Solution Ltd.</h5>
                                        <p class="desc">Nội dung minh họa về vai trò Chuyên viên Thiết kế UI cao cấp tại
                                            Karibian IT Solution Ltd.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="content-list-wrap">
                                <div class="content mb--0">
                                    <h4 class="title">Kỹ năng chuyên môn</h4>
                                    <ul class="team-details-list mb--0">
                                        <li><i class="icofont-check"></i> Thiết kế Ứng dụng Web</li>
                                        <li><i class="icofont-check"></i> Thiết kế Giao diện Người dùng (UI)</li>
                                        <li><i class="icofont-check"></i> Thiết kế Ứng dụng Di động</li>
                                        <li><i class="icofont-check"></i> Thiết kế Landing Page</li>
                                        <li><i class="icofont-check"></i> Thiết kế Giao diện Web</li>
                                        <li><i class="icofont-check"></i> Thiết kế Tương tác</li>
                                        <li><i class="icofont-check"></i> Trải nghiệm Người dùng (UX)</li>
                                        <li><i class="icofont-check"></i> Thiết kế Đồ họa</li>
                                        <li><i class="icofont-check"></i> Xây dựng Thương hiệu &amp; Nhận diện</li>
                                        <li><i class="icofont-check"></i> Lập kế hoạch Dự án</li>
                                        <li><i class="icofont-check"></i> Phát thảo &amp; Prototyping</li>
                                        <li><i class="icofont-check"></i> Giải quyết Vấn đề</li>
                                    </ul>
                                </div>
                                <div class="content mb--0">
                                    <h4 class="title">Kỹ năng Phần mềm</h4>
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
                                    <h3 class="title">Thông tin</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Danh mục</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Mức lương đề xuất</td>
                                                <td class="dotted">:</td>
                                                <td>$5000 / Tháng</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>5 Năm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngôn ngữ</td>
                                                <td class="dotted">:</td>
                                                <td>Tiếng Anh, Tiếng Đức</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Độ tuổi</td>
                                                <td class="dotted">:</td>
                                                <td>27–30 Tuổi</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Giới tính</td>
                                                <td class="dotted">:</td>
                                                <td>Nữ</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Bằng cấp</td>
                                                <td class="dotted">:</td>
                                                <td>Cử nhân, Thạc sĩ</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Cấp bậc</td>
                                                <td class="dotted">:</td>
                                                <td>Cao cấp</td>
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
                                    <div class="form-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--== End Team Details Area Wrapper ==-->
    </main>
@endsection
