@extends('admin.layouts.default')

@section('content')
<div class="container my-4">
    <h2 class="fw-semibold text-dark mb-3">Danh sách Thông báo Hệ thống</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3" style="min-height: 70vh;">
            <!-- Thanh tìm kiếm + nút thêm -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Tìm kiếm..." id="searchInput">
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-primary" id="btn-add">
                        <i class="bi bi-plus-circle me-1"></i> Thêm mới
                    </button>
                </div>
            </div>

            <!-- Bảng danh sách -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Loại</th>
                            <th>Nội dung</th>
                            <th>Đã đọc</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="notificationTable">
                        @forelse ($notifications as $n)
                        <tr data-id="{{ $n->id }}">
                            <td class="fw-medium">{{ Str::limit($n->id, 8, '...') }}</td>
                            <td>
                                @if(Str::contains($n->type, 'GeneralNotification'))
                                    <span class="badge bg-primary">Hệ thống</span>
                                @elseif(Str::contains($n->type, 'MaintenanceNotification'))
                                    <span class="badge bg-warning text-dark">Bảo trì</span>
                                @else
                                    <span class="badge bg-secondary">Khác</span>
                                @endif
                                <div class="small text-muted">{{ $n->type }}</div>
                            </td>
                            <td class="text-truncate" style="max-width: 250px;">{{ $n->data['message'] ?? '-' }}</td>
                            <td>
                                @if($n->read_at)
                                    <span class="badge bg-success">Đã đọc</span>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                @endif
                            </td>
                            <td>{{ $n->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary btn-view"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning btn-edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-muted py-5">Không có thông báo nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal xem/chỉnh -->
<div class="modal fade" id="mainModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>
</div>

<style>
    body.dark-mode .table thead {
        background-color: #1e1e1e !important;
        color: #f1f1f1;
    }
    body.dark-mode .table tbody tr {
        background-color: #2a2a2a;
        color: #ddd;
    }
    body.dark-mode .form-control {
        background-color: #2a2a2a;
        color: #fff;
        border-color: #444;
    }
    .badge {
        font-size: 0.8rem;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('mainModal'));
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');

    // Search filter
    document.getElementById('searchInput').addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('#notificationTable tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });

    // View
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.closest('tr').dataset.id;
            fetch(`/admin/notifications/${id}/json`)
                .then(res => res.json())
                .then(data => {
                    let typeFriendly = '';
                    if (data.type.includes('GeneralNotification')) {
                        typeFriendly = 'Thông báo hệ thống';
                    } else if (data.type.includes('MaintenanceNotification')) {
                        typeFriendly = 'Thông báo bảo trì';
                    } else {
                        typeFriendly = 'Khác';
                    }

                    modalTitle.textContent = 'Chi tiết thông báo';
                    modalBody.innerHTML = `
                        <p><strong>ID:</strong> ${data.id}</p>
                        <p><strong>Loại:</strong> ${typeFriendly} <br><small class="text-muted">${data.type}</small></p>
                        <p><strong>Ngày tạo:</strong> ${data.created_at}</p>
                        <pre class="bg-light p-2 rounded">${JSON.stringify(data.data, null, 4)}</pre>
                    `;
                    modal.show();
                })
                .catch(() => {
                    showAlertModal({
                        title: 'Lỗi',
                        message: 'Không thể tải dữ liệu thông báo.',
                        status: 'danger'
                    });
                });
        });
    });

    // Add
    document.getElementById('btn-add').addEventListener('click', function () {
        fetch(`/admin/notifications/create`)
            .then(res => res.text())
            .then(html => {
                modalTitle.textContent = 'Thêm thông báo';
                modalBody.innerHTML = html;
                modal.show();
            })
            .catch(() => {
                showAlertModal({
                    title: 'Lỗi',
                    message: 'Không thể tải form thêm thông báo.',
                    status: 'danger'
                });
            });
    });

    // Edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.closest('tr').dataset.id;
            fetch(`/admin/notifications/${id}/edit`)
                .then(res => res.text())
                .then(html => {
                    modalTitle.textContent = 'Sửa thông báo';
                    modalBody.innerHTML = html;
                    modal.show();
                })
                .catch(() => {
                    showAlertModal({
                        title: 'Lỗi',
                        message: 'Không thể tải form sửa thông báo.',
                        status: 'danger'
                    });
                });
        });
    });

    // Delete
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.closest('tr').dataset.id;

            showAlertModal({
                title: 'Xác nhận xóa',
                message: 'Bạn có chắc muốn xóa thông báo này?',
                type: 'confirm',
                status: 'warning',
                onConfirm: () => {
                    fetch(`/admin/notifications/${id}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: new URLSearchParams({ _method: 'DELETE' })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        showAlertModal({
                            title: 'Thành công',
                            message: resp.message || 'Xóa thành công.',
                            status: 'success',
                            onConfirm: () => location.reload()
                        });
                    })
                    .catch(() => {
                        showAlertModal({
                            title: 'Lỗi',
                            message: 'Không thể xóa thông báo.',
                            status: 'danger'
                        });
                    });
                }
            });
        });
    });

    // Lắng nghe submit form thêm/sửa trong modal
    document.getElementById('mainModal').addEventListener('submit', function (e) {
        if (e.target.tagName.toLowerCase() === 'form') {
            e.preventDefault();
            const form = e.target;

            fetch(form.action, {
                method: form.method,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: new FormData(form)
            })
            .then(res => res.json())
            .then(resp => {
                showAlertModal({
                    title: 'Thành công',
                    message: resp.message || 'Thao tác thành công.',
                    status: 'success',
                    onConfirm: () => location.reload()
                });
            })
            .catch(() => {
                showAlertModal({
                    title: 'Lỗi',
                    message: 'Không thể thực hiện thao tác.',
                    status: 'danger'
                });
            });
        }
    });
});
</script>
@endpush

