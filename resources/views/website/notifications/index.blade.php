@extends('website.layouts.master')

@section('title', 'Thông báo')

@section('content')
<main class="main-content py-4">
    <div class="container" style="max-width: 720px;" class="mx-auto px-3">

        <div class="row mb-3">
            <div class="col-12 text-center">
                <h4 class="fw-bold text-primary mb-1">
                    🔔 Thông báo của bạn
                </h4>
                <p class="text-muted small">Theo dõi các hoạt động mới nhất</p>
            </div>
        </div>

        @forelse($notifications as $noti)
            <div class="notification-card card shadow-sm mb-2 rounded-3 border-start 
                @if(!$noti->read_at) border-warning border-3 bg-light-warning @endif
            " style="transition: all 0.3s ease; font-size: 0.9rem;">
                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-start">
                    <div class="noti-content">
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none text-dark">
                            <h6 class="mb-1 fw-semibold">
                                {{ $noti->data['message'] }}
                            </h6>
                        </a>
                        <small class="text-muted">{{ $noti->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="noti-status ms-3 text-end">
                        @if($noti->read_at)
                            <span class="badge bg-secondary">✓</span>
                        @else
                            <span class="badge bg-warning text-dark">Mới</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center rounded-3 shadow-sm small">
                <i class="bi bi-info-circle me-2"></i> Bạn chưa có thông báo nào.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center small">
            {{ $notifications->links() }}
        </div>
    </div>
</main>

<style>
    .notification-card:hover {
        background-color: #f8f9fa;
        transform: scale(1.005);
    }

    .bg-light-warning {
        background-color: #fffbe6 !important;
    }

    .noti-content h6:hover {
        color: #007bff;
    }
</style>
@endsection
