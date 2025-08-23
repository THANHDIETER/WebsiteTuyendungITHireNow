@extends('admin.settings.layout')

@section('settings-content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex align-items-center">
            <i class="bi bi-search me-2"></i>
            <h5 class="mb-0">Cấu hình SEO Website</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.seo.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control shadow-sm"
                           value="{{ old('title', $seo->title ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control shadow-sm" rows="3" required>{{ old('description', $seo->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keywords</label>
                    <textarea name="keywords" class="form-control shadow-sm" rows="3">{{ old('keywords', $seo->keywords ?? '') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm px-4">
                        <i class="bi bi-save me-2"></i> Lưu Cấu hình
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
