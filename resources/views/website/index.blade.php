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
                                                <form action="{{ route('jobs.index') }}" method="GET">
                                                    <div class="row row-gutter-10">
                                                        <!-- Từ khóa -->
                                                        <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                            <div class="form-group">
                                                                <input type="text" name="q" class="form-control"
                                                                    placeholder="Tiêu đề việc làm hoặc từ khóa">
                                                            </div>
                                                        </div>
                                                        <!-- Địa điểm -->
                                                        <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                            <div class="form-group">
                                                                <select name="location_id" class="form-control">
                                                                    <option value="">Chọn Thành Phố</option>
                                                                    @foreach (\App\Models\Location::all() as $location)
                                                                        <option value="{{ $location->id }}">
                                                                            {{ $location->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- Loại công việc -->
                                                        <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                            <div class="form-group">
                                                                <select name="job_type_id" class="form-control">
                                                                    <option value="">Loại Công Việc</option>
                                                                    @foreach (\App\Models\JobType::all() as $type)
                                                                        <option value="{{ $type->id }}">
                                                                            {{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- Nút tìm kiếm -->
                                                        <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn-form-search">
                                                                    <i class="icofont-search-1"></i>
                                                                </button>
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
        <section>
            <div class="container " style="margin-top: -70px;">

                {{-- Tiêu đề --}}

                {{-- Tiêu đề và nút "Xem tất cả" --}}
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="fw-bold text-primary mb-0 fs-3">Việc làm tốt nhất</h3>
                    <a href="/cong-viec" class="text-decoration-none small text-primary">Xem tất cả</a>
                </div>

                @php
                    $selectedLocation = request('location');
                    $locations = \App\Models\Location::whereIn('name', [
                        'Hà Nội',
                        'Hồ Chí Minh',
                        'Đà Nẵng',
                        'Cần Thơ',
                    ])->get();
                @endphp

                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach ($locations as $location)
                        <a href="{{ request()->fullUrlWithQuery(['location' => $location->id, 'page' => 1]) }}"
                            class="btn btn-outline-primary rounded-pill btn-sm {{ $selectedLocation == $location->id ? 'active' : '' }}">
                            {{ $location->name }}
                        </a>
                    @endforeach
                    <a href="{{ request()->fullUrlWithQuery(['location' => null, 'page' => 1]) }}"
                        class="btn btn-outline-secondary rounded-pill btn-sm {{ empty($selectedLocation) ? 'active' : '' }}">
                        Tất cả
                    </a>
                </div>


                {{-- Thông báo nếu không có việc làm --}}



                {{-- GỢI Ý VIỆC LÀM --}}
                <div id="job-tips" class="position-relative mb-5" style="min-height: 50px; ">
                    <div class="job-tip alert alert-info d-flex align-items-center gap-2 small rounded-3 fade-tip active">
                        <i class="bi bi-lightbulb-fill text-warning fs-5"></i>
                        <div>💡 Di chuột vào tiêu đề việc làm để xem thêm thông tin chi tiết</div>
                    </div>
                    <div class="job-tip alert alert-secondary d-flex align-items-center gap-2 small rounded-3 fade-tip">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div>🔍 Gợi ý: Bạn có thể lưu việc làm để xem lại sau</div>
                    </div>
                </div>

                {{-- DANH SÁCH VIỆC LÀM --}}
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="row-gap: 2rem;">


                    @forelse($jobs as $job)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-lg shadow-sm rounded-4 p-3 position-relative">

                                {{-- Tag TOP / PRO --}}
                                @if ($job->is_featured)
                                    <span class="badge bg-success position-absolute top-0 start-0 m-2">TOP</span>
                                @endif
                                @if ($job->is_paid)
                                    <span class="badge badge-hot position-absolute top-0 end-0 m-2">HOT</span>
                                @endif


                                {{-- Nội dung thẻ --}}
                                <div class="d-flex flex-column h-100 gap-2">


                                    {{-- Logo công ty --}}
                                    <div class="text-center mb-3">
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="d-inline-block"
                                            style="width: 70px; height: 70px;">
                                            <img src="{{ $job->company?->logo_url ?? asset('assets/img/default-logo.png') }}"
                                                alt="{{ $job->company?->name ?? 'Company Logo' }}"
                                                class="img-fluid rounded-circle border p-1 bg-white shadow-sm"
                                                style="width:100%; height:100%; object-fit:contain;">
                                        </a>
                                    </div>

                                    @php
                                        $titleTooltip = $job->title . ' - ' . strip_tags($job->description);
                                        $titleTooltip = \Illuminate\Support\Str::limit($titleTooltip, 200);
                                    @endphp

                                    <h6 class="job-title fw-semibold mb-1">
                                        <a href="{{ route('jobs.show', $job->slug) }}"
                                            class="d-inline-flex align-items-center gap-1 text-decoration-none text-dark"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $titleTooltip }}">
                                            <i class="bi bi-briefcase-fill text-primary small"></i>
                                            <span class="text-truncate" style="max-width: 100%;">
                                                {{ $job->title }}
                                            </span>
                                        </a>
                                    </h6>






                                    {{-- Tên công ty --}}
                                    <div class="text-muted small">
                                        {{ $job->company->name ?? 'Công ty không xác định' }}
                                    </div>

                                    {{-- Mức lương --}}
                                    <div class="fw-semibold text-primary small">
                                        @if ($job->salary_negotiable)
                                            Thỏa thuận
                                        @else
                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            {{ $job->currency }}
                                        @endif
                                    </div>

                                    {{-- Địa chỉ --}}
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        {{ $job->address ?? 'Không rõ địa chỉ' }}
                                    </div>
                                    @php
                                        $isFavorited =
                                            auth()->check() && auth()->user()->favoriteJobs->contains($job->id);
                                    @endphp

                                    <div class="mt-auto text-end">
                                        <button type="button"
                                            class="btn btn-sm rounded-circle save-job-btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-secondary' }}"
                                            data-job-id="{{ $job->id }}" title="Lưu việc làm">
                                            <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">Không có việc làm nào được hiển thị.</div>
                    @endforelse
                </div>

                {{-- PHÂN TRANG --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $jobs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

        @section('scripts')
            <script>
                document.addEventListener('click', async function(e) {
                    const btn = e.target.closest('.save-job-btn');
                    if (!btn) return;

                    console.log('✅ Click nút lưu thành công:', btn.dataset.jobId); // Thêm dòng debug này

                    const jobId = btn.dataset.jobId;
                    const icon = btn.querySelector('i');

                    try {
                        const response = await fetch(`/favorites/${jobId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            btn.classList.remove('btn-outline-secondary');
                            btn.classList.add('btn-danger');
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                            alert(data.message);
                        } else {
                            alert(data.message || 'Lỗi không xác định');
                        }
                    } catch (err) {
                        alert('Bạn cần đăng nhập để lưu việc làm.');
                    }
                });
                document.addEventListener('DOMContentLoaded', () => {
                    const tips = document.querySelectorAll('.job-tip');
                    let index = 0;

                    const showTip = (i) => {
                        tips.forEach((tip, idx) => {
                            tip.classList.remove('active');
                        });
                        tips[i].classList.add('active');
                    };

                    showTip(index);

                    setInterval(() => {
                        index = (index + 1) % tips.length;
                        showTip(index);
                    }, 5000);
                });
                document.addEventListener('DOMContentLoaded', function() {
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                        new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>
        @endsection

        <style>
            .job-card {
                transition: all 0.3s ease;
            }

            .job-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            }

            .job-card .badge {
                font-size: 0.75rem;
            }

            .job-title {
                font-size: 1.1rem;
                line-height: 1.5;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .job-title a {
                transition: color 0.3s ease, text-decoration 0.3s ease;
            }

            .job-title a:hover {
                color: #0d6efd;
                /* màu xanh Bootstrap */
                text-decoration: underline;
            }


            .job-tip {
                transition: opacity 0.5s ease, transform 0.5s ease;
                opacity: 0;
                transform: translateY(10px);
                display: block;
                /* giữ block để transition hoạt động */
                position: absolute;
                width: 100%;
            }

            .job-tip.active {
                opacity: 1;
                transform: translateY(0);
                position: static;
            }

            #job-tips {
                position: relative;
                min-height: 60px;
                /* để không bị giật layout khi ẩn/hiện */
            }

            .fade-tip {
                opacity: 0;
                transform: translateY(10px);
                transition: all 0.4s ease;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            .badge-hot {
                background: linear-gradient(135deg, #ff6a00, #ffca28);
                /* Gradient cam đến vàng */
                color: #fff;
                font-weight: bold;
                font-size: 0.8rem;
                padding: 6px 14px;
                border-radius: 999px;
                box-shadow: 0 0 8px rgba(255, 106, 0, 0.5);
                /* đổ bóng cam */
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
                /* đổ bóng chữ */
                letter-spacing: 0.5px;
                animation: pulseHot 1.2s infinite;
            }

            @keyframes pulseHot {
                0% {
                    box-shadow: 0 0 8px rgba(255, 106, 0, 0.6);
                    transform: scale(1);
                }

                50% {
                    box-shadow: 0 0 16px rgba(255, 106, 0, 1);
                    transform: scale(1.05);
                }

                100% {
                    box-shadow: 0 0 8px rgba(255, 106, 0, 0.6);
                    transform: scale(1);
                }
            }


            .fade-tip.active {
                opacity: 1;
                transform: translateY(0);
                position: relative;
            }

            .category-card {
                transition: all 0.3s ease-in-out;
            }

            .category-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
                background-color: #f8f9fa;
            }

            .category-card .icon i {
                transition: color 0.3s;
            }

            .category-card:hover .icon i {
                color: #0d6efd;
            }
        </style>



        <!--== Start Job Category Area Wrapper ==-->
        <section class="job-category-area py-5 bg-light">
            <div class="container" data-aos="fade-up " style="margin-top: -70px;">
                {{-- Tiêu đề --}}
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h2 class="fw-bold text-primary mb-2">Ngành nghề nổi bật</h2>
                        <p class="text-muted mb-0">Khám phá các lĩnh vực đang được tuyển dụng nhiều nhất</p>
                    </div>
                </div>

                {{-- Danh sách ngành nghề --}}
                <div class="row g-3 g-md-4 " style="row-gap: 2rem;">
                    @forelse($categories as $category)
                        @php
                            $icons = [
                                'CNTT' => 'bi-laptop',
                                'Marketing' => 'bi-bar-chart',
                                'Kế toán' => 'bi-calculator',
                                'Xây dựng' => 'bi-hammer',
                                'Giáo dục' => 'bi-journal-bookmark',
                                'Bán hàng' => 'bi-cart',
                                'Nhân sự' => 'bi-people',
                                'default' => 'bi-briefcase-fill',
                            ];
                            $icon = $icons[$category->name] ?? $icons['default'];
                        @endphp

                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div
                                class="category-card p-4 bg-white rounded-4 shadow-sm h-100 position-relative text-center">
                                <div class="icon text-primary mb-3">
                                    <i class="bi {{ $icon }} fs-2"></i>
                                </div>
                                <h6 class="fw-semibold mb-1 text-truncate">
                                    <a href="{{ route('jobs.index', ['category' => $category->id]) }}"
                                        class="stretched-link text-decoration-none text-dark">
                                        {{ $category->name }}
                                    </a>
                                </h6>
                                <div class="text-muted small">({{ $category->jobs_count }} việc làm)</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">Chưa có ngành nghề nào được thêm.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>


        <!--== End Job Category Area Wrapper ==-->

        <!--== Start Recent Job Area Wrapper ==-->
        <section class="recent-job-area bg-light py-5">
            <div class="container" data-aos="fade-up">
                {{-- Tiêu đề --}}
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h2 class="fw-bold text-primary mb-2">Việc làm mới nhất</h2>
                        <p class="text-muted">Cơ hội nghề nghiệp hấp dẫn được cập nhật liên tục</p>
                    </div>
                </div>

                {{-- Danh sách việc làm --}}
                <div class="row g-4 " style="row-gap: 2rem;">
                    @forelse($jobs as $job)
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="card job-card shadow-sm border-0 h-100 rounded-4 overflow-hidden position-relative p-4 bg-white">
                                {{-- Gắn tag Featured --}}
                                @if ($job->is_featured)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3">NỔI BẬT</span>
                                @endif

                                {{-- Logo công ty --}}
                                <div class="text-center mb-3">
                                    <a href="{{ route('jobs.show', $job->slug) }}" class="d-inline-block"
                                        style="width: 70px; height: 70px;">
                                        <img src="{{ $job->company?->logo_url ?? asset('assets/img/default-logo.png') }}"
                                            alt="{{ $job->company?->name ?? 'Company Logo' }}"
                                            class="img-fluid rounded-circle border p-1 bg-white shadow-sm"
                                            style="width:100%; height:100%; object-fit:contain;">
                                    </a>
                                </div>



                                {{-- Nội dung việc làm --}}
                                <div class="job-content d-flex flex-column h-100">
                                    {{-- Tên công ty --}}
                                    <h6 class="text-muted small text-center mb-1">
                                        {{ $job->company->name ?? 'Công ty không xác định' }}
                                    </h6>

                                    {{-- Tiêu đề công việc --}}
                                    <h5 class="fw-bold text-center mb-2">
                                        <a href="{{ route('jobs.show', $job->slug) }}"
                                            class="text-dark text-decoration-none" title="{{ $job->title }}">
                                            {{ $job->title }}
                                        </a>
                                    </h5>

                                    {{-- Hình thức làm việc --}}
                                    @if ($job->job_type)
                                        <div class="text-center mb-2">
                                            <span class="badge bg-light text-primary border px-2 py-1">
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Mô tả ngắn --}}
                                    <p class="small text-secondary text-center mb-3 px-2">
                                        {{ Str::limit(strip_tags($job->description), 90) }}
                                    </p>

                                    {{-- Kỹ năng --}}
                                    <div class="skills d-flex flex-wrap justify-content-center gap-2 mb-3">
                                        @forelse($job->skills ?? [] as $skill)
                                            <span class="badge bg-info-subtle text-info small">{{ $skill->name }}</span>
                                        @empty
                                            <span class="badge bg-secondary-subtle text-secondary small">Không có kỹ
                                                năng</span>
                                        @endforelse
                                    </div>

                                    {{-- Mức lương & nút --}}
                                    <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-3">
                                        <div>
                                            <div class="fw-semibold text-success small">
                                                {{ number_format($job->salary_min) }} -
                                                {{ number_format($job->salary_max) }}
                                            </div>
                                            <small class="text-muted">{{ $job->currency ?? 'VND' }}/tháng</small>
                                        </div>
                                        <a href="{{ route('jobs.show', $job->slug) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">Hiện chưa có việc làm nào được đăng.</div>
                    @endforelse
                </div>
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
