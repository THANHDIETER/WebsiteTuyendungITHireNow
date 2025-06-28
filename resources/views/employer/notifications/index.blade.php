@extends('employer.layouts.default')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Tất cả thông báo</h4>

    @forelse($notifications as $noti)
        <div class="alert alert-light d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ $noti->data['link_url'] }}">
                    <strong>{{ $noti->data['message'] }}</strong>
                </a>
                <div class="small text-muted">
                    {{ $noti->created_at->diffForHumans() }}
                </div>
            </div>
            @if($noti->read_at)
                <span class="badge bg-secondary">Đã đọc</span>
            @else
                <span class="badge bg-warning text-dark">Chưa đọc</span>
            @endif
        </div>
    @empty
        <p class="text-muted">Chưa có thông báo nào.</p>
    @endforelse

    {{ $notifications->links() }}
</div>
@endsection
