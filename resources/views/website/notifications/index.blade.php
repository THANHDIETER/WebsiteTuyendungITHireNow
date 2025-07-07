@extends('website.layouts.master')

@section('title', 'Thông báo')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">
            <i class="bi bi-bell-fill text-warning me-2"></i> Tất cả Thông báo
        </h2>

        @forelse($notifications as $noti)
            <div
                class="card mb-3 shadow-sm border @if (!$noti->read_at) border-warning @else border-light @endif">
                <div class="card-body d-flex justify-content-between align-items-start flex-column flex-md-row">
                    <div class="flex-grow-1">
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none">
                            <h5 class="card-title mb-1 text-dark fw-semibold">
                                {{ $noti->data['message'] }}
                            </h5>
                        </a>
                        <p class="card-text text-muted small mb-0">
                            <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="mt-2 mt-md-0 text-md-end">
                        @if ($noti->read_at)
                            <span class="badge bg-secondary"><i class="bi bi-eye"></i> Đã đọc</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-eye-slash"></i> Chưa đọc</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-1"></i> Bạn chưa có thông báo nào.
            </div>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
