@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa Thông Báo
                    </h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Loại thông báo</label>
                            <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $notification->type) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold">Người nhận</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="all" {{ $notification->user_id === null ? 'selected' : '' }}>Tất cả người dùng</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $notification->user_id === $user->id ? 'selected' : '' }}>
                                        {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Nội dung</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required>{{ old('message', $notification->message) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label fw-semibold">Liên kết (nếu có)</label>
                            <input type="url" name="link_url" id="link_url" class="form-control" value="{{ old('link_url', $notification->link_url) }}">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                                ← Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning">
                                💾 Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
