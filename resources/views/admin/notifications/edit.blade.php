@extends('admin.layouts.default')

@section('content')
    <div class="container my-4">
        <!-- Tiêu đề -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-semibold text-dark">Sửa Notification</h2>
            </div>
        </div>

        <!-- Thông báo thành công hoặc lỗi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Form chỉnh sửa -->
        <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Loại</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type', $notification->type) }}"
                        required>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kiểu đối tượng</label>
                    <input type="text" name="notifiable_type" class="form-control"
                        value="{{ old('notifiable_type', $notification->notifiable_type) }}" required>
                    @error('notifiable_type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ID đối tượng</label>
                    <input type="number" name="notifiable_id" class="form-control"
                        value="{{ old('notifiable_id', $notification->notifiable_id) }}" required>
                    @error('notifiable_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Đã đọc</label>
                    <input type="datetime-local" name="read_at" class="form-control"
                        value="{{ old('read_at', $notification->read_at ? $notification->read_at->format('Y-m-d\TH:i') : '') }}">
                    @error('read_at')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung (JSON)</label>
                <textarea name="data" class="form-control" rows="6" required style="font-size: 0.85rem; line-height: 1.4;">{{ old('data', json_encode($notification->data, JSON_PRETTY_PRINT)) }}</textarea>
                @error('data')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-between">
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-save me-1"></i> Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .form-control,
        .form-control:focus {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            margin: 0 2px;
            border-radius: 4px;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }

        .alert-success {
            background-color: #e6f4ea;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
@endsection
