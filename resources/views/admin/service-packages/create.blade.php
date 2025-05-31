@extends('admin.layouts.default')

@section('title', 'Thêm Gói Dịch Vụ')

@section('content')
    <h1>Thêm Gói Dịch Vụ</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.service-packages.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên Gói</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="duration_days" class="form-label">Thời gian (ngày)</label>
            <input type="number" name="duration_days" id="duration_days" class="form-control @error('duration_days') is-invalid @enderror" value="{{ old('duration_days') }}">
            @error('duration_days')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="features" class="form-label">Tính năng</label>
            <textarea name="features" id="features" class="form-control @error('features') is-invalid @enderror">{{ old('features') }}</textarea>
            @error('features')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.service-packages.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection