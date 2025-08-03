@extends('admin.layouts.default')

@section('title', 'Chỉnh sửa Logo')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Chỉnh sửa Logo</h4>

    <form action="{{ route('admin.logos.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tên mô tả --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên mô tả (tuỳ chọn)</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $logo->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Loại logo --}}
        <div class="mb-3">
            <label for="type" class="form-label">Loại logo <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ old('type', $logo->type) === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Ảnh hiện tại --}}
        <div class="mb-3">
            <label class="form-label">Ảnh hiện tại:</label><br>
            <img src="{{ asset('storage/' . $logo->image_path) }}" alt="Logo" width="150">
        </div>

        {{-- Ảnh mới --}}
        <div class="mb-3">
            <label for="image" class="form-label">Thay ảnh logo (nếu muốn)</label>
            <input type="file" name="image" id="image"
                   class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Trạng thái --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                   {{ old('is_active', $logo->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Kích hoạt (hiển thị)</label>
        </div>

        {{-- Nút hành động --}}
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
        <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
