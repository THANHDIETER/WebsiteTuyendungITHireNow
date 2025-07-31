@extends('website.layouts.master')

@section('content')

<main class="main-content">

    <!--== Bắt đầu header trang ==-->
    <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/banner/15.png">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="job-search-wrap">
                        <div class="job-search-form">
                            <form action="#">
                                <div class="row row-gutter-10">
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Tiêu đề việc làm hoặc từ khóa">
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option selected>Chọn Thành Phố</option>
                                                <option>Hà Nội</option>
                                                <option>Hồ Chí Minh</option>
                                                <option>Đà Nẵng</option>
                                                <option>Huế</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option selected>Loại Công Việc</option>
                                                <option>Web Designer</option>
                                                <option>Web Developer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <button type="submit" class="btn-form-search"><i class="icofont-search-1"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD

=======
>>>>>>> 45aff071f646e7291ddfc422a2b5dd7f837f012b

        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area recent-job-inner-area">
            <div class="container">
                <div class="row g-4">
                    @forelse($jobs as $job)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="job-card rounded-3 p-3 h-100 position-relative animate__animated animate__fadeInUp
                                {{ $job->is_featured ? 'job-featured-card' : '' }}"
                                style="min-height: 380px; background: linear-gradient(135deg, #e3f2fd 0%, #f1f8e9 100%); border: 1px solid #dee2e6; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; overflow: hidden;">

                                {{-- Ribbon “NỔI BẬT” góc trên bên trái --}}
                                @if ($job->is_featured)
                                    <div class="featured-ribbon">
                                        <span>🌟 NỔI BẬT</span>
                                    </div>
                                @endif

                                {{-- Ảnh đại diện công việc --}}
                                <div class="job-thumbnail position-relative mb-3">
                                    <a href="{{ route('jobs.show', $job->slug) }}">
                                        <img src="{{ $job->thumbnail ? asset('storage/' . $job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                            alt="{{ $job->title }}" class="img-fluid rounded shadow-sm"
                                            style="max-height: 160px; width: 100%; object-fit: cover; border-radius: 0.5rem;">
                                    </a>
                                </div>

                                <div class="job-details mt-2">
                                    <h4 class="job-title mb-2 text-dark fw-bold">
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-dark text-decoration-none">
                                            {{ $job->title ?: 'Không có tiêu đề' }}
                                        </a>
                                    </h4>
                                    <p class="text-success mb-2 small">
                                        {{ $job->jobType->name ?? ucfirst($job->job_type ?? 'N/A') }}
                                    </p>
                                    <p class="job-desc text-muted mb-3">
                                        {!! $job->description ? Str::limit(strip_tags($job->description), 100) : 'Chưa có mô tả' !!}
                                    </p>
                                    <div class="skills-tags d-flex flex-wrap gap-2 mb-3">
                                        @if ($job->skills->isNotEmpty())
                                            @foreach ($job->skills as $skill)
                                                <span class="badge bg-light text-success small px-2 py-1">{{ $skill->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-light text-muted small px-2 py-1">Không có kỹ năng</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="job-footer d-flex justify-content-between align-items-end mt-auto p-2">
                                    <div class="salary-info">
                                        <h5 class="text-success fw-bold mb-0">
                                            @if ($job->salary_min > 0 || $job->salary_max > 0)
                                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            @else
                                                Thỏa thuận
                                            @endif
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
            </div>
        </section>

        <style>
            .job-featured-card {
                border: 3px solid;
                border-image: linear-gradient(135deg, #ffd700 10%, #ff8177 40%, #b721ff 80%, #21d4fd 100%) 1;
                box-shadow: 0 0 32px 2px #ffd70055, 0 6px 25px rgba(0, 0, 0, 0.10);
                background: linear-gradient(120deg, #fffbe9 0%, #e9faff 100%);
                position: relative;
                z-index: 2;
                animation: cardGlow 2.5s infinite alternate;
            }

            @keyframes cardGlow {
                0% {
                    box-shadow: 0 0 12px 1px #ffd70066;
                }

                100% {
                    box-shadow: 0 0 38px 8px #ffd700aa;
                }
            }

            .featured-ribbon {
                position: absolute;
                left: -32px;
                top: 18px;
                background: linear-gradient(90deg, #ffd700 60%, #ff8177 100%);
                color: #333;
                font-weight: 700;
                font-size: 1rem;
                letter-spacing: 1px;
                padding: 8px 38px 8px 30px;
                transform: rotate(-24deg);
                box-shadow: 0 2px 6px 0 #ffd70044;
                border-radius: 6px;
                z-index: 10;
                animation: ribbonGlow 2s infinite alternate;
            }

            @keyframes ribbonGlow {
                0% {
                    box-shadow: 0 2px 10px 0 #ffd70033;
                }

                100% {
                    box-shadow: 0 4px 20px 4px #ff817799;
                }
            }

            .job-card {
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, #e3f2fd 0%, #f1f8e9 100%);
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
            }

            .job-card:hover {
                transform: translateY(-7px) scale(1.015);
                box-shadow: 0 12px 40px 2px #b0b8d944, 0 8px 30px rgba(0, 0, 0, 0.10);
            }

            .hover-scale {
                transition: all 0.3s ease;
            }

            .hover-scale:hover {
                transform: scale(1.07);
            }

            @media (max-width: 768px) {
                .job-card {
                    min-height: 300px;
                    margin-bottom: 1.5rem;
                }

                .salary-info h5 {
                    font-size: 1.1rem;
                }

                .btn-primary {
                    padding: 0.5rem 1rem;
                }

                .featured-ribbon {
                    font-size: 0.9rem;
                    left: -20px;
                    top: 10px;
                    padding: 7px 28px 7px 18px;
                }
            }
        </style>
    </main>
@endsection
