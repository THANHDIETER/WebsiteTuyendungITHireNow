@extends('employer.layouts.default')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-primary fw-bold">
            <i class="bi bi-bell-fill me-2 text-warning"></i> Tất cả thông báo
        </h2>

        @forelse($notifications as $noti)
            <div
                class="card shadow-sm mb-3 border-start @if ($noti->read_at) border-secondary @else border-warning @endif border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none">
                            <h5 class="mb-1">
                                <i
                                    class="bi bi-info-circle-fill me-2 @if ($noti->read_at) text-secondary @else text-warning @endif"></i>
                                {{ $noti->data['message'] }}
                            </h5>
                        </a>
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <span
                        class="badge rounded-pill px-3 py-2 fw-semibold 
                    @if ($noti->read_at) bg-secondary text-light
                    @else
                        bg-warning text-dark @endif">
                        {{ $noti->read_at ? 'Đã đọc' : 'Chưa đọc' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                <i class="bi bi-inbox-fill fs-4"></i> <br>
                Hiện tại bạn chưa có thông báo nào.
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
