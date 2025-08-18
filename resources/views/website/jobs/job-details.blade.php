@extends('website.layouts.master')

@section('content')
 <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>
<main class="main-content">
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
                    <div
                        class="job-details-wrap d-flex justify-content-between align-items-center flex-wrap border rounded p-4 shadow-sm">
                        {{-- Logo công ty --}}
                        <div class="job-details-info d-flex align-items-center">
                            <div class="thumb me-4">
                                <img src="{{ $job->company->logo_url ?? asset('client/assets/img/companies/default-logo.webp') }}"
                                    width="130" height="130" alt="Logo {{ $job->company->name ?? 'Công ty' }}">
                            </div>

                            {{-- Tiêu đề + công ty + thông tin --}}
                            <div class="content">
                                <h4 class="title mb-1">{{ $job->title }}</h4>
                                <h5 class="sub-title mb-2">{{ $job->company->name ?? 'Tên công ty' }}</h5>
                                <ul class="info-list list-unstyled d-flex flex-wrap gap-3">
                                    <li><i class="icofont-location-pin me-1"></i>
                                        {{ optional($job->location)->name ?? 'N/A' }}
                                    </li>
                                    <li><i class="icofont-phone me-1"></i> {{ $job->company->phone ?? 'N/A' }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Mức lương + hình thức làm việc --}}
                        <div class="job-details-price text-end mt-3 mt-md-0">
                            @if ($job->salary_min && $job->salary_max)
                            <h4 class="fw-bold mb-1" style="color: #0d6efd;">
                                {{ number_format($job->salary_min, 0, '.', ',') }} -
                                {{ number_format($job->salary_max, 0, '.', ',') }}
                                <span style="text-transform: uppercase">{{ $job->currency }}</span>
                                <small class="text-muted fs-6">/tháng</small>
                            </h4>
                            @else
                            <h4 class="text-muted mb-1">Lương thỏa thuận</h4>
                            @endif

                            @if ($job->jobType)
                            <p class="text-muted mb-0 d-flex align-items-center justify-content-end">
                                <i class="icofont-briefcase me-1 fs-5 text-secondary"></i>
                                <span>{{ $job->jobType->name }}</span>
                            </p>
                            @endif

                            <button type="button" class="btn btn-apply-now btn-success mt-3" data-bs-toggle="modal"
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
                            <div class="desc job-content">
                                {!! $job->description !!}
                            </div>
                        </div>

                        <div class="content">
                            <h4 class="title">Yêu cầu</h4>
                            <div class="desc job-content">
                                {!! $job->requirements !!}
                            </div>
                        </div>



                        <div class="content">
                            <h4 class="title">Phúc lợi</h4>
                            <div class="desc job-content">
                                @php
                                $benefits = [];

                                if (!empty($job->benefits)) {
                                if (is_array($job->benefits)) {
                                $benefits = $job->benefits;
                                } elseif (is_string($job->benefits)) {
                                // Tách theo dòng \r\n hoặc \n
                                $benefits = preg_split('/\r\n|\n|\r/', $job->benefits);
                                }
                                }
                                @endphp

                                @if (!empty($benefits))
                                <ul class="job-details-list">
                                    @foreach ($benefits as $benefit)
                                    @if (trim($benefit) !== '')
                                    <li><i class="icofont-check"></i> {{ $benefit }}</li>
                                    @endif
                                    @endforeach
                                </ul>
                                @else
                                <p class="desc">Không có thông tin phúc lợi.</p>
                                @endif
                            </div>
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
                                            <td>{{ $job->jobType->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Mức lương</td>
                                            <td class="dotted">:</td>
                                            <td>
                                                @if ($job->salary_min && $job->salary_max)
                                                {{ number_format($job->salary_min) }} -
                                                {{ number_format($job->salary_max) }}
                                                {{ $job->currency ?? 'VND' }}
                                                @elseif ($job->salary_min)
                                                Từ {{ number_format($job->salary_min) }}
                                                {{ $job->currency ?? 'VND' }}
                                                @elseif ($job->salary_max)
                                                Lên đến {{ number_format($job->salary_max) }}
                                                {{ $job->currency ?? 'VND' }}
                                                @else
                                                Thỏa thuận
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Địa chỉ</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Chính sách làm việc từ xa</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->remotePolicy->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Cấp bậc</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->level->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Kinh nghiệm</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->experience->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Ngôn ngữ</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->language->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Ngày đăng</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->created_at ? $job->created_at->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-name">Hạn nộp hồ sơ</td>
                                            <td class="dotted">:</td>
                                            <td>{{ $job->deadline ? $job->deadline->format('d/m/Y') : '-' }}</td>
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
    <section class="related-jobs-area " style="background: linear-gradient(135deg, #f0f4ff, #e8f0fe);">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="title section-title border-bottom pb-2 d-inline-block">Công việc liên quan</h3>
                </div>
            </div>
            @if ($relatedJobs->count() > 0)
            <div id="relatedJobsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($relatedJobs->chunk(2) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach ($chunk as $relatedJob)
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow rounded-4 overflow-hidden bg-white">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ $relatedJob->thumbnail ? asset('storage/' . $relatedJob->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                                alt="{{ $relatedJob->title }}" width="100"
                                                height="100"
                                                class="img-fluid rounded-start object-fit-cover m-3">
                                        </div>
                                        <div class="col">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1 text-dark fw-bold">
                                                    {{ $relatedJob->title }}
                                                </h5>
                                                <p class="mb-1 text-muted small fw-semibold">
                                                    {{ $relatedJob->company->name }}
                                                </p>
                                                <ul class="list-unstyled small text-muted mb-0">
                                                    <li><i
                                                            class="icofont-location-pin me-1"></i>{{ $relatedJob->location ?? 'N/A' }}
                                                    </li>
                                                    <li><i
                                                            class="icofont-money-bag me-1"></i>{{ number_format($relatedJob->salary_min) }}
                                                        - {{ number_format($relatedJob->salary_max) }}đ
                                                    </li>
                                                    <li><i
                                                            class="icofont-clock-time me-1"></i>{{ ucfirst($relatedJob->job_type) }}
                                                    </li>
                                                    <li><i class="icofont-calendar me-1"></i>Hạn nộp:
                                                        {{ optional($relatedJob->deadline)->format('d/m/Y') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @if ($relatedJobs->count() > 2)
                <button class="carousel-control-prev" type="button" data-bs-target="#relatedJobsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#relatedJobsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
            @else
            <div class="alert alert-info text-center">
                Không có công việc liên quan nào.
            </div>
            @endif
        </div>
    </section>



    <!--== Kết thúc công việc liên quan ==-->
</main>

<!-- Modal Form Nộp CV -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="applyModalLabel">Nộp đơn ứng tuyển</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body">
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data"
                    id="applyForm">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                            name="full_name" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                        @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', Auth::user()->phone_number ?? '') }}" required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Chọn CV --}}
                    <div class="mb-3">
                        <label class="form-label d-block">Chọn CV</label>

                        @if($cvs->count() > 0)
                        {{-- Radio chọn cách nộp --}}
                        <div class="d-flex gap-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_saved"
                                    value="saved" checked>
                                <label class="form-check-label" for="cv_choice_saved">Dùng CV đã lưu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_upload"
                                    value="upload">
                                <label class="form-check-label" for="cv_choice_upload">Tải CV mới</label>
                            </div>
                        </div>

                        {{-- Nhóm select CV đã có --}}
                        <div id="cv_saved_group" class="mb-2">
                            <select name="cv_id" id="cv_id" class="form-select">
                                <option value="">-- Chọn CV từ hồ sơ của bạn --</option>
                                @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}">{{ $cv->title ?? basename($cv->file_path) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nhóm upload file (ẩn mặc định) --}}
                        <div id="cv_upload_group" class="mb-2 d-none">
                            <input type="file" name="cv_file" id="cv_file" class="form-control"
                                accept="application/pdf">
                            <div class="form-text">Tải file PDF (tối đa 2MB).</div>
                        </div>
                        @else
                        {{-- Không có CV trong hệ thống -> bắt buộc upload --}}
                        <input type="hidden" name="cv_choice" value="upload">
                        <input type="file" name="cv_file" id="cv_file" class="form-control" accept="application/pdf"
                            required>
                        <div class="form-text">Bạn chưa có CV trong hệ thống, vui lòng upload file PDF (tối đa 2MB).
                        </div>
                        @endif

                    </div>


                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">Thư giới thiệu (không bắt buộc)</label>
                        <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter"
                            name="cover_letter" rows="4"
                            placeholder="Giới thiệu ngắn gọn về kinh nghiệm, thành tích và lý do phù hợp với vị trí này...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                            <i class="bi bi-send"></i> Gửi đơn ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div> {{-- /modal-content --}}
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }

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
        border-bottom: 2px solid #0da1f0;
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
        color: #0da1f0;
    }

    .company-name {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
    }


    .widget-item {
        margin-left: 20px;
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
        color: #0da1f0;
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

    .job-content p b,
    .job-content p strong,
    .job-content h5 {
        display: block;
        margin-left: 2ch;
        font-weight: bold;
    }

    .job-content ul {
        padding-left: 4ch;
        margin-bottom: 1rem;
    }

    .job-content ul li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .job-details-wrap .title {
        color: #0da1f0;
        font-weight: 600;
    }



    .job-details-wrap .info-list i {
        color: #0da1f0;
    }

    .btn-theme {
        background-color: #0da1f0;
        border: none;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-theme:hover {
        background-color: #0da1f0;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset form khi đóng modal
        const applyModal = document.getElementById('applyModal');
        if (applyModal) {
            applyModal.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('applyForm');
                if (form) form.reset();
            });
        }

        const savedRadio = document.getElementById('cv_choice_saved');
        const uploadRadio = document.getElementById('cv_choice_upload');
        const savedGroup = document.getElementById('cv_saved_group');
        const uploadGroup = document.getElementById('cv_upload_group');
        const cvSelect = document.getElementById('cv_id');
        const cvFile = document.getElementById('cv_file');

        function toggleCVInput() {
            if (savedRadio && savedRadio.checked) {
                // Hiện select CV đã lưu
                savedGroup.classList.remove('d-none');
                uploadGroup.classList.add('d-none');

                if (cvSelect) cvSelect.setAttribute('required', 'required');
                if (cvFile) cvFile.removeAttribute('required');
            } else if (uploadRadio && uploadRadio.checked) {
                // Hiện upload CV mới
                savedGroup.classList.add('d-none');
                uploadGroup.classList.remove('d-none');

                if (cvSelect) {
                    cvSelect.removeAttribute('required');
                    cvSelect.value = '';
                }
                if (cvFile) cvFile.setAttribute('required', 'required');
            }
        }

        if (savedRadio) savedRadio.addEventListener('change', toggleCVInput);
        if (uploadRadio) uploadRadio.addEventListener('change', toggleCVInput);
        toggleCVInput(); // chạy lần đầu

        // Giới hạn file 2MB
        if (cvFile) {
            cvFile.addEventListener('change', function() {
                const f = this.files?.[0];
                if (f && f.size > 2 * 1024 * 1024) {
                    alert('File quá lớn (tối đa 2MB). Vui lòng chọn file khác.');
                    this.value = '';
                }
            });
        }

        // Swipe support cho carousel trên mobile
        const carouselEl = document.getElementById('relatedJobsCarousel');
        if (carouselEl) {
            let startX = 0;
            carouselEl.addEventListener('touchstart', (e) => {
                startX = e.changedTouches[0].screenX;
            });
            carouselEl.addEventListener('touchend', (e) => {
                const endX = e.changedTouches[0].screenX;
                if (Math.abs(endX - startX) > 50) {
                    const dir = endX < startX ? 'next' : 'prev';
                    const c = bootstrap.Carousel.getOrCreateInstance(carouselEl);
                    c[dir]();
                }
            });
        }
    });
</script>
@endpush