@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-bell-fill me-2"></i>Danh sách thông báo
                    <span class="badge bg-light text-dark ms-2">{{ $notifications->total() }}</span>
                </h5>
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle-fill me-1"></i> Thêm thông báo
                </a>
            </div>
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
                        </thead>
                        <tbody>
                            @forelse ($notifications as $noti)
                                <tr class="text-center">
                                    <td>{{ $noti->id }}</td>
                                    <td>
                                        @if ($noti->user)
                                            <span class="text-dark">{{ $noti->user->email }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Tất cả</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark text-uppercase">{{ $noti->type }}</span>
                                    </td>
                                    <td class="text-start" title="{{ $noti->message }}">
                                        <i class="bi bi-chat-left-text text-muted me-1"></i>
                                        {{ Str::limit($noti->message, 60) }}
                                    </td>
                                    <td>
                                        @if ($noti->link_url)
                                            <a href="{{ url($noti->link_url) }}" class="btn btn-outline-primary btn-sm"
                                                target="_blank" title="{{ $noti->link_url }}">
                                                <i class="bi bi-link-45deg"></i> Xem
                                            </a>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($noti->is_read)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Đã đọc
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-eye-slash me-1"></i> Chưa đọc
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ $noti->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="tooltip"
                                                title="Chỉnh sửa"
                                                data-url="{{ route('admin.notifications.edit', $noti->id) }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-info btn-sm text-white btn-view" data-bs-toggle="tooltip"
                                                title="Xem chi tiết"
                                                data-url="{{ route('admin.notifications.show', $noti->id) }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm btn-delete"
                                                data-bs-toggle="tooltip" title="Xoá"
                                                data-url="{{ route('admin.notifications.destroy', $noti->id) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Không có thông báo nào.</td>
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

    <!-- Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="notificationModalLabel">Chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-4" id="notificationModalBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3 text-muted">Đang tải nội dung...</p>
                    </div>
                </div>
            </div>
        </div>
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

            new bootstrap.Tooltip(document.body, {
                selector: '[data-bs-toggle="tooltip"]',
                trigger: 'hover'
            });
    }

            function loadModalContent(url, title) {
                modalTitle.textContent = title;
                modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3 text-muted">Đang tải nội dung...</p>
                    </div>`;
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

