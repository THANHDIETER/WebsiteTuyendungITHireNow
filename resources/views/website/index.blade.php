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

    .section-title {
        font-size: 2rem;
        background: linear-gradient(90deg, #0d6efd, #6610f2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
        position: relative;
    }

    .section-title::after {
        content: "";
        display: block;
        width: 60px;
        height: 4px;
        margin: 8px auto 0;
        border-radius: 2px;
        background: linear-gradient(90deg, #0d6efd, #6610f2);
        animation: growLine 1s ease forwards;
    }

    @keyframes growLine {
        from {
            width: 0;
            opacity: 0;
        }

        to {
            width: 60px;
            opacity: 1;
        }
    }
</style>
@endpush
@section('content')
<main class="main-content">
    <section class="home-slider-area ">
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
    <div id="vue-wrapper"
     data-user-role="{{ Auth::check() ? Auth::user()->role : 'guest' }}"
     style="margin-top: -80px;">
    <job-list></job-list>
</div>

    <!--== Start Job Category Area Wrapper ==-->
    <section class="job-category-area bg-light">
        <div class="container" data-aos="fade-up " style="margin-top: -110px;">
            {{-- Tiêu đề --}}
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fw-bold section-title mb-2">
                        <i class="bi bi-stars text-warning me-2"></i>
                        Ngành nghề nổi bật
                    </h2>
                    <p class="text-muted fs-5">
                        Khám phá các lĩnh vực đang được tuyển dụng nhiều nhất
                    </p>
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
                            <a href="{{ route('jobs.index', ['category_id' => $category->id]) }}"
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
async function handleFavorite(jobId, btnEl = null) {
    try {
        const response = await fetch(`/favorites/${jobId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Nếu gọi từ Blade → có btnEl
            if (btnEl) {
                const icon = btnEl.querySelector('i');
                if (btnEl.classList.contains('btn-danger')) {
                    btnEl.classList.remove('btn-danger');
                    btnEl.classList.add('btn-outline-secondary');
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                } else {
                    btnEl.classList.remove('btn-outline-secondary');
                    btnEl.classList.add('btn-danger');
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                }
            }
            return data; // Vue sẽ nhận data này
        } else {
            throw new Error(data.message || "Lỗi không xác định");
        }
    } catch (err) {
        throw err;
    }
}

// Gắn event cho Blade
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.save-job-btn');
    if (!btn || !btn.dataset.jobId) return;
    handleFavorite(btn.dataset.jobId, btn)
        .then(data => alert(data.message))
        .catch(() => alert('Bạn cần đăng nhập để lưu việc làm.'));
});
</script>

@endsection