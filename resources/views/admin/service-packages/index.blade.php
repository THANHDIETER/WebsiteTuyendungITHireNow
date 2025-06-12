@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <h2 class="h4 mb-4">Danh sách Gói dịch vụ</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.service-packages.create') }}" class="btn btn-primary">+ Thêm gói mới</a>
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
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $pkg->id }}">Xoá</button>
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
    <!-- Modal -->
    <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">Chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="packageModalBody">
                    Đang tải...
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
                    })
                    .catch(err => {
                        modalBody.innerHTML = '<div class="text-danger">Lỗi tải nội dung</div>';
                    });
            }

            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    loadModalContent(`/admin/service-packages/${id}`, 'Chi tiết Gói dịch vụ');
                });
            });

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    loadModalContent(`/admin/service-packages/${id}/edit`, 'Sửa Gói dịch vụ');
                });
            });

            let deletePackageId = null;

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', () => {
                    deletePackageId = btn.dataset.id;

                    showAlertModal({
                        title: 'Xác nhận xoá',
                        message: 'Bạn có chắc chắn muốn xoá gói dịch vụ này không?',
                        type: 'confirm',
                        status: 'warning',
                        onConfirm: () => {
                            fetch(`/admin/service-packages/${deletePackageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => {
                                    if (res.ok) {
                                        location.reload();
                                    } else {
                                        showAlertModal({
                                            title: 'Lỗi',
                                            message: 'Xoá thất bại!',
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