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

                            <h2 class="title">Chi tiết công việc</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li><a href="{{ route('jobs.index') }}">Việc làm</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Chi tiết</li>

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


        <!--== Bắt đầu chi tiết công việc ==-->

        <!--== Bắt đầu khu vực chi tiết việc làm ==-->

        <section class="job-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="job-details-wrap">
                            <div class="job-details-info">
                                <div class="thumb">

                                    <img src="{{ $job->company->logo_url ?? '../client/assets/img/companies/10.webp' }}"
                                         width="130" height="130" alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ $job->title }}</h4>
                                    <h5 class="sub-title">{{ $job->company->name }}</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> {{ $job->location }}</li>
                                        <li><i class="icofont-phone"></i> {{ $job->company->phone ?? 'N/A' }}</li>

                                    <img src="../client/assets/img/companies/10.webp" width="130" height="130"
                                        alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Chuyên viên Phát triển Web Cao cấp</h4>
                                    <img src="../client/assets/img/companies/10.webp" width="130" height="130" alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">Lập trình viên Web Senior</h4>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> New York, Mỹ</li>
                                        <li><i class="icofont-phone"></i> +88 456 796 457</li>

                                    </ul>
                                </div>
                            </div>
                            <div class="job-details-price">

                                <h4 class="title">{{ number_format($job->salary_min) }}đ <span>/tháng</span></h4>
                                <a href="#" class="btn-theme">Ứng tuyển ngay</a>

                                <h4 class="title">$5000 <span>/tháng</span></h4>
                                <button type="button" class="btn-theme">Nộp hồ sơ</button>
                                <h4 class="title">50.000.000đ <span>/tháng</span></h4>
                                <button type="button" class="btn-theme">Ứng tuyển ngay</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">

                        <div class="job-details-content">
                            <div class="content">
                                <h4 class="title">Mô tả công việc</h4>
                                <p class="desc">{{ $job->description }}</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu</h4>
                                <p class="desc">{{ $job->requirements }}</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Phúc lợi</h4>
                                @php
                                    $benefits = is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true);
                                @endphp
                                @if (!empty($benefits))
                                    <ul class="job-details-list">
                                        @foreach($benefits as $benefit)
                                            <li><i class="icofont-check"></i> {{ $benefit }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="desc">Không có thông tin phúc lợi.</p>
                                @endif

                        <div class="job-details-item">
                            <div class="content">
                                <h4 class="title">Mô tả</h4>
                                <p class="desc">Đây là một thực tế lâu đời rằng người đọc sẽ bị phân tâm bởi nội dung
                                    trang khi nhìn vào bố cục của nó. Lorem Ipsum được sử dụng vì giống với văn bản thật về
                                    mặt phân bố chữ cái, thay vì chỉ sử dụng văn bản mẫu thuần túy.</p>
                                <p class="desc">Bạn sẽ chịu trách nhiệm xây dựng các giao diện chất lượng cao, đảm bảo
                                    tương thích và tối ưu hiệu suất trên nhiều thiết bị.</p>

                                <h4 class="title">Mô tả công việc</h4>
                                <p class="desc">Bạn sẽ tham gia phát triển các theme tùy chỉnh theo tiêu chuẩn ThemeForest và WordPress, xây dựng website tương tác, tối ưu hiệu suất và đảm bảo hoàn thành đúng deadline.</p>
                                <p class="desc">Công việc yêu cầu khả năng làm việc nhóm, sáng tạo và liên tục cải thiện kỹ năng cá nhân.</p>

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
                                <p class="desc">Không quan trọng bạn tốt nghiệp trường nào hay điểm số bao nhiêu, miễn bạn
                                    thông minh, đam mê và sẵn sàng làm việc chăm chỉ.</p>
                                <p class="desc">Chúng tôi không quan trọng bằng cấp, chỉ cần bạn có đam mê, sẵn sàng học hỏi và chịu khó.</p>
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

                                    <h3 class="title">Thông tin</h3>

                                    <h3 class="title">Tóm tắt</h3>

                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>

                                                <td class="table-name">Loại công việc</td>
                                                <td class="dotted">:</td>
                                                <td>
                                                    @switch($job->job_type)
                                                        @case('full-time')
                                                            Toàn thời gian
                                                            @break
                                                        @case('part-time')
                                                            Bán thời gian
                                                            @break
                                                        @case('remote')
                                                            Làm từ xa
                                                            @break
                                                        @default
                                                            {{ $job->job_type }}
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Mức lương</td>
                                                <td class="dotted">:</td>
                                                <td>{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Địa chỉ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Chính sách làm việc từ xa</td>
                                                <td class="dotted">:</td>
                                                <td>
                                                    @switch($job->remote_policy)
                                                        @case('on-site')
                                                            Làm tại văn phòng
                                                            @break
                                                        @case('hybrid')
                                                            Hybrid
                                                            @break
                                                        @case('remote')
                                                            Làm từ xa
                                                            @break
                                                        @default
                                                            {{ $job->remote_policy }}
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Cấp bậc</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->level }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->experience }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngôn ngữ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->language }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngày đăng</td>

                                                <td class="table-name">Loại công việc</td>
                                                <td class="table-name">Loại hình</td>
                                                <td class="dotted">:</td>
                                                <td data-text-color="#03a84e">Toàn thời gian</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Danh mục</td>
                                                <td class="dotted">:</td>
                                                <td>Phát triển</td>
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
                                                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                                                <td>Cử nhân, Thạc sĩ</td>
                                            </tr>
                                            <tr>

                                                <td class="table-name">Hạn nộp hồ sơ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->deadline->format('d/m/Y') }}</td>

                                                <td class="table-name">Cấp bậc</td>
                                                <td class="dotted">:</td>
                                                <td>Cao cấp</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Đã ứng tuyển</td>
                                                <td class="table-name">Số lượt ứng tuyển</td>
                                                <td class="dotted">:</td>
                                                <td>26 ứng viên</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Hạn nộp hồ sơ</td>
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

        <!--== Kết thúc chi tiết công việc ==-->

        <!--== Kết thúc khu vực chi tiết việc làm ==-->

    </main>
@endsection