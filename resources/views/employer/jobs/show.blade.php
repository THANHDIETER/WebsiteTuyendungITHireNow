@extends('employer.layouts.default')

@section('title', $job->meta_title ?? $job->title)
@section('meta_description', strip_tags($job->meta_description ?? Str::limit($job->description, 150)))
@section('meta_keywords', $job->keyword ?? '')

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

        {{-- ACTION BUTTONS --}}
        <div class="d-flex justify-content-end mb-3 gap-2">
            <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil-square me-1"></i> Sửa thông tin
            </a>
            @if($job->status !== 'closed')
                <form action="{{ route('employer.jobs.close', $job->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn ngừng tuyển dụng tin này?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle me-1"></i> Ngừng tuyển dụng
                    </button>
                </form>
            @endif
        </div>

        <h2 class="mb-4">
            <i class="bi bi-briefcase me-2"></i>
            {{ $job->title }}
        </h2>

        {{-- Company Info --}}
        <div class="d-flex align-items-center mb-4">
            <img src="{{ $job->company->logo_url ? asset($job->company->logo_url) : asset('assets/img/default-logo.png') }}"
                 alt="{{ $job->company->name }}"
                 class="me-3 border rounded"
                 style="width: 64px; height: 64px; object-fit: cover;">
            <div>
                <h5 class="mb-0">{{ $job->company->name }}</h5>
                <small class="text-muted">{{ $job->address }}</small>
            </div>
        </div>

        {{-- Summary --}}
        <div class="mb-4">
            <p><strong>Ngành nghề:</strong> {{ $job->category->name }}</p>
            <p><strong>Cấp bậc:</strong> {{ $job->level }}</p>
            <p><strong>Kinh nghiệm:</strong> {{ $job->experience }}</p>
            <p><strong>Hình thức:</strong> {{ $job->job_type_label }}</p>
            <p><strong>Địa chỉ làm việc:</strong> {{ $job->address }}</p>
            <p><strong>Lương:</strong> {{ $job->salary_range }}</p>
            <p><strong>Hạn nộp:</strong> {{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Không giới hạn' }}</p>
            <p><strong>Lượt xem:</strong> {{ $job->views }}</p>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <h5 class="mb-2">📄 Mô tả công việc</h5>
            {!! $job->description ?: '<em>Không có mô tả.</em>' !!}
        </div>

        {{-- Requirements --}}
        <div class="mb-4">
            <h5 class="mb-2">📌 Yêu cầu</h5>
            {!! $job->requirements ?: '<em>Không có yêu cầu cụ thể.</em>' !!}
        </div>

        {{-- Benefits --}}
        <div class="mb-4">
            <h5 class="mb-2">🏱 Quyền lợi</h5>
            {!! $job->benefits ?: '<em>Không rõ.</em>' !!}
        </div>

        {{-- Skills --}}
        @if ($job->skills && $job->skills->count())
            <div class="mb-4">
                <h5 class="mb-2">🛠 Kỹ năng cần có</h5>
                <ul class="list-inline">
                    @foreach ($job->skills as $skill)
                        <li class="list-inline-item badge bg-secondary">{{ $skill->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SEO Section --}}
        <div class="mt-5 pt-4 border-top">
            <h5 class="text-uppercase text-muted">📈 Dữ liệu SEO</h5>

            @if ($job->meta_title)
                <p><strong>Meta Title:</strong> {{ $job->meta_title }}</p>
            @endif

            @if ($job->meta_description)
                <p><strong>Meta Description:</strong> {!! $job->meta_description !!}</p>
            @endif

            @if ($job->keyword)
                <p><strong>Từ khóa (Keyword):</strong> {{ $job->keyword }}</p>
            @endif

            <p><strong>Hiển thị tìm kiếm:</strong> {!! $job->search_index ? '<span class="text-success">Có</span>' : '<span class="text-danger">Không</span>' !!}</p>
        </div>
    </div>
</main>
@endsection
