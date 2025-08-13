@extends('admin.layouts.default')

@section('content')
    <div class="container my-4">
        <!-- Tiêu đề -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-semibold text-dark">Thêm Notification mới</h2>
            </div>
        </div>

        <!-- Thông báo thành công hoặc lỗi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Form thêm mới -->
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Loại</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="App\Notifications\Employer\JobApprovedNotification"
                            {{ old('type') == 'App\Notifications\Employer\JobApprovedNotification' ? 'selected' : '' }}>
                            JobApprovedNotification
                        </option>
                        <option value="App\Notifications\Employer\JobRejectedNotification"
                            {{ old('type') == 'App\Notifications\Employer\JobRejectedNotification' ? 'selected' : '' }}>
                            JobRejectedNotification
                        </option>
                        <option value="App\Notifications\NewMessageNotification"
                            {{ old('type') == 'App\Notifications\NewMessageNotification' ? 'selected' : '' }}>
                            NewMessageNotification
                        </option>
                    </select>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Người nhận (User)</label>
                    <select name="notifiable_id" class="form-select" required>
                        <option value="all" {{ old('notifiable_id') == 'all' ? 'selected' : '' }}>Tất cả người dùng
                        </option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('notifiable_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} (ID: {{ $user->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('notifiable_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Đã đọc</label>
                    <input type="datetime-local" name="read_at" class="form-control" value="{{ old('read_at') }}">
                    @error('read_at')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nội dung (JSON)</label>
                <textarea name="data" class="form-control" rows="6" required style="font-size: 0.85rem; line-height: 1.4;">{{ old('data') ?? '{"message":""}' }}</textarea>
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
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .form-control,
        .form-control:focus,
        .form-select,
        .form-select:focus {
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
            font-size: 0.9rem;
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
