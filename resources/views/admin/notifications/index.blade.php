@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-bell-fill me-2"></i>Danh sách thông báo đã gửi
            </h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="user_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả người nhận</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

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
                                <td class="text-center">
                                    <span class="badge bg-info text-dark text-uppercase">{{ $noti->type }}</span>
                                </td>
                                <td><i class="bi bi-chat-text me-1 text-muted"></i>{{ Str::limit($noti->message, 60) }}</td>
                                <td class="text-center">
                                    @if ($noti->link_url)
                                        <a href="{{ url($noti->link_url) }}" class="btn btn-sm btn-outline-primary" target="_blank">Xem</a>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($noti->is_read)
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Đã đọc</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-eye-slash"></i> Chưa đọc</span>
                                    @endif
                                </td>
                                <td class="text-center text-muted">
                                    {{ $noti->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                       <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $noti->id }}">Sửa</button>
<button class="btn btn-sm btn-info text-white btn-view" data-id="{{ $noti->id }}">Chi Tiết</button>
<button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $noti->id }}">Xóa</button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">Không có thông báo nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 d-flex justify-content-end">
                {{ $notifications->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<!-- Modal hiển thị nội dung hoặc form sửa -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">Chi tiết</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body" id="notificationModalBody">Đang tải...</div>
    </div>
  </div>
</div>

<!-- Modal xác nhận xoá -->
<div class="modal fade" id="globalAlertModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4" style="max-width: 440px; margin: auto; border-radius: 16px;">
      <div class="fs-1 mb-3 modal-icon"><i class="bi bi-info-circle-fill"></i></div>
      <h5 class="mb-2 fw-bold modal-title">Thông báo</h5>
      <p class="text-muted mb-4 modal-body-message">Bạn có chắc chắn?</p>
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn btn-primary px-4" id="globalAlertModal-confirm-btn">Đồng ý</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function showAlertModal({ title = 'Thông báo', message = '', type = 'confirm', status = 'info', onConfirm = () => {} }) {
    const modalEl = document.getElementById('globalAlertModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modalEl.querySelector('.modal-title').textContent = title;
    modalEl.querySelector('.modal-body-message').textContent = message;

    const iconMap = {
        success: 'bi-check-circle-fill',
        error: 'bi-x-circle-fill',
        warning: 'bi-exclamation-circle-fill',
        info: 'bi-info-circle-fill'
    };
    modalEl.querySelector('.modal-icon i').className = `bi ${iconMap[status] || 'bi-info-circle-fill'}`;

    const confirmBtn = modalEl.querySelector('#globalAlertModal-confirm-btn');
    const newBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);
    newBtn.onclick = function () {
        modal.hide();
        if (type === 'confirm') onConfirm();
    };
    modal.show();
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
    const modalTitle = document.getElementById('notificationModalLabel');
    const modalBody = document.getElementById('notificationModalBody');

    function loadModalContent(url, title) {
        modalTitle.textContent = title;
        modalBody.innerHTML = 'Đang tải...';
        fetch(url)
            .then(res => res.text())
            .then(html => {
                modalBody.innerHTML = html;
                modal.show();
            })
            .catch(() => {
                modalBody.innerHTML = '<div class="text-danger">Không thể tải nội dung.</div>';
            });
    }

    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            loadModalContent(`/admin/notifications/${id}`, 'Chi tiết thông báo');
        });
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            loadModalContent(`/admin/notifications/${id}/edit`, 'Chỉnh sửa thông báo');
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            showAlertModal({
                title: 'Xác nhận xoá',
                message: 'Bạn có chắc chắn muốn xoá thông báo này không?',
                type: 'confirm',
                status: 'warning',
                onConfirm: () => {
                    fetch(`/admin/notifications/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    }).then(res => {
                        if (res.ok) {
                            location.reload();
                        } else {
                            showAlertModal({
                                title: 'Lỗi',
                                message: 'Không thể xoá!',
                                type: 'alert',
                                status: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
});
</script>
@endpush

