@extends('employer.layouts.default')

@section('content')
<main class="main-content">
    <div class="container py-5">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-card-list me-2"></i>
                Danh sách công việc đã đăng
            </h2>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Đăng tin tuyển dụng
            </a>
        </div>

        <div class="row">
            @forelse ($jobs as $job)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border shadow-sm">
                        {{-- LOGO & COMPANY --}}
                        <div class="d-flex align-items-center p-3 border-bottom" style="min-height: 85px;">
                            <img src="{{ $job->company->logo_url ? asset($job->company->logo_url) : asset('assets/img/default-logo.png') }}"
                                 alt="{{ $job->company->name }}"
                                 class="rounded me-3 border"
                                 style="width: 56px; height: 56px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0 text-truncate" style="max-width: 170px;">
                                    <a href="#" class="text-dark">{{ $job->company->name }}</a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $job->location ?? 'Chưa cập nhật' }}
                                </small>
                            </div>
                        </div>
                        {{-- JOB CONTENT --}}
                        <div class="card-body pb-2">
                            <div class="d-flex align-items-center mb-2 gap-2">
                                <span class="fw-bold text-primary me-2" style="font-size:1.06rem">
                                    <a href="#" class="text-decoration-none">{{ $job->title }}</a>
                                </span>
                                @if($job->job_type === 'remote')
                                    <span class="badge rounded-pill bg-info text-dark px-2 py-1" style="font-size:0.85em">
                                        <i class="bi bi-laptop"></i> Remote
                                    </span>
                                @endif
                            </div>
                            <p class="mb-2 text-muted" style="min-height:38px;">
                                {{ $job->requirements ? \Illuminate\Support\Str::limit(strip_tags($job->requirements), 75) : 'Không có mô tả.' }}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @if($job->level)
                                    <span class="badge rounded-pill bg-purple" style="background:#D7C1F8;color:#5a189a;">{{ $job->level }}</span>
                                @endif
                                @if($job->experience)
                                    <span class="badge rounded-pill bg-warning text-dark" style="background:#FFE066;color:#ad8a00;">
                                        {{ $job->experience }}
                                    </span>
                                @endif
                                @if($job->category)
                                    <span class="badge rounded-pill bg-light border">{{ $job->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        {{-- FOOTER --}}
                        <div class="card-footer d-flex justify-content-between align-items-center bg-light border-0">
                            <div>
                                <span class="fw-bold text-success" style="font-size:1.12rem;">
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency ?? 'VND' }}
                                </span>
                                <div style="font-size:0.93em;" class="text-muted">/tháng</div>
                            </div>
                            <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-outline-primary btn-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Hiện tại bạn chưa có tin tuyển dụng nào.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PHÂN TRANG --}}
        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    </div>
</main>
@endsection
