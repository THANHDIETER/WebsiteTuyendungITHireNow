@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tạo Blog mới</h2>

    <form action="{{ route('admin.blogs.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        {{-- Thông tin cơ bản --}}
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="bi bi-info-circle"></i> Thông tin cơ bản
            </h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" value="{{ old('author') }}" class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Link hình ảnh</label>
                    <input type="text" name="image" value="{{ old('image') }}" class="form-control">
                </div>
            </div>
        </div>

        {{-- Nội dung blog --}}
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="bi bi-card-text"></i> Nội dung Blog
            </h5>

            <div class="form-floating">
                <textarea class="form-control" name="content" id="content" style="height: 200px" required>{{ old('content') }}</textarea>
                <label for="content">Nội dung</label>
            </div>
        </div>

        {{-- Nút lưu --}}
        <div class="text-end">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Hủy</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Lưu Blog
            </button>
        </div>
    </form>
</div>
@endsection
