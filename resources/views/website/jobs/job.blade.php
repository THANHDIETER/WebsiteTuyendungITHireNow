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
                                                <input type="text" class="form-control"
                                                    placeholder="Tiêu đề việc làm hoặc từ khóa">
                                            </div>
                                        </div>
                                        <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option selected>Chọn Thành Phố</option>
                                                    <option>Hà Nội</option>
                                                    <option>Hồ Chí Minh</option>
                                                    <option>Đà Nẵng</option>
                                                    <option>Huế </option>
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
                                                <button type="submit" class="btn-form-search"><i
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

    <!--== Bắt đầu danh sách việc làm ==-->
    <section class="recent-job-area recent-job-inner-area">
        <div class="container">
            <div class="row g-4">
                @forelse($jobs as $job)
<div class="col-md-6 col-lg-4 mb-4">
    <div class="job-card rounded-3 p-3 h-100 position-relative animate__animated animate__fadeInUp {{ $job->is_featured ? 'job-featured-border' : '' }}"
        style="min-height: 380px; background: linear-gradient(135deg, #e3f2fd 0%, #f1f8e9 100%); border: 1px solid {{ $job->is_featured ? '#ff0000' : '#dee2e6' }}; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; overflow: visible;">
        @if($job->is_featured)
            <span class="badge-hot-ithirenow position-absolute" style="z-index:10; left: -18px; top: -18px;">HOT</span>
        @endif
        {{-- Ảnh đại diện của công việc --}}
        <div class="job-thumbnail position-relative mb-3">
            <a href="{{ route('jobs.show', $job->slug) }}">
                <img src="{{ $job->thumbnail ? asset('storage/' . $job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                     alt="{{ $job->title }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 160px; width: 100%; object-fit: cover; border-radius: 0.5rem;">
            </a>

                                {{-- Ảnh đại diện của công việc --}}
                                <div class="job-thumbnail position-relative mb-3">
                                    <a href="{{ route('jobs.show', $job->slug) }}">
                                        <img src="{{ $job->thumbnail ? asset('storage/' . $job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                            alt="{{ $job->title }}" class="img-fluid rounded shadow-sm"
                                            style="max-height: 160px; width: 100%; object-fit: cover; border-radius: 0.5rem;">
                                    </a>

                                    {{-- Logo công ty --}}
                                    @if ($job->company)
                                        <div class="company-logo-overlay position-absolute top-0 start-0 m-2">
                                            <img src="{{ $job->company->logo_url ?? asset('client/assets/img/companies/1.webp') }}"
                                                width="50" height="50" class="rounded-circle border bg-white p-1 shadow"
                                                alt="{{ $job->company->name }}">
                                        </div>
                                    @endif
                                </div>

                                {{-- Thông tin chi tiết công việc --}}
                                <div class="job-details mt-2">
                                    <h4 class="job-title mb-2 text-dark fw-bold">
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-dark text-decoration-none">
                                            {{ $job->title ?: 'Không có tiêu đề' }}
                                        </a>
                                    </h4>

                                    {{-- Loại công việc --}}
                                    <p class="text-success mb-2 small">
                                        {{ $job->jobType->name ?? ucfirst($job->job_type ?? 'N/A') }}
                                    </p>

                                    {{-- Mô tả ngắn --}}
                                    <p class="job-desc text-muted mb-3">
                                        {!! $job->description ? Str::limit(strip_tags($job->description), 100) : 'Chưa có mô tả' !!}
                                    </p>

                                    {{-- Kỹ năng --}}
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

                                {{-- Chân thẻ công việc: lương + nút --}}
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
            .job-card {
                position: relative;
                overflow: hidden;
            }

            .job-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }

            .hover-scale {
                transition: all 0.3s ease;
            }

            .hover-scale:hover {
                transform: scale(1.05);
            }

            .job-featured-border {
                border: 2px solid #ff0000 !important;
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
    </main>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> Thanh-Tu
