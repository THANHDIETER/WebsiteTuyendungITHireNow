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
  <section class="recent-job-area py-5 bg-white">
  <div class="container">
  <div class="row g-4" style="row-gap: 2rem;  "> 
    @forelse($jobs as $job)
    <div class="col-md-6 col-lg-4" >
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
           class="d-block mb-3 overflow-hidden rounded"
           style="height:160px;">
          <img src="{{ $job->thumbnail ? asset('storage/' . $job->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
               alt="{{ $job->title }}"
               style="object-fit: cover; width: 100%; height: 100%;">
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
              <span class="badge bg-light text-success px-3 py-1 small">{{ $skill->name }}</span>
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
                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
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
    background-color: #198754; /* Bootstrap green */
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

</style>
