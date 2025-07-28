@extends('admin.layouts.default')

@section('title', 'Thêm Logo')

@section('content')
<div class="container mt-4">
    <h2>Thêm Logo Mới</h2>
    <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên logo (tuỳ chọn)</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Loại logo <span class="text-danger">*</span></label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh logo <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
            <label for="is_active" class="form-check-label">Kích hoạt</label>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
