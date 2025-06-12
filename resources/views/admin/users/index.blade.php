@extends('admin.layouts.default')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh sách người dùng</h2>
            <a href="#" class="btn btn-primary disabled"
                style="pointer-events: none; opacity: 0.6;">+ Thêm người dùng</a>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if ($user->status === 'active')
                                <span class="badge bg-success">Đang hoạt động</span>
                            @elseif ($user->status === 'inactive')
                                <span class="badge bg-secondary">Chưa kích hoạt</span>
                            @else
                                <span class="badge bg-danger">Đã chặn</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-view-user"
                                data-id="{{ $user->id }}">
                                Xem
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-warning btn-edit-user"
                                data-id="{{ $user->id }}">
                                Sửa
                            </button>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                class="d-inline delete-form" data-id="{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Phân trang --}}
        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal Chi tiết người dùng -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="userDetailModalLabel">📄 Chi tiết người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="userDetailContent">
                    <p class="text-center text-muted">Đang tải...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa người dùng -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="userEditModalLabel">✏️ Sửa người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="userEditContent">
                    <p class="text-center text-muted">Đang tải biểu mẫu...</p>
                </div>
            </div>
        </div>
    </div>



@endsection

{{-- Script confirm xoá + show modal --}}
@push('scripts')
    @if (session('success') || session('info') || session('error') || session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showAlertModal({
                    type: 'alert',
                    title: {
                        success: 'Thành công',
                        info: 'Thông báo',
                        error: 'Lỗi',
                        warning: 'Cảnh báo'
                    }['{{ session()->has("success") ? "success" : (session()->has("info") ? "info" : (session()->has("warning") ? "warning" : "error")) }}'],
                    message: `{!! session('success') ?? session('info') ?? session('warning') ?? session('error') !!}`
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.delete-form');
            forms.forEach(form => {
                const btn = form.querySelector('.btn-delete');
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const userId = form.dataset.id;

                    showAlertModal({
                        type: 'confirm',
                        title: 'Xác nhận xoá',
                        message: `Bạn có chắc chắn muốn xoá người dùng ID #${userId}?`,
                        onConfirm: () => form.submit()
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('userDetailModal');
            const contentEl = document.getElementById('userDetailContent');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            document.querySelectorAll('.btn-view-user').forEach(btn => {
                btn.addEventListener('click', function () {
                    const userId = this.dataset.id;
                    contentEl.innerHTML = `<p class="text-center text-muted">Đang tải...</p>`;

                    fetch(`/admin/users/${userId}`)
                        .then(res => res.text())
                        .then(html => {
                            contentEl.innerHTML = html;
                            modal.show();
                        })
                        .catch(() => {
                            contentEl.innerHTML = `<p class="text-center text-danger">Không thể tải thông tin người dùng.</p>`;
                        });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModalEl = document.getElementById('userEditModal');
            const editContentEl = document.getElementById('userEditContent');
            const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);

            document.querySelectorAll('.btn-edit-user').forEach(btn => {
                btn.addEventListener('click', function () {
                    const userId = this.dataset.id;
                    editContentEl.innerHTML = `<p class="text-center text-muted">Đang tải biểu mẫu...</p>`;

                    fetch(`/admin/users/${userId}/edit`)
                        .then(res => res.text())
                        .then(html => {
                            editContentEl.innerHTML = html;
                            editModal.show();
                        })
                        .catch(() => {
                            editContentEl.innerHTML = `<p class="text-center text-danger">Không thể tải biểu mẫu.</p>`;
                        });
                });
            });
        });
    </script>

@endpush