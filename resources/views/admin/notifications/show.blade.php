@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📄 Chi Tiết Thông Báo #{{ $notification->id }}</h5>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Người nhận:</dt>
                <dd class="col-sm-9">{{ $notification->user->email ?? 'Tất cả người dùng' }}</dd>

                <dt class="col-sm-3">Loại thông báo:</dt>
                <dd class="col-sm-9"><span class="badge bg-info text-dark">{{ $notification->type }}</span></dd>

                <dt class="col-sm-3">Nội dung:</dt>
                <dd class="col-sm-9">{{ $notification->message }}</dd>

                <dt class="col-sm-3">Link đính kèm:</dt>
                <dd class="col-sm-9">
                    @if ($notification->link_url)
                        <a href="{{ url($notification->link_url) }}" target="_blank">{{ $notification->link_url }}</a>
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Trạng thái:</dt>
                <dd class="col-sm-9">
                    @if ($notification->is_read)
                        <span class="badge bg-success">✔️ Đã đọc</span>
                    @else
                        <span class="badge bg-secondary">Chưa đọc</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Thời gian gửi:</dt>
                <dd class="col-sm-9">{{ $notification->created_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-primary mt-3">← Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection
