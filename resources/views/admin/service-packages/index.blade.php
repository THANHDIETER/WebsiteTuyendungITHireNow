@extends('admin.layouts.default')

@section('content')

    <div class="container py-4">
        <h2 class="h4 mb-4">Danh sách Gói dịch vụ</h2>

        <div class="mb-3">
            <button class="btn btn-primary btn-create">+ Thêm gói mới</button>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên gói</th>
                            <th>Giá</th>
                            <th>Số ngày</th>
                            <th>Số tin</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $pkg)
                            <tr>
                                <td>{{ $pkg->id }}</td>
                                <td>{{ $pkg->name }}</td>
                                <td>{{ number_format($pkg->price) }} VND</td>
                                <td>{{ $pkg->duration_days }}</td>
                                <td>{{ $pkg->post_limit }}</td>
                                <td>
                                    <span class="badge {{ $pkg->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $pkg->is_active ? 'Hoạt động' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-info btn-sm btn-view" data-id="{{ $pkg->id }}">Chi tiết</button>
                                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $pkg->id }}">Sửa</button>
                                        <button class="btn btn-danger btn-sm btn-delete"
                                            data-url="{{ route('admin.service-packages.destroy', $pkg->id) }}"
                                            data-name="{{ $pkg->name }}">
                                            Xoá
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    </div>

    {{-- Modal hiển thị nội dung động --}}
    <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body" id="packageModalBody" style="max-height: 400px; overflow-y: auto;">
                    Đang tải nội dung...
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times-circle me-1"></i> Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('packageModal'));
            const modalTitle = document.getElementById('packageModalLabel');
            const modalBody = document.getElementById('packageModalBody');

            function loadModalContent(url, title) {
                modalTitle.innerText = title;
                modalBody.innerHTML = 'Đang tải...';
                fetch(url)
                    .then(res => res.text())
                    .then(data => {
                        modalBody.innerHTML = data;
                        modal.show();
                        bindAjaxForm();
                    })
                    .catch(err => {
                        showAlertModal({
                            title: 'Lỗi tải nội dung',
                            message: 'Không thể tải nội dung từ máy chủ.',
                            type: 'alert',
                            status: 'error'
                        });
                    });
            }

            // Tạo/sửa xem đều dùng 1 form partial
            function bindAjaxForm() {
                const form = modalBody.querySelector('form');
                if (!form) return;
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const oldAlerts = form.querySelectorAll('.alert');
                    oldAlerts.forEach(alert => alert.remove());

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(async res => {
                            if (res.status === 422) {
                                const data = await res.json();
                                let html = `<div class="alert alert-danger small"><ul class="mb-0">`;
                                for (let k in data.errors) {
                                    data.errors[k].forEach(msg => {
                                        html += `<li><i class="fa fa-exclamation-circle me-1"></i> ${msg}</li>`;
                                    });
                                }
                                html += `</ul></div>`;
                                form.insertAdjacentHTML('afterbegin', html);
                            } else if (res.ok) {
                                const data = await res.json();
                                showAlertModal({
                                    title: 'Thành công',
                                    message: data.message || 'Lưu thành công.',
                                    type: 'alert',
                                    status: 'success',
                                    onConfirm: function () {
                                        window.location.reload(); // hoặc reload lại bảng động nếu bạn dùng AJAX cho bảng
                                    }
                                });
                            } else {
                                showAlertModal({
                                    title: 'Lỗi',
                                    message: 'Có lỗi hệ thống!',
                                    type: 'alert',
                                    status: 'error'
                                });
                            }
                        })
                        .catch(err => {
                            showAlertModal({
                                title: 'Lỗi',
                                message: err.message || 'Không thể kết nối!',
                                type: 'alert',
                                status: 'error'
                            });
                        });
                });
            }

            // Thêm gói mới
            document.querySelector('.btn-create').addEventListener('click', () => {
                loadModalContent(`{{ route('admin.service-packages.create') }}`, 'Thêm Gói Dịch Vụ');
            });

            // Chi tiết (nếu có show detail)
            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    loadModalContent(`/admin/service-packages/${id}`, `Chi tiết Gói Dịch Vụ #${id}`);
                });
            });

            // Sửa
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    loadModalContent(`/admin/service-packages/${id}/edit`, `Cập nhật Gói Dịch Vụ #${id}`);
                });
            });

            // Xoá
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    const btnDelete = this;
                    const url = btnDelete.dataset.url;
                    const name = btnDelete.dataset.name;

                    showAlertModal({
                        title: 'Xác nhận xoá',
                        message: `Bạn có chắc chắn muốn xoá gói <b>${name}</b> không?`,
                        type: 'confirm',
                        status: 'warning',
                        onConfirm: function () {
                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        showAlertModal({
                                            title: 'Thành công',
                                            message: data.message || 'Xoá thành công.',
                                            type: 'alert',
                                            status: 'success',
                                            onConfirm: function () {
                                                btnDelete.closest('tr').remove();
                                            }
                                        });
                                    } else {
                                        showAlertModal({
                                            title: 'Lỗi',
                                            message: data.message || 'Có lỗi xảy ra.',
                                            type: 'alert',
                                            status: 'error'
                                        });
                                    }
                                })
                                .catch(err => {
                                    showAlertModal({
                                        title: 'Lỗi',
                                        message: err.message || 'Không thể kết nối đến máy chủ.',
                                        type: 'alert',
                                        status: 'error'
                                    });
                                });
                        }
                    });
                });
            });

        });

    </script>
@endpush