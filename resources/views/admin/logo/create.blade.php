@extends('admin.layouts.default')

@section('title', 'Thêm Logo')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Thêm Logo Mới</h4>

    <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tên mô tả --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên mô tả (tuỳ chọn)</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Loại logo --}}
        <div class="mb-3">
            <label for="type" class="form-label">Loại logo <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">-- Chọn loại logo --</option>
                <option value="site" {{ old('type') == 'site' ? 'selected' : '' }}>Site (Chung)</option>
                <option value="header" {{ old('type') == 'header' ? 'selected' : '' }}>Header</option>
                <option value="footer" {{ old('type') == 'footer' ? 'selected' : '' }}>Footer</option>
                <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="client" {{ old('type') == 'client' ? 'selected' : '' }}>Client</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Hình ảnh logo --}}
        <div class="mb-3">
            <label for="image" class="form-label">Tệp ảnh logo <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image"
                   class="form-control @error('image') is-invalid @enderror" required>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kích hoạt --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                   {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Kích hoạt (hiển thị)</label>
        </div>

        {{-- Nút hành động --}}
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
        <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
