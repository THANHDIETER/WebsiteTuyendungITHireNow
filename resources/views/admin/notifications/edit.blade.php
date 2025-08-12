@extends('admin.layouts.default')

@section('content')
    <div class="container">
        <h1>Sửa Notification</h1>

        <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $notification->type) }}"
                    required>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Notifiable Type</label>
                <input type="text" name="notifiable_type" class="form-control"
                    value="{{ old('notifiable_type', $notification->notifiable_type) }}" required>
                @error('notifiable_type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Notifiable ID</label>
                <input type="number" name="notifiable_id" class="form-control"
                    value="{{ old('notifiable_id', $notification->notifiable_id) }}" required>
                @error('notifiable_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Data (JSON)</label>
                <textarea name="data" class="form-control" rows="4" required>{{ old('data', json_encode($notification->data, JSON_PRETTY_PRINT)) }}</textarea>
                @error('data')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Read At (nullable)</label>
                <input type="datetime-local" name="read_at" class="form-control"
                    value="{{ old('read_at', $notification->read_at ? $notification->read_at->format('Y-m-d\TH:i') : '') }}">
                @error('read_at')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
