@extends('website.layouts.master')

@section('content')
    <main class="main-content">

        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Việc làm</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Việc làm</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <div class="container py-3">
            <div class="card shadow p-4 mb-5 bg-white rounded">
                <form method="GET" action="{{ route('jobs.index') }}">
                    <div class="row g-3 align-items-end">

                        <!-- Từ khóa -->
                        <div class="col-md-4">
                            <label class="form-label">Từ khóa</label>
                            <input type="text" name="keyword" class="form-control" placeholder="VD: PHP, React..."
                                value="{{ request('keyword') }}">
                        </div>
                        <!-- Địa điểm radio -->
                        <div class="col-md-4">
                            <label class="form-label">Địa điểm</label><br>
                            @php $locations = $jobs->pluck('location')->merge(request('locations'))->unique()->filter(); @endphp
                            @foreach ($locations as $loc)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="locations[]"
                                        value="{{ $loc }}"
                                        {{ collect(request('locations'))->contains($loc) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $loc }}</label>
                                </div>
                            @endforeach
                        </div>


                        <!-- Ngành nghề -->
                        <div class="col-md-4">
                            <label class="form-label">Ngành nghề</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Chọn ngành --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Công ty -->
                        <div class="col-md-4">
                            <label class="form-label">Công ty</label>
                            <select name="company_id" class="form-select">
                                <option value="">-- Chọn công ty --</option>
                                @foreach ($companies as $co)
                                    <option value="{{ $co->id }}"
                                        {{ request('company_id') == $co->id ? 'selected' : '' }}>{{ $co->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Loại hình checkbox -->
                        <div class="col-md-4">
                            <label class="form-label">Loại hình</label><br>
                            @foreach (['full-time' => 'Toàn thời gian', 'part-time' => 'Bán thời gian', 'remote' => 'Làm từ xa'] as $value => $label)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="job_type[]"
                                        value="{{ $value }}"
                                        {{ is_array(request('job_type')) && in_array($value, request('job_type')) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Cấp bậc -->
                        <div class="col-md-4">
                            <label class="form-label">Cấp bậc</label>
                            <select name="level" class="form-select">
                                <option value="">-- Chọn cấp bậc --</option>
                                <option value="Junior" {{ request('level') == 'Junior' ? 'selected' : '' }}>Junior</option>
                                <option value="Mid" {{ request('level') == 'Mid' ? 'selected' : '' }}>Mid</option>
                                <option value="Senior" {{ request('level') == 'Senior' ? 'selected' : '' }}>Senior</option>
                                <option value="Lead" {{ request('level') == 'Lead' ? 'selected' : '' }}>Lead</option>
                            </select>
                        </div>
                        <!-- Kinh nghiệm -->
                        <div class="col-md-4">
                            <label class="form-label">Kinh nghiệm</label>
                            <input type="text" name="experience" class="form-control" placeholder="VD: 2 năm..."
                                value="{{ request('experience') }}">
                        </div>
                        <!-- Lương khoảng giá -->
                        <div class="col-md-2">
                            <label class="form-label">Lương từ (VNĐ)</label>
                            <input type="number" name="min_salary" class="form-control" placeholder="Tối thiểu"
                                min="0" step="100000" value="{{ request('min_salary') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Lương đến (VNĐ)</label>
                            <input type="number" name="max_salary" class="form-control" placeholder="Tối đa" min="0"
                                step="100000" value="{{ request('max_salary') }}">
                        </div>
                        <!-- Kỹ năng -->
                        <div class="col-md-8">
                            <label class="form-label">Kỹ năng</label><br>
                            @foreach ($skills as $skill)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="skills[]"
                                        value="{{ $skill->name }}"
                                        {{ collect(request('skills'))->contains($skill->name) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $skill->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Việc nổi bật -->
                        <div class="col-md-2">
                            <label class="form-label">Chỉ việc nổi bật</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                    value="1" {{ request('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Bật/Tắt</label>
                            </div>
                        </div>
                        <!-- Nút submit -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 mt-3">🔍 Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Việc làm phù hợp nhất --}}
            @if (isset($topJobs) && $topJobs->count())
                <div class="mt-4 mb-2">
                    <h4 class="text-primary mb-3">🌟 Việc làm phù hợp nhất cho bạn</h4>
                    <div class="row">
                        @foreach ($topJobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="recent-job-item recent-job-style2-item border border-success shadow-sm mb-3">
                                    <div class="company-info">
                                        <div class="logo">
                                            <a href="{{ route('jobs.show', $job->slug) }}">
                                                <img src="{{ $job->company->logo_url ?? '../client/assets/img/companies/w1.webp' }}"
                                                    width="75" height="75" alt="Logo công ty">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h4 class="name"><a href="#">{{ $job->company->name }}</a></h4>
                                            <p class="address">{{ $job->location }}</p>
                                        </div>
                                    </div>
                                    <div class="main-content">
                                        <h3 class="title">
                                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                        </h3>
                                        <h5 class="work-type">
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
                                        </h5>
                                        <p class="desc">{{ Str::limit($job->description, 100) }}</p>
                                    </div>
                                    <div class="recent-job-info">
                                        <div class="salary">
                                            <h4>{{ number_format($job->salary_min) }}{{ $job->salary_max ? ' - ' . number_format($job->salary_max) : '' }}
                                                VNĐ</h4>
                                            <p>/tháng</p>
                                        </div>
                                        <a class="btn-theme btn-sm" href="{{ route('jobs.show', $job->slug) }}">Ứng tuyển
                                            ngay</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Danh sách việc làm --}}
            <section class="recent-job-area recent-job-inner-area">
                <div class="container">
                    <div class="row">
                        @forelse ($jobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="recent-job-item recent-job-style2-item">
                                    <div class="company-info">
                                        <div class="logo">
                                            <a href="{{ route('jobs.show', $job->slug) }}">
                                                <img src="{{ $job->company->logo_url ?? '../client/assets/img/companies/w1.webp' }}"
                                                    width="75" height="75" alt="Logo công ty">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h4 class="name"><a href="#">{{ $job->company->name }}</a></h4>
                                            <p class="address">{{ $job->location }}</p>
                                        </div>
                                    </div>
                                    <div class="main-content">
                                        <h3 class="title">
                                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                        </h3>
                                        <h5 class="work-type">
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
                                        </h5>
                                        <p class="desc">{{ Str::limit($job->description, 100) }}</p>
                                    </div>
                                    <div class="recent-job-info">
                                        <div class="salary">
                                            <h4>{{ number_format($job->salary_min) }}{{ $job->salary_max ? ' - ' . number_format($job->salary_max) : '' }}
                                                VNĐ</h4>
                                            <p>/tháng</p>
                                        </div>
                                        <a class="btn-theme btn-sm" href="{{ route('jobs.show', $job->slug) }}">Ứng tuyển
                                            ngay</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center text-muted mt-4">Không tìm thấy công việc phù hợp.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="pagination-area">
                                    {{ $jobs->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    @endsection
