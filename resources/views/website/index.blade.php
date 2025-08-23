@extends('website.layouts.master')
@push('styles')
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
@endpush
@section('content')
<main class="main-content">
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
                                                                placeholder="Tiêu đề việc làm hoặc từ khóa"
                                                                value="{{ request('q') }}"
                                                                aria-label="Tìm theo tiêu đề việc làm hoặc từ khóa">
                                                        </div>
                                                    </div>

                                                    <!-- Địa điểm -->
                                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                        <div class="form-group">
                                                            <select name="location_id" class="form-control"
                                                                aria-label="Chọn Thành Phố">
                                                                <option value="">Chọn Thành Phố</option>
                                                                @foreach (\App\Models\Location::orderBy('name')->get() as $location)
                                                                <option value="{{ $location->id }}"
                                                                    @selected((string) request('location_id')===(string) $location->id)>
                                                                    {{ $location->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Loại công việc -->
                                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                        <div class="form-group">
                                                            <select name="job_type_id" class="form-control"
                                                                aria-label="Chọn Loại Công Việc">
                                                                <option value="">Loại Công Việc</option>
                                                                @foreach (\App\Models\JobType::orderBy('name')->get() as $type)
                                                                <option value="{{ $type->id }}"
                                                                    @selected((string) request('job_type_id')===(string) $type->id)>
                                                                    {{ $type->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Nút tìm kiếm -->
                                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn-form-search"
                                                                aria-label="Tìm kiếm">
                                                                <i class="bi bi-search"></i>
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
    </section>
    <!--== End Hero Area Wrapper ==-->
    <section>
        <div class="container " style="margin-top: -70px;">
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

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="row-gap: 2rem;">
                @forelse($jobs as $job)
                <div class="col">
                    <div class="card h-100 border-0 shadow-lg shadow-sm rounded-4 p-3 position-relative">
                        @if ($job->is_featured)
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">TOP</span>
                        @endif
                        @if ($job->is_paid)
                        <span class="badge badge-hot position-absolute top-0 end-0 m-2">HOT</span>
                        @endif

                        <div class="d-flex flex-column h-100 gap-2">
                            <div class="text-center mb-3">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="d-inline-block"
                                    style="width: 70px; height: 70px;">
                                    <img src="{{ asset('storage/'.$job->company->logo_url ?? '') }}"
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
                                    <span class="d-inline-block text-wrap ms-2" style="max-width: 100%;">
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
                            $isFavorited = auth()->check() && auth()->user()->favoriteJobs->contains($job->id);
                            @endphp

                            <div class="mt-auto text-end">
                                <hr>

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
            <div class="mt-3 d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </section>

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
            <div class="row g-3 g-md-4 mt-2" style="row-gap: 2rem;">
                @forelse($categories as $category)
                @if ($category->jobs_count > 0)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="category-card p-4 bg-white rounded-4 shadow-sm h-100 position-relative text-center">
                        <div class="icon text-primary mb-3">
                            @if (!empty($category->icon_url))
                            <img src="{{ asset('storage/' . $category->icon_url) }}" alt="icon" class="img-fluid" width="32">
                            @else
                            <i class="bi bi-folder fs-2"></i>
                            @endif
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
                @endif
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Chưa có ngành nghề nào được thêm.</div>
                </div>
                @endforelse
                
            </div>
        </div>
    </section>

    @if(true) @include('website.partial.recent_job') @endif
    @if(false) @include('website.partial.work-process') @endif
    @if(false) @include('website.partial.brand-logo') @endif
    @if(false) @include('website.partial.testimonial') @endif
    @if(false) @include('website.partial.blog-are') @endif

</main>
@endsection
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