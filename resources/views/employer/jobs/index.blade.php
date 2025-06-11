@extends('employer.layouts.default')

@section('content')
 <main class="main-content">
  
<div class="container py-5">
     <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📄 Danh sách công việc đã đăng</h2>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Đăng tin tuyển dụng
        </a>
    </div>


    <div class="row">
        @forelse ($jobs as $job)
            <div class="col-md-6 col-lg-4 mb-4">
                <!--== Start Recent Job Item ==-->
                <div class="recent-job-item recent-job-style2-item border p-3 rounded shadow-sm">
                    <div class="company-info d-flex align-items-center mb-3">
                        <div class="logo me-3">
                            <a href="#">
                                <img src="{{ $job->company->logo_url ?? asset('assets/img/default-logo.png') }}"
                                     alt="{{ $job->company->name }}"
                                     width="75" height="75">
                            </a>
                        </div>
                        <div class="content">
                            <h4 class="name mb-1">
                                <a href="#">{{ $job->company->name }}</a>
                            </h4>
                            <p class="address text-muted mb-0">{{ $job->location ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>

                    <div class="main-content mb-3">
                        <h5 class="title">
                            <a href="#">{{ $job->title }}</a>
                        </h5>
                        <h6 class="work-type text-primary">{{ ucfirst($job->job_type) }}</h6>
                        <p class="desc text-muted">
                            {{ $job->requirements ? \Illuminate\Support\Str::limit(strip_tags($job->requirements), 100) : 'Không có mô tả.' }}
                        </p>
                    </div>

                    <div class="recent-job-info d-flex justify-content-between align-items-center">
                        <div class="salary">
                            <h5 class="text-success mb-0">
                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency ?? 'VND' }}
                            </h5>
                            <small class="text-muted">/tháng</small>
                        </div>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('employer.jobs.show', $job->id) }}">Xem chi tiết</a>
                    </div>
                </div>
                <!--== End Recent Job Item ==-->
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Hiện tại bạn chưa có tin tuyển dụng nào.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
</main>
@endsection
