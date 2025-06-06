@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-bell-fill me-2"></i>Danh sách thông báo đã gửi
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Người nhận</th>
                            <th>Loại</th>
                            <th>Nội dung</th>
                            <th>Link</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $noti)
                            <tr>
                                <td class="text-center">{{ $noti->id }}</td>
                                <td>{{ $noti->user->email ?? 'Tất cả' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark text-uppercase">
                                        {{ $noti->type }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-chat-text me-1 text-muted"></i>
                                    {{ Str::limit($noti->message, 60) }}
                                </td>
                                <td class="text-center">
                                    @if ($noti->link_url)
                                        <a href="{{ url($noti->link_url) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            Xem
                                        </a>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($noti->is_read)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle-fill"></i> Đã đọc
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-eye-slash"></i> Chưa đọc
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center text-muted">
                                    {{ $noti->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.notifications.show', $noti->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    Không có thông báo nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                <div class="d-flex justify-content-end">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ICON CDN --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
