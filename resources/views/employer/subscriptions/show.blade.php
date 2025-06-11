@extends('employer.layouts.default')

@section('title', 'Chi tiết gói đã mua')

@section('content')
<div class="container">
    <h3>Chi tiết gói: {{ $subscription->employerPackage->name ?? '-' }}</h3>

    <ul class="list-group">
        <li class="list-group-item"><strong>Thời gian:</strong> {{ $subscription->start_date }} → {{ $subscription->end_date }}</li>
        <li class="list-group-item"><strong>Giới hạn tin:</strong> {{ $subscription->post_limit }} (Đã dùng: {{ $subscription->post_limit - $subscription->remaining_posts }})</li>
        <li class="list-group-item"><strong>CV đã xem:</strong> {{ $subscription->cv_views_used }}/{{ $subscription->cv_view_limit }}</li>
        <li class="list-group-item"><strong>Hỗ trợ:</strong> {{ ucfirst($subscription->support_level) }}</li>
        <li class="list-group-item"><strong>Trạng thái:</strong>
            @if ($subscription->is_active)
                <span class="badge bg-success">Đang hoạt động</span>
            @else
                <span class="badge bg-secondary">Không hoạt động</span>
            @endif
        </li>
        <li class="list-group-item"><strong>Giá:</strong> {{ number_format($subscription->price, 0, ',', '.') }}đ</li>
        @if ($subscription->note)
            <li class="list-group-item"><strong>Ghi chú:</strong> {{ $subscription->note }}</li>
        @endif
    </ul>

    <a href="{{ route('employer.subscriptions.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
