@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Chi tiết việc làm</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Chi tiết việc làm</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu khu vực chi tiết việc làm ==-->
        <section class="job-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="job-details-wrap">
                            <div class="job-details-info">
                                <div class="thumb">
                                    <img src="../client/assets/img/companies/10.webp" width="130" height="130" alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Lập trình viên Web Senior</h4>
                                    <h5 class="sub-title">Obelus Concepts Ltd.</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Mỹ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-details-price">
                                <h4 class="title">50.000.000đ <span>/tháng</span></h4>
                                <button type="button" class="btn-theme">Ứng tuyển ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="job-details-item">
                            <div class="content">
                                <h4 class="title">Mô tả công việc</h4>
                                <p class="desc">Bạn sẽ tham gia phát triển các theme tùy chỉnh theo tiêu chuẩn ThemeForest và WordPress, xây dựng website tương tác, tối ưu hiệu suất và đảm bảo hoàn thành đúng deadline.</p>
                                <p class="desc">Công việc yêu cầu khả năng làm việc nhóm, sáng tạo và liên tục cải thiện kỹ năng cá nhân.</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Trách nhiệm</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Phát triển theme tùy chỉnh theo chuẩn WordPress & ThemeForest.</li>
                                    <li><i class="icofont-check"></i> Thiết kế website tương tác, responsive.</li>
                                    <li><i class="icofont-check"></i> Đảm bảo deadline nghiêm ngặt.</li>
                                    <li><i class="icofont-check"></i> Tối ưu hóa tốc độ tải trang/theme.</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu ứng viên</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Ưu tiên từng có theme được duyệt trên ThemeForest.</li>
                                    <li><i class="icofont-check"></i> Thành thạo tiêu chuẩn theme WordPress.</li>
                                    <li><i class="icofont-check"></i> Có thể chuyển đổi HTML sang theme WordPress hoàn chỉnh.</li>
                                    <li><i class="icofont-check"></i> Thành thạo PHP hướng đối tượng, HTML, CSS, JS, jQuery.</li>
                                    <li><i class="icofont-check"></i> Biết sử dụng các API lõi của WordPress: options, metadata, REST, hooks, settings,...</li>
                                    <li><i class="icofont-check"></i> Có khả năng phân tích, debug và sửa lỗi code từ dev khác.</li>
                                    <li><i class="icofont-check"></i> Có tinh thần hài hước, tích cực.</li>
                                    <li><i class="icofont-check"></i> Siêng năng, đam mê công việc, sẵn sàng phát triển cùng công ty.</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu học vấn</h4>
                                <p class="desc">Chúng tôi không quan trọng bằng cấp, chỉ cần bạn có đam mê, sẵn sàng học hỏi và chịu khó.</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Giờ làm việc</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> 8:00 - 17:00</li>
                                    <li><i class="icofont-check"></i> Làm việc 5 ngày/tuần.</li>
                                    <li><i class="icofont-check"></i> Nghỉ: Thứ 7, Chủ nhật.</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Phúc lợi</h4>
                                <ul class="job-details-list">
                                    <li><i class="icofont-check"></i> Làm việc trong môi trường phẳng, ý kiến của bạn luôn được lắng nghe.</li>
                                    <li><i class="icofont-check"></i> Tham gia quỹ công đoàn.</li>
                                    <li><i class="icofont-check"></i> Thưởng lễ/tết, thưởng hiệu suất.</li>
                                    <li><i class="icofont-check"></i> Hỗ trợ y tế, bảo hiểm.</li>
                                    <li><i class="icofont-check"></i> Hợp tác với nhiều bệnh viện lớn.</li>
                                    <li><i class="icofont-check"></i> Tăng lương định kỳ hàng năm.</li>
                                    <li><i class="icofont-check"></i> Thưởng sinh nhật, kết hôn, nghỉ phép kết hôn, nghỉ phép thai sản.</li>
                                    <li><i class="icofont-check"></i> Du lịch, teambuilding hằng năm.</li>
                                    <li><i class="icofont-check"></i> Ăn trưa miễn phí, trà/cà phê/snack thoải mái.</li>
                                    <li><i class="icofont-check"></i> Được đào tạo, tham gia các buổi chia sẻ chuyên môn.</li>
                                    <li><i class="icofont-check"></i> Chơi bóng bàn, các hoạt động nội bộ vui nhộn.</li>
                                    <li><i class="icofont-check"></i> Môi trường làm việc hiện đại, thân thiện, chuyên nghiệp.</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="title">Cam kết bình đẳng</h4>
                                <p class="desc">Finate cam kết tạo môi trường làm việc hạnh phúc và bình đẳng cho tất cả mọi người, không phân biệt giới tính, độ tuổi, tôn giáo, dân tộc, tình trạng hôn nhân, khuyết tật hay bất kỳ yếu tố nào khác.</p>
                                <a class="btn-apply-now" href="contact.html">Ứng tuyển ngay <i class="icofont-long-arrow-right"></i></a>
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
                                                <td class="table-name">Loại hình</td>
                                                <td class="dotted">:</td>
                                                <td data-text-color="#03a84e">Toàn thời gian</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngành nghề</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển phần mềm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngày đăng</td>
                                                <td class="dotted">:</td>
                                                <td>20/06/2022</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Lương</td>
                                                <td class="dotted">:</td>
                                                <td>50.000.000đ / tháng</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>5 năm</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Giới tính</td>
                                                <td class="dotted">:</td>
                                                <td>Nam/Nữ</td>
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
                                                <td class="table-name">Số lượt ứng tuyển</td>
                                                <td class="dotted">:</td>
                                                <td>26 ứng viên</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Hạn ứng tuyển</td>
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
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener"><i class="icofont-facebook"></i></a>
                                    <a href="https://twitter.com" target="_blank" rel="noopener"><i class="icofont-twitter"></i></a>
                                    <a href="https://www.skype.com" target="_blank" rel="noopener"><i class="icofont-skype"></i></a>
                                    <a href="https://www.pinterest.com" target="_blank" rel="noopener"><i class="icofont-pinterest"></i></a>
                                    <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="icofont-dribbble"></i></a>
                                </div>
                            </div>
                            <div class="widget-item widget-tag">
                                <div class="widget-title">
                                    <h3 class="title">Tags:</h3>
                                </div>
                                <div class="widget-tag-list">
                                    <a href="job.html">Lập trình</a>
                                    <a href="job.html">Thiết kế web</a>
                                    <a href="job.html">Phần mềm</a>
                                    <a href="job.html">Công nghệ</a>
                                    <a href="job.html">Senior</a>
                                    <a href="job.html">Toàn thời gian</a>
                                    <!-- Thêm các tag thực tế của công việc -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc khu vực chi tiết việc làm ==-->
    </main>
@endsection
