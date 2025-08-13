@extends('admin.layouts.default')

@section('content')
    <div class="container my-4">
        <!-- Tiêu đề -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-semibold text-dark">Chi tiết Notification</h2>
            </div>
        </div>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Bảng chi tiết -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <tr>
                    <th style="width: 20%;">ID</th>
                    <td>{{ $notification->id }}</td>
                </tr>
                <tr>
                    <th>Loại</th>
                    <td>{{ $notification->type }}</td>
                </tr>
                <tr>
                    <th>Kiểu đối tượng</th>
                    <td>{{ $notification->notifiable_type }}</td>
                </tr>
                <tr>
                    <th>ID đối tượng</th>
                    <td>{{ $notification->notifiable_id }}</td>
                </tr>
                <tr>
                    <th>Nội dung</th>
                    <td class="text-start">
                        <pre class="bg-light p-2 rounded" style="max-height: 200px; overflow: auto; font-size: 0.85rem; line-height: 1.4;">
                        {{ json_encode($notification->data, JSON_PRETTY_PRINT) }}
                    </pre>
                    </td>
                </tr>
                <tr>
                    <th>Đã đọc</th>
                    <td>
                        @if ($notification->read_at)
                            <span class="badge bg-success">Đã đọc</span>
                            <div class="text-muted small mt-1">{{ $notification->read_at->format('d/m/Y H:i') }}</div>
                        @else
                            <span class="badge bg-warning text-dark">Chưa đọc</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <!-- Nút hành động -->
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <div class="btn-group">
                    <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i> Sửa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        pre {
            font-size: 0.85rem;
            white-space: pre-wrap;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .btn-group .btn,
        .btn-outline-secondary,
        .btn-outline-warning {
            margin: 0 2px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .alert-success {
            background-color: #e6f4ea;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
@endsection
