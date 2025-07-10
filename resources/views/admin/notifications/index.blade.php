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
                    <i class="bi bi-plus-circle me-1"></i> Thêm mới
                </a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <!-- Bộ lọc -->
                <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Tất cả --</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Đã đọc</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Người nhận</label>
                        <select name="user_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Tất cả người dùng --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <!-- Bảng dữ liệu -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
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

                <!-- Phân trang -->
                <div class="pt-3 d-flex justify-content-end">
                    {{ $notifications->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
            const modalTitle = document.getElementById('notificationModalLabel');
            const modalBody = document.getElementById('notificationModalBody');

            new bootstrap.Tooltip(document.body, {
                selector: '[data-bs-toggle="tooltip"]',
                trigger: 'hover'
            });

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

            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', () => loadModalContent(btn.dataset.url,
                'Chi tiết thông báo'));
            });

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => loadModalContent(btn.dataset.url,
                    'Chỉnh sửa thông báo'));
            });

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', () => {
                    const url = btn.dataset.url;
                    showAlertModal({
                        title: 'Xác nhận xoá',
                        message: 'Bạn có chắc chắn muốn xoá thông báo này không?',
                        type: 'confirm',
                        status: 'warning',
                        onConfirm: () => {
                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            }).then(res => {
                                if (res.ok) location.reload();
                                else {
                                    showAlertModal({
                                        title: 'Lỗi',
                                        message: 'Không thể xoá thông báo.',
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
