@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/banner/15.png">
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center p-3 rounded shadow-sm fade show"
                role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible d-flex align-items-center p-3 rounded shadow-sm fade show"
                role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!--== Bắt đầu chi tiết công việc ==-->
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
                                    </ul>
                                </div>
                            </div>
                            <div class="job-details-price">
                                <h4 class="title">{{ number_format($job->salary_min) }}đ <span>/tháng</span></h4>
                                <button type="button" class="btn-theme" data-bs-toggle="modal"
                                    data-bs-target="#applyModal">
                                    Ứng tuyển ngay
                                </button>
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
                                    $benefits = is_array($job->benefits)
                                        ? $job->benefits
                                        : json_decode($job->benefits, true);
                                @endphp
                                @if (!empty($benefits))
                                    <ul class="job-details-list">
                                        @foreach ($benefits as $benefit)
                                            <li><i class="icofont-check"></i> {{ $benefit }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="desc">Không có thông tin phúc lợi.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="job-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Thông tin</h3>
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
                                                <td>{{ number_format($job->salary_min) }} -
                                                    {{ number_format($job->salary_max) }} {{ $job->currency }}</td>
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
                                                <td class="dotted">:</td>
                                                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Hạn nộp hồ sơ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->deadline->format('d/m/Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc chi tiết công việc ==-->

        <!--== Bắt đầu công việc liên quan ==-->
        <section class="related-jobs-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h3 class="title">Công việc liên quan</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if($relatedJobs->count() > 0)
                            <div id="relatedJobsCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($relatedJobs->chunk(2) as $chunk)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <div class="row">
                                                @foreach($chunk as $relatedJob)
                                                    <div class="col-md-6">
                                                        <div class="job-card">
                                                            <div class="job-card-header">
                                                                <div class="company-logo">
                                                                    <img src="{{ $relatedJob->company->logo_url ?? '../client/assets/img/companies/10.webp' }}"
                                                                         alt="{{ $relatedJob->company->name }}"
                                                                         width="60" height="60">
                                                                </div>
                                                                <div class="job-info">
                                                                    <h4 class="job-title">
                                                                        <a href="{{ route('jobs.show', $relatedJob->slug) }}">{{ $relatedJob->title }}</a>
                                                                    </h4>
                                                                    <h5 class="company-name">{{ $relatedJob->company->name }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="job-card-body">
                                                                <ul class="job-meta">
                                                                    <li><i class="icofont-location-pin"></i> {{ $relatedJob->location }}</li>
                                                                    <li><i class="icofont-money-bag"></i> {{ number_format($relatedJob->salary_min) }} - {{ number_format($relatedJob->salary_max) }}đ</li>
                                                                    <li><i class="icofont-clock-time"></i> {{ $relatedJob->job_type }}</li>
                                                                    <li><i class="icofont-calendar"></i> Hạn nộp: {{ $relatedJob->deadline->format('d/m/Y') }}</li>
                                                                </ul>
                                                            </div>
                                                            <div class="job-card-footer">
                                                                <a href="{{ route('jobs.show', $relatedJob->slug) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($relatedJobs->count() > 2)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#relatedJobsCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#relatedJobsCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-info">
                                Không có công việc liên quan nào.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc công việc liên quan ==-->
    </main>

    <!-- Modal Form Nộp CV -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Nộp đơn ứng tuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và tên(bắt buộc)</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name ?? '') }}"
                                required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email(bắt buộc)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại(bắt buộc)</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone"
                                value="{{ old('phone', Auth::user()->phone_number ?? '') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cv_file" class="form-label">CV của bạn (PDF)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept=".pdf" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tối đa 5MB, định dạng PDF</small>
                        </div>

                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">Thư giới thiệu (không bắt buộc)</label>
                            <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter"
                                rows="4">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi đơn ứng tuyển</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .related-jobs-area {
            margin-top: -30px;
            padding-top: 0;
            background: #f8f9fa;
            padding-bottom: 50px;
        }

        .section-title {
            margin-bottom: 25px;
        }

        .section-title .title {
            font-size: 1.5rem;
            margin-bottom: 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .job-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .job-card:hover {
            transform: translateY(-5px);
        }

        .job-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .company-logo {
            margin-right: 15px;
        }

        .company-logo img {
            border-radius: 8px;
            object-fit: cover;
        }

        .job-info {
            flex: 1;
        }

        .job-title {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .job-title a {
            color: #333;
            text-decoration: none;
        }

        .job-title a:hover {
            color: #007bff;
        }

        .company-name {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        .job-card-body {
            margin-bottom: 15px;
        }

        .job-meta {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .job-meta li {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .job-meta li i {
            color: #007bff;
            margin-right: 8px;
        }

        .job-card-footer {
            text-align: right;
            margin-top: auto;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background: #007bff;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
        }

        .carousel-control-prev {
            left: -20px;
        }

        .carousel-control-next {
            right: -20px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-inner {
            padding: 10px 0;
        }

        .carousel-item {
            padding: 10px 0;
        }

        .row {
            margin: 0 -10px;
        }

        .col-md-6 {
            padding: 0 10px;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Reset form when modal is closed
        document.getElementById('applyModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
