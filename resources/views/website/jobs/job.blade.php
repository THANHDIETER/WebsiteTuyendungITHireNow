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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area recent-job-inner-area">
            <div class="container">
                <div class="row g-4">
                    @forelse($jobs as $job)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="job-card rounded-3 p-4 h-100 position-relative animate__animated animate__fadeInUp"
                                style="min-height: 350px; background: linear-gradient(135deg, #e6f0fa 0%, #f0f7f4 100%); border: 1px solid #e0e7ed; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                                <div class="company-logo position-absolute top-0 start-0 p-2">
                                    <a href="{{ route('jobs.show', $job->slug) }}">
                                        @if ($job->company && $job->company->logo_url)
                                            <img src="{{ $job->company->logo_url }}" width="50" height="50"
                                                class="rounded-circle border bg-light p-1"
                                                alt="{{ $job->company->name ?? 'Company Logo' }}">
                                        @else
                                            <img src="../client/assets/img/companies/1.webp" width="50" height="50"
                                                class="rounded-circle border bg-light p-1" alt="Company Logo">
                                        @endif
                                    </a>
                                </div>
                                <div class="job-details mt-5">
                                    <h4 class="job-title mb-2 text-dark fw-bold">
                                        <a href="{{ route('jobs.show', $job->slug) }}"
                                            class="text-dark text-decoration-none">
                                            {{ $job->title ?? 'Không có tiêu đề' }}
                                        </a>
                                    </h4>
                                    <p class="text-success mb-2 small">{{ ucfirst($job->job_type ?? 'N/A') }}</p>
                                    <p class="job-desc text-muted mb-3">{{ Str::limit($job->description ?? '', 100) }}</p>
                                    <div class="skills-tags d-flex flex-wrap gap-2 mb-3">
                                        @if ($job->skills ?? [])
                                            @foreach ($job->skills as $skill)
                                                <span class="badge bg-light text-success small px-2 py-1">
                                                    {{ $skill->name ?? 'Skill' }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-light text-muted small px-2 py-1">Không có kỹ năng</span>
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
                        overflow: hidden;
                    }

                    .job-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
                    }

                    .job-card .job-details,
                    .job-card .job-footer {
                        position: relative;
                        z-index: 2;
                    }

                    .hover-scale {
                        transition: all 0.3s ease;
                    }

                    .hover-scale:hover {
                        transform: scale(1.05);
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
                    }
                </style>
            </div>
        </section>
        <!--== Kết thúc danh sách việc làm ==-->
    </main>
@endsection
