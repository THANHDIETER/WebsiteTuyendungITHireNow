@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Danh sách Notifications</h1>
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Notifiable Type</th>
                            <th>Notifiable ID</th>
                            <th>Message</th>
                            <th>Read At</th>
                            <th>Created At</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->id }}</td>
                                <td>{{ class_basename($notification->type) }}</td>
                                <td>{{ class_basename($notification->notifiable_type) }}</td>
                                <td>{{ $notification->notifiable_id }}</td>
                                <td>{{ $notification->data['message'] ?? '' }}</td>
                                <td>
                                    @if ($notification->read_at)
                                        {{ $notification->read_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa đọc</span>
                                    @endif
                                </td>
                                <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                        class="btn btn-info btn-sm" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.notifications.edit', $notification->id) }}"
                                        class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
