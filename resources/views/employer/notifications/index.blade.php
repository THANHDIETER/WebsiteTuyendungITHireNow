@extends('employer.layouts.default')

@section('title', 'Thông báo')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <!-- Header -->
        <div class="bg-dark text-white px-4 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-bell-fill me-2"></i> Trung tâm thông báo
            </h5>
            <a href="{{ route('employer.dashboard') }}" class="btn btn-sm btn-light rounded-pill">
                <i class="bi bi-arrow-left"></i> Quay lại Dashboard
            </a>
        </div>

        <!-- Body -->
        <div class="card-body bg-light px-4 py-3">
            @forelse($notifications as $noti)
                <div class="notification-item bg-white p-3 mb-3 rounded-3 shadow-sm d-flex justify-content-between align-items-start border-start border-4 
                    {{ !$noti->read_at ? 'border-primary' : 'border-secondary' }}"
                >
                    <div class="flex-grow-1">
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none text-dark">
                            <div class="fw-semibold fs-6 mb-1 d-flex align-items-center">
                                <i class="bi bi-chat-dots-fill me-2 text-primary"></i>
                                {{ $noti->data['message'] }}
                            </div>
                        </a>
                        <small class="text-muted">{{ $noti->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="ms-3">
                        @if($noti->read_at)
                            <span class="badge bg-success px-3 py-1"><i class="bi bi-check-circle-fill me-1"></i>Đã đọc</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-1"><i class="bi bi-dot"></i>Mới</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center rounded-3">
                    <i class="bi bi-info-circle me-2"></i>Không có thông báo nào.
                </div>
            @endforelse

            <div class="d-flex justify-content-end mt-4">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: all 0.25s ease;
}
.notification-item:hover {
    transform: scale(1.01);
    background-color: #f8f9fa;
}
</style>
@endsection
