@extends('admin.layouts.default')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mb-4">{{ $logo->id ? 'Sửa Logo' : 'Thêm Logo' }}</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method === 'PUT')
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Tên mô tả</label>
                    <input type="text" name="name" value="{{ old('name', $logo->name) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại</label>
                    <select name="type" class="form-select">
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type', $logo->type) == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" name="image" class="form-control">
                    @if($logo->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $logo->image_path) }}" width="120" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active"
                           {{ old('is_active', $logo->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Kích hoạt</label>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Lưu
                </button>
                <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
