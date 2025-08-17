<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-2"></i> Chi tiết Thông báo Hệ thống</h5>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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
                    <th>Nội dung</th>
                    <td class="text-start">
<pre class="bg-light p-3 rounded mb-0" style="max-height: 300px; overflow: auto;">
{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
</pre>
                    </td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>
                        @if ($notification->read_at)
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Đã đọc</span>
                            <div class="text-muted small mt-1">{{ $notification->read_at->format('d/m/Y H:i') }}</div>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-eye-slash me-1"></i> Chưa đọc</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning text-dark">
                    <i class="bi bi-pencil me-1"></i> Sửa
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    pre {
        font-size: 0.85rem;
        white-space: pre-wrap;
        word-wrap: break-word;
        line-height: 1.4;
        margin: 0;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.65em;
    }
</style>
