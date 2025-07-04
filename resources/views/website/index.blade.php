@extends('website.layouts.master')

@section('content')
    <main class="main-content">

        <!--== Start Hero Area Wrapper ==-->
        <section class="home-slider-area">
            <div class="home-slider-container default-slider-container">
                <div class="home-slider-wrapper slider-default">
                    <div class="slider-content-area" data-bg-img="../client/assets/img/banner/17.png">
                        <div class="container pt--0 pb--0">
                            <div class="slider-container">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <div class="slider-content">
                                            <h2 class="title">
                                                Tìm công việc tuyệt vời để xây dựng sự nghiệp tươi sáng cho bạn.
                                            </h2>
                                        </div>
                                    </div>
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
                </div>
            </div>
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="play-video-btn">
                            <a href="https://www.youtube.com/mcvqOUtcAJg" class="video-popup">
                                <img src="../client/assets/img/icons/play.webp" alt="Image-HasTech">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="home-slider-shape">
                <img class="shape1" data-aos="fade-down" data-aos-duration="1500"
                    src="../client/assets/img/slider/vector1.webp" width="270" height="234" alt="Image-HasTech">
                <img class="shape2" data-aos="fade-left" data-aos-duration="2000"
                    src="../client/assets/img/slider/vector2.webp" width="201" height="346" alt="Image-HasTech">
                <img class="shape3" data-aos="fade-right" data-aos-duration="2000"
                    src="../client/assets/img/slider/vector3.webp" width="276" height="432" alt="Image-HasTech">
                <img class="shape4" data-aos="flip-left" data-aos-duration="1500"
                    src="../client/assets/img/slider/vector4.webp" width="127" height="121" alt="Image-HasTech">
            </div> --}}
        </section>
        <!--== End Hero Area Wrapper ==-->

        <!--== Start Job Category Area Wrapper ==-->
        <section class="job-category-area">
            <div class="container" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title">Ngành nghề nổi bật</h3>
                            <div class="desc">
                                <p>Nhiều ngành nghề được tuyển dụng trên nền tảng</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-gutter-20">
                    @forelse($categories as $category)
                        <div class="col-sm-6 col-lg-3">
                            <div class="job-category-item">
                                <div class="content">
                                    <h3 class="title">
                                        <a href="{{ route('jobs.index', ['category' => $category->id]) }}">
                                            {{ $category->name }} <span>({{ $category->jobs_count }})</span>
                                        </a>
                                    </h3>
                                </div>
                                <a class="overlay-link"
                                    href="{{ route('jobs.index', ['category' => $category->id]) }}"></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                Chưa có danh mục ngành nghề nào.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <!--== End Job Category Area Wrapper ==-->

        <!--== Start Recent Job Area Wrapper ==-->
        <section class="recent-job-area bg-color-gray py-5">
            <div class="container" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title">Việc làm gần đây</h3>
                            <div class="desc">
                                <p>Nhiều cơ hội nghề nghiệp hấp dẫn đang đợi bạn</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @forelse($jobs as $job)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="job-card rounded-3 p-3 h-100 position-relative animate__animated animate__fadeInUp"
                                style="min-height: 350px; background: linear-gradient(135deg, #e3f2fd 0%, #f1f8e9 100%); border: 1px solid #dee2e6; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; overflow: visible;">
                                @if($job->is_featured)
                                    <span class="badge-hot-ithirenow position-absolute" style="z-index:10; left: -18px; top: -18px;">HOT</span>
                                @endif
                                <div class="company-logo mb-3 position-absolute top-0 start-0 p-2">
                                    <a href="{{ route('jobs.show', $job->slug) }}">
                                        @if ($job->company && $job->company->logo_url)
                                            <img src="{{ $job->company->logo_url }}" width="50" height="50"
                                                class="rounded-circle border bg-light p-1"
                                                alt="{{ $job->company->name ?? 'Company Logo' }}">
                                        @else
                                            <img src="../client/assets/img/companies/1.webp" width="50"
                                                height="50" class="rounded-circle border bg-light p-1"
                                                alt="Company Logo">
                                        @endif
                                    </a>
                                </div>
                                <div class="job-details mt-5">
                                    <h6 class="text-muted small mb-1">{{ $job->company->name ?? 'N/A' }}</h6>
                                    <h4 class="job-title mb-2 text-dark fw-bold">
                                        <a href="{{ route('jobs.show', $job->slug) }}"
                                            class="text-dark text-decoration-none">
                                            {{ $job->title }}
                                        </a>
                                    </h4>
                                    <span class="badge bg-success-subtle text-success mb-2 px-2 py-1">
                                        {{ ucfirst($job->job_type ?? 'N/A') }}
                                    </span>
                                    <p class="job-desc text-secondary small mb-3">
                                        {{ Str::limit($job->description ?? '', 80) }}</p>
                                    <div class="skills-tags d-flex flex-wrap gap-2 mb-3">
                                        @if ($job->skills ?? [])
                                            @foreach ($job->skills as $skill)
                                                <span class="badge bg-info-subtle text-info small px-2 py-1">
                                                    {{ $skill->name ?? 'Skill' }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary small px-2 py-1">Không có
                                                kỹ năng</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="job-footer d-flex justify-content-between align-items-end mt-auto p-2">
                                    <div class="salary-info">
                                        <h5 class="text-success fw-bold mb-0">
                                            {{ number_format($job->salary_min ?? 0) }} -
                                            {{ number_format($job->salary_max ?? 0) }}
                                        </h5>
                                        <p class="text-muted small">{{ $job->currency ?? 'VND' }}/tháng</p>
                                    </div>
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                        class="btn btn-primary rounded-pill px-3 py-2 fw-semibold text-white hover-scale"
                                        style="background-color: #007bff; transition: all 0.3s ease;">
                                        Ứng tuyển ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center rounded-3 shadow-sm py-3">
                                <i class="bi bi-info-circle fs-4 mb-2"></i>
                                <h5 class="mb-0">Chưa có tin tuyển dụng nào.</h5>
                            </div>
                        </div>
                    @endforelse
                </div>
                <style>
                    .job-card {
                        position: relative;
                        overflow: visible;
                        transition: transform 0.3s cubic-bezier(.4,2,.6,1), box-shadow 0.3s;
                    }
                    .job-card:hover {
                        transform: scale(1.05) translateY(-5px);
                        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
                    }
                    .badge-hot-ithirenow {
                        background: #ff2d2d;
                        color: #fff;
                        font-weight: bold;
                        font-size: 1.05em;
                        padding: 0.55em 1.3em;
                        border-radius: 0.7em 0.7em 0.7em 0.7em;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
                        transform: rotate(-18deg);
                        left: -18px;
                        top: -18px;
                        position: absolute;
                        letter-spacing: 1px;
                        pointer-events: none;
                        transition: transform 0.3s cubic-bezier(.4,2,.6,1);
                    }
                    .job-card:hover .badge-hot-ithirenow {
                        transform: scale(1.05) rotate(-18deg) translateY(-5px);
                    }
                </style>
            </div>
        </section>

        <!--== Start Work Process Area Wrapper ==-->
        <section class="work-process-area">
            <div class="container" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title">Quy trình hoạt động</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="working-process-content-wrap">
                            <div class="working-col">
                                <!--== Start Work Process ==-->
                                <div class="working-process-item">
                                    <div class="icon-box">
                                        <div class="inner">
                                            <img class="icon-img" src="../client/assets/img/icons/w1.webp"
                                                alt="Image-HasTech">
                                            <img class="icon-hover" src="../client/assets/img/icons/w1-hover.webp"
                                                alt="Image-HasTech">
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Tạo tài khoản</h4>
                                        <p class="desc">Nhấp vào nút "Đăng ký", điền đầy đủ thông tin như họ tên, email
                                            và mật khẩu, sau đó xác minh email của bạn để hoàn tất quá trình tạo tài khoản.
                                        </p>
                                    </div>
                                    <div class="shape-arrow-icon">
                                        <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp"
                                            alt="Image-HasTech">
                                        <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp"
                                            alt="Image-HasTech">
                                    </div>
                                </div>
                                <!--== End Work Process ==-->
                            </div>
                            <div class="working-col">
                                <!--== Start Work Process ==-->
                                <div class="working-process-item">
                                    <div class="icon-box">
                                        <div class="inner">
                                            <img class="icon-img" src="../client/assets/img/icons/w3.webp"
                                                alt="Image-HasTech">
                                            <img class="icon-hover" src="../client/assets/img/icons/w3-hover.webp"
                                                alt="Image-HasTech">
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Tìm việc làm</h4>
                                        <p class="desc">Sau khi đăng nhập, bạn có thể sử dụng thanh tìm kiếm hoặc bộ lọc
                                            để tìm việc theo ngành nghề, vị trí, mức lương và địa điểm phù hợp.</p>
                                    </div>
                                    <div class="shape-arrow-icon">
                                        <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp"
                                            alt="Image-HasTech">
                                        <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp"
                                            alt="Image-HasTech">
                                    </div>
                                </div>
                                <!--== End Work Process ==-->
                            </div>
                            <div class="working-col">
                                <!--== Start Work Process ==-->
                                <div class="working-process-item">
                                    <div class="icon-box">
                                        <div class="inner">
                                            <img class="icon-img" src="../client/assets/img/icons/w4.webp"
                                                alt="Image-HasTech">
                                            <img class="icon-hover" src="../client/assets/img/icons/w4-hover.webp"
                                                alt="Image-HasTech">
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Lưu và Ứng tuyển</h4>
                                        <p class="desc">Khi tìm được công việc phù hợp, bạn có thể nhấn "Lưu" để xem lại
                                            sau hoặc nhấn "Ứng tuyển" để nộp hồ sơ trực tuyến nhanh chóng.</p>
                                    </div>
                                    <div class="shape-arrow-icon d-none">
                                        <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp"
                                            alt="Image-HasTech">
                                        <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp"
                                            alt="Image-HasTech">
                                    </div>
                                </div>
                                <!--== End Work Process ==-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Work Process Area Wrapper ==-->

        <!--== Start Brand Logo Area Wrapper ==-->
        <div class="brand-logo-area">
            <div class="container pt--0 pb--0" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="brand-logo-content">
                            <div class="swiper brand-logo-slider-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/1.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/2.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/3.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/4.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/5.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/6.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/1.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                </div>
                            </div>
                            <!--== Add Swiper Arrows ==-->
                            <div class="swiper-btn-wrap">
                                <div class="brand-swiper-btn-prev">
                                    <i class="icofont-long-arrow-left"></i>
                                </div>
                                <div class="brand-swiper-btn-next">
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Brand Logo Area Wrapper ==-->

        <!--== Start Testimonial Area Wrapper ==-->
        <section class="testimonial-area bg-color-gray">
            <div class="container" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title">Khách hàng hài lòng của chúng tôi</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="swiper testi-slider-container">
                            <div class="swiper-wrapper">

                                <!--== Start Testimonial Item ==-->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author">
                                                <div class="testi-thumb">
                                                    <img src="../client/assets/img/testimonial/1.webp" width="75"
                                                        height="75" alt="Hình ảnh khách hàng">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Roselia Hamets</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">Đây là một sự thật rằng người đọc thường bị xao nhãng bởi
                                                    bố cục của trang khi xem nội dung có thể đọc được có sự phân bố chữ cái
                                                    gần như bình thường.</p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp"
                                                        alt="Trích dẫn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--== End Testimonial Item ==-->

                                <!-- Các mục đánh giá tiếp theo -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author">
                                                <div class="testi-thumb">
                                                    <img src="../client/assets/img/testimonial/2.webp" width="75"
                                                        height="75" alt="Hình ảnh khách hàng">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Assunta Manson</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">Đây là một sự thật rằng người đọc thường bị xao nhãng bởi
                                                    bố cục của trang khi xem nội dung có thể đọc được có sự phân bố chữ cái
                                                    gần như bình thường.</p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp"
                                                        alt="Trích dẫn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author">
                                                <div class="testi-thumb">
                                                    <img src="../client/assets/img/testimonial/3.webp" width="75"
                                                        height="75" alt="Hình ảnh khách hàng">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Amira Shepard</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">Đây là một sự thật rằng người đọc thường bị xao nhãng bởi
                                                    bố cục của trang khi xem nội dung có thể đọc được có sự phân bố chữ cái
                                                    gần như bình thường.</p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp"
                                                        alt="Trích dẫn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author">
                                                <div class="testi-thumb">
                                                    <img src="../client/assets/img/testimonial/4.webp" width="75"
                                                        height="75" alt="Hình ảnh khách hàng">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Joshua George</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">Đây là một sự thật rằng người đọc thường bị xao nhãng bởi
                                                    bố cục của trang khi xem nội dung có thể đọc được có sự phân bố chữ cái
                                                    gần như bình thường.</p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp"
                                                        alt="Trích dẫn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author">
                                                <div class="testi-thumb">
                                                    <img src="../client/assets/img/testimonial/5.webp" width="75"
                                                        height="75" alt="Hình ảnh khách hàng">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Rosie Patton</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">Đây là một sự thật rằng người đọc thường bị xao nhãng bởi
                                                    bố cục của trang khi xem nội dung có thể đọc được có sự phân bố chữ cái
                                                    gần như bình thường.</p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i><i class="icofont-star"></i><i
                                                        class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp"
                                                        alt="Trích dẫn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--== End Testimonial Items ==-->

                            </div>
                            <!--== Swiper Pagination ==-->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Testimonial Area Wrapper ==-->

        <!--== Start Blog Area Wrapper ==-->
        <section class="blog-area blog-home-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title">Bài viết mới nhất</h3>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center post-home-style row-gutter-40">
                    <div class="col-md-6 col-lg-4" data-aos="fade-right">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/1.webp"
                                        alt="Hình ảnh bài viết" width="370" height="270"></a>
                            </div>
                            <div class="content">
                                <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                <h4 class="title"><a href="blog-details.html">Một sự thật lâu đời rằng người đọc sẽ dễ bị
                                        phân tâm bởi nội dung dễ đọc.</a></h4>
                                <div class="meta">
                                    <span class="post-date">03 Tháng 4, 2022</span>
                                    <span class="dots"></span>
                                    <span class="post-time">10 phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-left">
                        <!--== Start Blog Post Item ==-->
                        <div class="post-item">
                            <div class="thumb mb--0">
                                <a href="blog-details.html"><img src="../client/assets/img/blog/h1.webp"
                                        alt="Hình ảnh bài viết" width="370" height="440"></a>
                            </div>
                        </div>
                        <!--== End Blog Post Item ==-->
                    </div>
                    <div class="col-lg-4" data-aos="fade-left">
                        <div class="post-home-list-style">
                            <!--== Start Blog Post Item ==-->
                            <div class="post-item">
                                <div class="content">
                                    <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                    <h4 class="title"><a href="blog-details.html">Một sự thật được thừa nhận rằng người
                                            đọc sẽ dễ bị phân tâm bởi nội dung dễ đọc.</a></h4>
                                    <div class="meta">
                                        <span class="post-date">03 Tháng 4, 2022</span>
                                        <span class="dots"></span>
                                        <span class="post-time">10 phút đọc</span>
                                    </div>
                                </div>
                            </div>
                            <!--== End Blog Post Item ==-->

                            <!--== Start Blog Post Item ==-->
                            <div class="post-item">
                                <div class="content">
                                    <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                                    <h4 class="title"><a href="blog-details.html">Với giao diện kéo-thả của WooLentor
                                            giúp tạo nội dung dễ dàng...</a></h4>
                                    <div class="meta">
                                        <span class="post-date">03 Tháng 4, 2022</span>
                                        <span class="dots"></span>
                                        <span class="post-time">10 phút đọc</span>
                                    </div>
                                </div>
                            </div>
                            <!--== End Blog Post Item ==-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Blog Area Wrapper ==-->
    </main>
@endsection
