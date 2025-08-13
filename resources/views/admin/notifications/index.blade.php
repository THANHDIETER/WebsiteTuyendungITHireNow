@extends('admin.layouts.default')

@section('content')
    <div class="container my-4">
        <!-- Tiêu đề -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-semibold text-dark">Danh sách Notifications</h2>
            </div>
        </div>

        <!-- Thanh tìm kiếm và nút Thêm mới -->
        <div class="row mb-3 align-items-center">
            <div class="col-md-8 col-lg-6">
                <input type="text" class="form-control" placeholder="Tìm kiếm notifications..." id="searchInput">
            </div>
            <div class="col-md-4 col-lg-6 text-end">
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Thêm mới
                </a>
            </div>
        </div>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Bảng dữ liệu -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Loại</th>
                        <th style="width: 15%;">Kiểu đối tượng</th>
                        <th style="width: 10%;">ID đối tượng</th>
                        <th style="width: 25%;">Nội dung</th>
                        <th style="width: 10%;">Đã đọc</th>
                        <th style="width: 15%;">Ngày tạo</th>
                        <th style="width: 15%;">Hành động</th>
                    </tr>
                </thead>
                <tbody id="notificationTable">
                    @forelse ($notifications as $notification)
                        <tr>
                            <td title="{{ $notification->id }}">{{ $notification->id }}</td>
                            <td>{{ $notification->type }}</td>
                            <td>{{ $notification->notifiable_type }}</td>
                            <td>{{ $notification->notifiable_id }}</td>
                            <td>{{ $notification->data['message'] ?? '-' }}</td>
                            <td>
                                @if ($notification->read_at)
                                    <span class="badge bg-success">Đã đọc</span>
                                    <div class="text-muted small">{{ $notification->read_at->format('d/m/Y H:i') }}</div>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Thao tác">
                                    <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.notifications.edit', $notification->id) }}"
                                        class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                        method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Không có notifications nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $notifications->links() }}
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tableRows = document.querySelectorAll('#notificationTable tr');

                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();

                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            });
        </script>
    @endsection

    <style>
        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }

        .btn-group .btn {
            margin: 0 2px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #e6f4ea;
            border-color: #c3e6cb;
            color: #155724;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-outline-warning {
            border-color: #ffc107;
            color: #ffc107;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .pagination .page-link {
            color: #007bff;
            margin: 0 2px;
            border-radius: 4px;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .table {
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }
    </style>
@endsection
