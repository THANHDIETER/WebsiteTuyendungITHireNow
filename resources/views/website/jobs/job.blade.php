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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('jobs.search') }}" method="GET" class="search-job-form p-5 bg-white shadow-lg rounded-4">
            <div class="row g-3 align-items-end">
                {{-- Từ khóa --}}
                <div class="col-md-4 col-12">
                    <label class="form-label fw-semibold mb-1 text-primary"><i class="bi bi-search me-1"></i>Từ khóa</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-lg"
                        placeholder="Nhập vị trí, kỹ năng, công ty...">
                </div>

                {{-- Địa điểm --}}
                <div class="col-md-2 col-6">
                    <label class="form-label fw-semibold mb-1">Địa điểm</label>
                    <select name="location_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}"
                                {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Ngành nghề --}}
                <div class="col-md-2 col-6">
                    <label class="form-label fw-semibold mb-1">Ngành nghề</label>
                    <select name="category_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Công ty --}}
                <div class="col-md-2 col-6">
                    <label class="form-label fw-semibold mb-1">Công ty</label>
                    <select name="company_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Loại việc làm --}}
                <div class="col-md-2 col-6">
                    <label class="form-label fw-semibold mb-1">Loại việc làm</label>
                    <select name="job_type_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach ($jobTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ request('job_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Bộ lọc nâng cao --}}
                <div class="col-12">
                    <a class="text-primary small" data-bs-toggle="collapse" href="#advancedSearch" role="button"
                        aria-expanded="false" aria-controls="advancedSearch">
                        <i class="bi bi-funnel-fill me-1"></i>Lọc nâng cao
                    </a>
                </div>
                <div class="collapse col-12" id="advancedSearch">
                    <div class="row g-3 mt-1">
                        {{-- Cấp bậc --}}
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold mb-1">Cấp bậc</label>
                            <select name="level_id" class="form-select">
                                <option value="">Tất cả</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ request('level_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Kinh nghiệm --}}
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold mb-1">Kinh nghiệm</label>
                            <select name="experience_id" class="form-select">
                                <option value="">Tất cả</option>
                                @foreach ($experiences as $exp)
                                    <option value="{{ $exp->id }}"
                                        {{ request('experience_id') == $exp->id ? 'selected' : '' }}>
                                        {{ $exp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Ngôn ngữ --}}
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold mb-1">Ngôn ngữ</label>
                            <select name="language_id" class="form-select">
                                <option value="">Tất cả</option>
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}"
                                        {{ request('language_id') == $lang->id ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Remote Policy --}}
                        <div class="col-md-2 col-6">
                            <label class="form-label fw-semibold mb-1">Hình thức</label>
                            <select name="remote_policy_id" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="1" {{ request('remote_policy_id') == 1 ? 'selected' : '' }}>Onsite
                                </option>
                                <option value="2" {{ request('remote_policy_id') == 2 ? 'selected' : '' }}>Remote
                                </option>
                                <option value="3" {{ request('remote_policy_id') == 3 ? 'selected' : '' }}>Hybrid
                                </option>
                            </select>
                        </div>
                        {{-- Kỹ năng (đa chọn) --}}
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach ($skills as $skill)
                                @php
                                    $selectedSkills = collect(request('skills', []))
                                        ->map(fn($v) => (string) $v)
                                        ->toArray();
                                @endphp
                                <label
                                    class="btn btn-outline-primary rounded-pill btn-sm m-0
            {{ in_array($skill->id, $selectedSkills) ? 'active-skill' : '' }}"
                                    style="cursor:pointer;">
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" autocomplete="off"
                                        class="d-none" {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }}>
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>



                        {{-- Lương --}}
                        <div class="col-md-1 col-6">
                            <label class="form-label fw-semibold mb-1">Lương từ</label>
                            <input type="number" name="min_salary" class="form-control" placeholder="Từ"
                                value="{{ request('min_salary') }}">
                        </div>
                        <div class="col-md-1 col-6">
                            <label class="form-label fw-semibold mb-1">Đến</label>
                            <input type="number" name="max_salary" class="form-control" placeholder="Đến"
                                value="{{ request('max_salary') }}">
                        </div>
                        {{-- Nổi bật --}}
                        <div class="col-md-1 col-6 d-flex align-items-center">
                            <div class="form-check">
                                <input type="checkbox" name="is_featured" class="form-check-input" value="1"
                                    {{ request('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label small ms-1">Nổi bật</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Nút tìm kiếm --}}
                <div class="col-12 col-md-2 mt-3 mt-md-0 text-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 w-100 w-md-auto">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>


        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area py-5 bg-white">
            <div class="container">
                <div class="row g-4" style="row-gap: 2rem;  ">
                    @forelse($jobs as $job)
                        <div class="col-md-6 col-lg-4">
                            <div class="job-card shadow-sm rounded p-4 h-100 position-relative job-card-custom">

                                {{-- TOP / HOT Badge --}}
                                @if ($job->is_featured)
                                    <span class="badge badge-top position-absolute top-0 start-0 m-2">TOP</span>
                                @endif
                                @if ($job->is_paid)
                                    <span class="badge badge-hot position-absolute top-0 end-0 m-2">HOT</span>
                                @endif

                                {{-- Hình ảnh --}}
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    class="d-block mb-3 overflow-hidden rounded" style="height:160px;">
                                    <img src="{{ $job->thumbnail ? asset('storage/' . $job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                        alt="{{ $job->title }}" style="object-fit: cover; width: 100%; height: 100%;">
                                </a>

                                {{-- Tiêu đề --}}
                                <h5 class="job-title text-truncate mb-2" title="{{ $job->title }}">
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $job->title ?: 'Không có tiêu đề' }}
                                    </a>
                                </h5>

                                {{-- Loại hình --}}
                                <p class="text-success fw-semibold small mb-2">
                                    {{ $job->jobType->name ?? ucfirst($job->job_type ?? 'N/A') }}
                                </p>

                                {{-- Mô tả --}}
                                <p class="text-muted small mb-3" style="line-height: 1.5;">
                                    {!! $job->description ? Str::limit(strip_tags($job->description), 110) : 'Chưa có mô tả' !!}
                                </p>

                                {{-- Kỹ năng --}}
                                <div class="skills-tags d-flex flex-wrap gap-2 mb-4">
                                    @if ($job->skills->isNotEmpty())
                                        @foreach ($job->skills as $skill)
                                            <span
                                                class="badge bg-light text-success px-3 py-1 small">{{ $skill->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-light text-muted px-3 py-1 small">Không có kỹ năng</span>
                                    @endif
                                </div>

                                {{-- Lương + Ứng tuyển --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if ($job->salary_min > 0 || $job->salary_max > 0)
                                            <span class="fw-bold text-success">
                                                {{ number_format($job->salary_min) }} -
                                                {{ number_format($job->salary_max) }}
                                            </span>
                                        @else
                                            <span class="fw-bold text-success">Thỏa thuận</span>
                                        @endif
                                        <small class="text-muted ms-1">{{ $job->currency ?? 'VND' }}/tháng</small>
                                    </div>
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                        class="btn btn-primary btn-sm rounded-pill px-4 py-2">Ứng tuyển</a>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-info-circle fs-3 mb-2"></i>
                                <h5>Chưa có tin tuyển dụng nào.</h5>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>




        </section>

        <style>
            .job-card {
                transition: box-shadow 0.3s ease, transform 0.3s ease;
                background: #fff;
                border: none;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .job-card:hover {
                box-shadow: 0 10px 25px rgb(0 0 0 / 0.1);
                transform: translateY(-5px);
            }

            .featured-ribbon {
                position: absolute;
                top: 15px;
                left: -40px;
                background: #ffd700;
                color: #333;
                font-weight: 600;
                padding: 6px 50px 6px 20px;
                transform: rotate(-22deg);
                box-shadow: 0 2px 6px rgba(255, 215, 0, 0.6);
                border-radius: 6px;
                user-select: none;
                pointer-events: none;
                font-size: 0.9rem;
                z-index: 10;
            }

            .job-title a {
                color: #222;
                font-weight: 700;
            }

            .job-title a:hover {
                color: #0d6efd;
                text-decoration: underline;
            }

            .skills-tags .badge {
                border-radius: 20px;
                font-weight: 600;
            }

            .badge-top {
                background-color: #198754;
                /* Bootstrap green */
                color: white;
                font-weight: 600;
                padding: 4px 12px;
                border-radius: 999px;
                font-size: 0.75rem;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }

            .badge-hot {
                background: linear-gradient(to right, #ff8a00, #e52e71);
                color: white;
                font-weight: 600;
                padding: 4px 12px;
                border-radius: 999px;
                font-size: 0.75rem;
                box-shadow: 0 0 12px rgba(255, 122, 0, 0.5);
            }

            .job-card-custom {
                transition: all 0.3s ease;
                line-height: 1.6;
                background-color: #fff;
                border: 1px solid #eee;
            }

            .job-card-custom:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                transform: translateY(-3px);
            }

            /* Badge HOT */
            .badge-hot {
                background: linear-gradient(90deg, #ff7e00, #ff3d00);
                color: white;
                font-weight: bold;
                border-radius: 999px;
                padding: 4px 12px;
                font-size: 0.75rem;
                box-shadow: 0 0 12px rgba(255, 100, 0, 0.5);
            }

            /* Badge TOP */
            .badge-top {
                background-color: #28a745;
                color: white;
                font-weight: bold;
                border-radius: 999px;
                padding: 4px 12px;
                font-size: 0.75rem;
                box-shadow: 0 0 6px rgba(40, 167, 69, 0.4);
            }

            .active-skill {
                background: #eaf3fa !important;
                color: #1976d2 !important;
                border: 1.5px solid #1976d2 !important;
                font-weight: 600;
            }

            .btn-outline-primary.rounded-pill.btn-sm {
                border-radius: 30px;
                padding: 0.3rem 1.1rem;
                font-size: 1rem;
                transition: 0.18s;
            }

            .btn-outline-primary.rounded-pill.btn-sm:hover,
            .active-skill:hover {
                background: #d0e6fb !important;
                color: #1976d2 !important;
            }
        </style>
