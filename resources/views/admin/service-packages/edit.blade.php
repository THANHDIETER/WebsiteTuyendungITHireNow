@extends('admin.layouts.default')

@section('content')
<div class="container py-4 max-w-2xl">
    <h1 class="h4 mb-4">Chỉnh sửa Gói Dịch Vụ</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.service-packages.update', $service_package) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên gói</label>
            <input type="text" name="name" value="{{ old('name', $service_package->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Số ngày sử dụng *</label>
            <input type="number" name="duration_days" value="{{ old('duration_days', $service_package->duration_days) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số bài đăng *</label>
            <input type="number" name="post_limit" value="{{ old('post_limit', $service_package->post_limit) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" value="{{ old('price', $service_package->price) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $service_package->description) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $service_package->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Hiển thị
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.service-packages.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </form>
</div>
@endsection