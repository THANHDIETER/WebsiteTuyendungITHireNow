@extends('admin.layouts.default')

@section('content')
<style>
    footer {
        display: none !important;
    }
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>Chi Tiết Thông Báo #{{ $notification->id }}
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Người nhận:</div>
                        <div class="col-sm-8">{{ $notification->user->email ?? 'Tất cả người dùng' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Loại thông báo:</div>
                        <div class="col-sm-8">
                            <span class="badge bg-info text-dark text-uppercase">{{ $notification->type }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Nội dung:</div>
                        <div class="col-sm-8">{{ $notification->message }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Link đính kèm:</div>
                        <div class="col-sm-8">
                            @if ($notification->link_url)
                                <a href="{{ url($notification->link_url) }}" target="_blank">{{ $notification->link_url }}</a>
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Trạng thái:</div>
                        <div class="col-sm-8">
                            @if ($notification->is_read)
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Đã đọc</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-eye-slash"></i> Chưa đọc</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Thời gian gửi:</div>
                        <div class="col-sm-8">{{ $notification->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-primary">
                            ← Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
