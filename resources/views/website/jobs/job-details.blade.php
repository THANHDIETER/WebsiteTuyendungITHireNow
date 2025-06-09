@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Job Details Area Wrapper ==-->
        <section class="job-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="job-details-wrap">
                            <div class="job-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/companies/10.webp" width="130" height="130"
                                        alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Chuyên viên Phát triển Web Cao cấp</h4>
                                    <h5 class="sub-title">Obelus Concepts Ltd.</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, USA</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-details-price">
                                <h4 class="title">$5000 <span>/tháng</span></h4>
                                <button type="button" class="btn-theme">Nộp hồ sơ</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="job-details-item">
                            <div class="content">
                                <h4 class="title">Mô tả</h4>
                                <p class="desc">Đây là một thực tế lâu đời rằng người đọc sẽ bị phân tâm bởi nội dung
                                    trang khi nhìn vào bố cục của nó. Lorem Ipsum được sử dụng vì giống với văn bản thật về
                                    mặt phân bố chữ cái, thay vì chỉ sử dụng văn bản mẫu thuần túy.</p>
                                <p class="desc">Bạn sẽ chịu trách nhiệm xây dựng các giao diện chất lượng cao, đảm bảo
                                    tương thích và tối ưu hiệu suất trên nhiều thiết bị.</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Trách nhiệm</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Phát triển theme tùy chỉnh (tiêu chuẩn WordPress.org &
                                        ThemeForest)</li>
                                    <li><i class="icofont-check"></i> Thiết kế giao diện trang web đáp ứng (responsive)</li>
                                    <li><i class="icofont-check"></i> Hoàn thành công việc đúng hạn khó khăn</li>
                                    <li><i class="icofont-check"></i> Tối ưu tốc độ tải trang cho theme</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Ưu tiên ứng viên đã có theme được phê duyệt trên
                                        ThemeForest</li>
                                    <li><i class="icofont-check"></i> Am hiểu sâu về tiêu chuẩn theme WordPress</li>
                                    <li><i class="icofont-check"></i> Chuyển đổi mẫu HTML thành theme WordPress hoàn chỉnh
                                    </li>
                                    <li><i class="icofont-check"></i> Thành thạo OOP PHP và front-end (HTML, CSS, JS,
                                        jQuery,…)</li>
                                    <li><i class="icofont-check"></i> Kiến thức về API cốt lõi WordPress (options, metadata,
                                        REST, hooks,…)</li>
                                    <li><i class="icofont-check"></i> Khả năng debug và sửa lỗi từ mã của đồng nghiệp</li>
                                    <li><i class="icofont-check"></i> Có khiếu hài hước</li>
                                    <li><i class="icofont-check"></i> Chăm chỉ, nhiệt huyết – chúng tôi đang phát triển
                                        nhanh</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu học vấn</h4>
                                <p class="desc">Không quan trọng bạn tốt nghiệp trường nào hay điểm số bao nhiêu, miễn bạn
                                    thông minh, đam mê và sẵn sàng làm việc chăm chỉ.</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Giờ làm việc</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> 8:00 AM - 5:00 PM</li>
                                    <li><i class="icofont-check"></i> Thứ trong tuần: 5 ngày</li>
                                    <li><i class="icofont-check"></i> Cuối tuần: Thứ Bảy, Chủ Nhật</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Quyền lợi</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Môi trường phẳng, tiếng nói luôn được lắng nghe</li>
                                    <li><i class="icofont-check"></i> Quỹ hưu trí (Provident fund)</li>
                                    <li><i class="icofont-check"></i> Trợ cấp thôi việc (Gratuity)</li>
                                    <li><i class="icofont-check"></i> Quỹ y tế</li>
                                    <li><i class="icofont-check"></i> Hợp tác với nhiều bệnh viện</li>
                                    <li><i class="icofont-check"></i> Thưởng hiệu suất hàng năm</li>
                                    <li><i class="icofont-check"></i> Tăng lương hàng năm</li>
                                    <li><i class="icofont-check"></i> Thưởng lễ hội 2 lần/năm</li>
                                    <li><i class="icofont-check"></i> Cơm trưa được trợ cấp 100%</li>
                                    <li><i class="icofont-check"></i> Trà, cà phê & đồ ăn nhẹ không giới hạn</li>
                                    <li><i class="icofont-check"></i> Du lịch hằng năm</li>
                                    <li><i class="icofont-check"></i> Team building</li>
                                    <li><i class="icofont-check"></i> Thưởng đám cưới & nghỉ cưới</li>
                                    <li><i class="icofont-check"></i> Nghỉ có lương cho cha/mẹ mới sinh</li>
                                    <li><i class="icofont-check"></i> Tour gia đình hàng năm</li>
                                    <li><i class="icofont-check"></i> Chia sẻ kiến thức nội bộ</li>
                                    <li><i class="icofont-check"></i> Thanh toán tiền nghỉ phép chưa sử dụng</li>
                                    <li><i class="icofont-check"></i> Làm việc với đội ngũ & sản phẩm năng động</li>
                                    <li><i class="icofont-check"></i> Khu vực giải trí: bóng bàn</li>
                                    <li><i class="icofont-check"></i> Tài liệu đào tạo & phát triển kỹ năng</li>
                                    <li><i class="icofont-check"></i> Môi trường làm việc đẳng cấp quốc tế</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Tuyên bố</h4>
                                <p class="desc">Finate cam kết xây dựng môi trường làm việc hạnh phúc nhất và tự hào tạo
                                    cơ hội bình đẳng cho tất cả. Mọi ứng viên đủ điều kiện sẽ được cân nhắc tuyển dụng mà
                                    không phân biệt chủng tộc, tôn giáo, giới tính, độ tuổi, khuyết tật hay bất kỳ đặc điểm
                                    nào khác theo luật định.</p>
                                <a class="btn-apply-now" href="contact.html">Nộp hồ sơ <i
                                        class="icofont-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="job-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Tóm tắt</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Loại công việc</td>
                                                <td class="dotted">:</td>
                                                <td data-text-color="#03a84e">Toàn thời gian</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Danh mục</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngày đăng</td>
                                                <td class="dotted">:</td>
                                                <td>20/06/2022</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Danh mục</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Mức lương</td>
                                                <td class="dotted">:</td>
                                                <td>$5000 / Tháng</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>5 Năm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Giới tính</td>
                                                <td class="dotted">:</td>
                                                <td>Nam hoặc Nữ</td>
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
                                                <td class="table-name">Đã ứng tuyển</td>
                                                <td class="dotted">:</td>
                                                <td>26 ứng viên</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Hạn nộp hồ sơ</td>
                                                <td class="dotted">:</td>
                                                <td data-text-color="#ff6000">20/11/2022</td>
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
                            <div class="widget-item widget-tag">
                                <div class="widget-title">
                                    <h3 class="title">Thẻ</h3>
                                </div>
                                <div class="widget-tag-list">
                                    <a href="job.html">Vệ sinh</a>
                                    <a href="job.html">Đơn vị vệ sinh</a><br>
                                    <a href="job.html">Kinh doanh</a>
                                    <a href="job.html">Vệ sinh</a>
                                    <a href="job.html">Kinh doanh</a>
                                    <a href="job.html">Vệ sinh</a>
                                    <a href="job.html">Đơn vị vệ sinh</a>
                                    <a href="job.html">Kinh doanh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Job Details Area Wrapper ==-->
    </main>
@endsection
