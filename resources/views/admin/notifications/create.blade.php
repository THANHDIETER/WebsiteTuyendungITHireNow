@extends('admin.layouts.default')

@section('content')
    <div class="container">
        <h1>Thêm Notification mới</h1>

        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Type</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Chọn type --</option>
                    <option value="App\Notifications\Employer\JobApprovedNotification"
                        {{ old('type') == 'App\Notifications\Employer\JobApprovedNotification' ? 'selected' : '' }}>
                        JobApprovedNotification</option>
                    <option value="App\Notifications\Employer\JobRejectedNotification"
                        {{ old('type') == 'App\Notifications\Employer\JobRejectedNotification' ? 'selected' : '' }}>
                        JobRejectedNotification</option>
                    <option value="App\Notifications\NewMessageNotification"
                        {{ old('type') == 'App\Notifications\NewMessageNotification' ? 'selected' : '' }}>
                        NewMessageNotification</option>
                    <!-- Thêm type khác nếu muốn -->
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Người nhận (User)</label>
                <select name="notifiable_id" class="form-select" required>
                    <option value="all" {{ old('notifiable_id') == 'all' ? 'selected' : '' }}>Tất cả người dùng</option>
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

            <div class="mb-3">
                <label>Data (JSON)</label>
                <textarea name="data" class="form-control" rows="4" required>{{ old('data') ?? '{"message":""}' }}</textarea>
                @error('data')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Read At (nullable)</label>
                <input type="datetime-local" name="read_at" class="form-control" value="{{ old('read_at') }}">
                @error('read_at')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
