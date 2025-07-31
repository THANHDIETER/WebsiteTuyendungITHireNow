@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Chi tiết Blog</h2>
        <div>
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil-square"></i> Sửa
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        @if ($blog->image)
            <img src="{{ $blog->image }}" class="card-img-top" style="object-fit: cover; max-height: 360px;" alt="Ảnh blog">
        @endif

        <div class="card-body">
            <h3 class="card-title mb-2">{{ $blog->title }}</h3>
            <p class="text-muted mb-3">
                <i class="bi bi-person"></i> {{ $blog->author ?? 'Không rõ tác giả' }} &nbsp; | &nbsp;
                <i class="bi bi-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}
            </p>

            <div class="border-top pt-3" style="white-space: pre-line; font-size: 15.5px; line-height: 1.8;">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
