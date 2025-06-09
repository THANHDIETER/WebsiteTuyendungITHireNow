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
                                    <li><a href="index.html">Trang chủ</a></li>
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
<div class="container py-5">
    <div class="card shadow-lg p-4 mb-5 bg-white rounded">
        <h4 class="mb-4 text-primary text-center">Tìm kiếm công việc mơ ước của bạn</h4>
        <form method="GET" action="{{ route('cong-viec') }}">
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Từ khóa</label>
                    <input type="text" name="keyword" class="form-control" placeholder="VD: Laravel, React..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Địa điểm</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="location" id="hn" value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hn">Hà Nội</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="location" id="hcm" value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hcm">Hồ Chí Minh</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Loại hình</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="job_type[]" value="full-time" {{ is_array(request('job_type')) && in_array('full-time', request('job_type')) ? 'checked' : '' }}>
                        <label class="form-check-label">Full-time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="job_type[]" value="part-time" {{ is_array(request('job_type')) && in_array('part-time', request('job_type')) ? 'checked' : '' }}>
                        <label class="form-check-label">Part-time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="job_type[]" value="remote" {{ is_array(request('job_type')) && in_array('remote', request('job_type')) ? 'checked' : '' }}>
                        <label class="form-check-label">Remote</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Lương từ (VNĐ)</label>
                    <input type="range" name="min_salary" class="form-range" min="0" max="100000000" step="1000000" value="{{ request('min_salary', 0) }}">
                    <span class="badge bg-info">{{ number_format(request('min_salary', 0)) }} VNĐ</span>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Cấp bậc</label>
                    <select name="level" class="form-select">
                        <option value="">-- Chọn cấp bậc --</option>
                        <option value="Junior" {{ request('level') == 'Junior' ? 'selected' : '' }}>Junior</option>
                        <option value="Mid" {{ request('level') == 'Mid' ? 'selected' : '' }}>Mid</option>
                        <option value="Senior" {{ request('level') == 'Senior' ? 'selected' : '' }}>Senior</option>
                        <option value="Lead" {{ request('level') == 'Lead' ? 'selected' : '' }}>Lead</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kinh nghiệm</label>
                    <input type="range" name="experience" class="form-range" min="0" max="10" step="1" value="{{ request('experience', 0) }}">
                    <span class="badge bg-secondary">{{ request('experience', 0) }} năm</span>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ngành nghề</label><br>
                    @foreach($categories as $category)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="category_id" id="cat{{ $category->id }}" value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Công ty</label>
                    <select name="company_id" class="form-select">
                        <option value="">-- Chọn công ty --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Kỹ năng</label><br>
                    @foreach($skills as $skill)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->name }}" {{ collect(request('skills'))->contains($skill->name) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $skill->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5 mt-3">🔍 Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>

    @if ($jobs->count())
        <div class="list-group">
            @foreach ($jobs as $job)
                <a href="{{ route('jobs.show', $job->slug) }}" class="list-group-item list-group-item-action mb-2">
                    <h5 class="mb-1 text-dark fw-bold">{{ $job->title }}</h5>
                    <p class="mb-1">{{ Str::limit($job->description, 100) }}</p>
                    <small class="text-muted">{{ $job->location }} | {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} VNĐ</small>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $jobs->withQueryString()->links() }}
        </div>
    @else
        <p class="text-muted text-center">Không tìm thấy công việc phù hợp.</p>
    @endif
</div>

        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area recent-job-inner-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="https://htmldemo.net/finate/finate/company-details.html">
                                        <img src="../client/assets/img/companies/w1.webp" width="75" height="75"
                                            alt="Logo công ty">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a
                                            href="https://htmldemo.net/finate/finate/company-details.html">Darkento Ltd.</a>
                                    </h4>
                                    <p class="address">New York, Mỹ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">Lập trình viên Front-end</a></h3>
                                <h5 class="work-type">Toàn thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>50.000.000đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                    <!--== Lặp lại các job-item khác tương tự, chỉ dịch phần nội dung ==-->
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="#"><img src="../client/assets/img/companies/w2.webp" width="75"
                                            height="75" alt="Logo công ty"></a>
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="#">Inspire Fitness Co.</a></h4>
                                    <p class="address">New York, Mỹ</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title"><a href="job-details.html">UI Designer Senior</a></h3>
                                <h5 class="work-type" data-text-color="#ff7e00">Bán thời gian</h5>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>30.000.000đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="job-details.html">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                    <!-- Các job khác dịch như trên... -->
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            <nav>
                                <ul class="page-numbers d-inline-flex">
                                    <li>
                                        <a class="page-number active" href="job.html">1</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="job.html">2</a>
                                    </li>
                                    <li>
                                        <a class="page-number" href="job.html">3</a>
                                    </li>
                                    <li>
                                        <a class="page-number next" href="job.html">
                                            <i class="icofont-long-arrow-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc danh sách việc làm ==-->
    </main>
@endsection
