@extends('website.layouts.master')

@section('title', 'Thông báo')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">🔔 Tất cả Thông báo</h2>

    @forelse($notifications as $noti)
        <div class="card mb-3 shadow-sm @if(!$noti->read_at) border-warning @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none">
                        <h5 class="card-title mb-1">
                            {{ $noti->data['message'] }}
                        </h5>
                    </a>
                    <p class="card-text text-muted small mb-0">
                        {{ $noti->created_at->diffForHumans() }}
                    </p>
                </div>

                <div>
                    @if($noti->read_at)
                        <span class="badge bg-secondary">Đã đọc</span>
                    @else
                        <span class="badge bg-warning text-dark">Chưa đọc</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
    @endforelse

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
