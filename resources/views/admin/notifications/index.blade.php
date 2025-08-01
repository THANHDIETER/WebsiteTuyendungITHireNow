@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Danh sách Notifications</h1>

        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm mới
        </a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Loại</th>
                        <th>Notifiable Type</th>
                        <th>Notifiable ID</th>
                        <th>Nội dung (Message)</th>
                        <th>Trạng thái đọc</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->id }}</td>
                            <td>{{ class_basename($notification->type) }}</td>
                            <td>{{ class_basename($notification->notifiable_type) }}</td>
                            <td>{{ $notification->notifiable_id }}</td>
                            <td>{{ $notification->data['message'] ?? '-' }}</td>
                            <td>
                                @if ($notification->read_at)
                                    <span class="badge bg-success">Đã đọc</span><br>
                                    <small>{{ $notification->read_at->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                    class="btn btn-info btn-sm me-1" title="Xem">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                                <a href="{{ route('admin.notifications.edit', $notification->id) }}"
                                    class="btn btn-warning btn-sm me-1" title="Sửa">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
