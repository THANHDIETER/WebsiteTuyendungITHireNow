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
