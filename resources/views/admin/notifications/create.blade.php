@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Thêm Notification mới</h1>

    <form action="{{ route('admin.notifications.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select
                id="type"
                name="type"
                class="form-select @error('type') is-invalid @enderror"
                required
            >
                <option value="">-- Chọn type --</option>
                <option value="App\Notifications\Employer\JobApprovedNotification" {{ old('type') == 'App\Notifications\Employer\JobApprovedNotification' ? 'selected' : '' }}>JobApprovedNotification</option>
                <option value="App\Notifications\Employer\JobRejectedNotification" {{ old('type') == 'App\Notifications\Employer\JobRejectedNotification' ? 'selected' : '' }}>JobRejectedNotification</option>
                <option value="App\Notifications\NewMessageNotification" {{ old('type') == 'App\Notifications\NewMessageNotification' ? 'selected' : '' }}>NewMessageNotification</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="notifiable_id" class="form-label">Người nhận (User)</label>
            <select
                id="notifiable_id"
                name="notifiable_id"
                class="form-select @error('notifiable_id') is-invalid @enderror"
                required
            >
                <option value="all" {{ old('notifiable_id') == 'all' ? 'selected' : '' }}>Tất cả người dùng</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('notifiable_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
            @error('notifiable_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data (JSON)</label>
            <textarea
                id="data"
                name="data"
                class="form-control @error('data') is-invalid @enderror"
                rows="5"
                placeholder='{"message": "Nội dung thông báo"}'
                required
            >{{ old('data') ?? '{"message":""}' }}</textarea>
            @error('data')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="read_at" class="form-label">Read At (nullable)</label>
            <input
                type="datetime-local"
                id="read_at"
                name="read_at"
                class="form-control @error('read_at') is-invalid @enderror"
                value="{{ old('read_at') }}"
                placeholder="Chọn thời gian đã đọc (nếu có)"
            >
            @error('read_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success me-2">
            <i class="bi bi-check-lg me-1"></i> Lưu
        </button>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg me-1"></i> Hủy
        </a>
    </form>
</div>
@endsection
