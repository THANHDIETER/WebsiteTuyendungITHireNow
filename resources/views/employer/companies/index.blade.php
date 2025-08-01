@extends('employer.layouts.default')

@section('content')
    <div class="container py-5">
        {{-- Tiêu đề và nút thêm --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <h2 class="h4 mb-0"><i class="bi bi-building me-2"></i>Quản lý Công ty</h2>
            <a href="{{ route('employer.companies.create') }}" class="btn btn-success d-flex align-items-center shadow-sm rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i>Thêm Công ty
            </a>
        </div>

        {{-- Thông báo thành công --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
<<<<<<< HEAD

=======
>>>>>>> 6e48b775fbcdf948f127af553ce8a4755137c5ec
        {{-- Bảng danh sách --}}
        <div class="card border-0 shadow-sm rounded-3 mb-2">
            <div class="card-body p-0">
                @if ($companies->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Tên công ty</th>
                                    <th style="width: 15%;">Trạng thái</th>
                                    <th style="width: 20%;">Ngày tạo</th>
                                    <th style="width: 10%;" class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr>
                                        <td>{{ $company->id }}</td>
                                        <td>
                                            <strong>{{ $company->name }}</strong>
                                            @if ($company->created_at->greaterThan(\Carbon\Carbon::now()->subDays(7)))
                                                <span class="badge bg-info ms-1"><i class="bi bi-stars"></i> Mới</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($company->status)
                                                @case('active')
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                                                @break

                                                @case('inactive')
                                                    <span class="badge bg-secondary"><i class="bi bi-slash-circle me-1"></i>Inactive</span>
                                                @break

                                                @default
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Banned</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-end mb-2" >
                                            <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                                <a href="{{ route('employer.companies.show', $company) }}"
                                                class="btn btn-circle btn-view" data-bs-toggle="tooltip" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('employer.companies.edit', $company) }}"
                                                class="btn btn-circle btn-edit" data-bs-toggle="tooltip" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-circle btn-delete delete-btn"
                                                        data-bs-toggle="tooltip" title="Xóa"
                                                        data-bs-toggle="modal" data-bs-target="#confirmModal"
                                                        data-id="{{ $company->id }}" data-name="{{ $company->name }}"
                                                        data-action="{{ route('employer.companies.destroy', $company) }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-exclamation-circle me-2"></i>Không tìm thấy công ty nào.
                        <a href="{{ route('employer.companies.create') }}">Thêm ngay</a>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white border-0 text-center">
                {{ $companies->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Modal xác nhận xóa --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận xóa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <form method="POST" id="deleteForm">
                    @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Style cho nút icon hành động --}}
 <style>
    .btn-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 2px 6px 0 rgba(0,0,0,0.05);
        transition: all 0.2s;
        outline: none !important;
    }
    .btn-circle .bi { vertical-align: middle; }

    .btn-view { color: #0d6efd; }
    .btn-edit { color: #fd7e14; }
    .btn-delete { color: #dc3545; }

    .btn-view:hover, .btn-view:focus {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 2px 10px 0 #0d6efd33;
    }
    .btn-edit:hover, .btn-edit:focus {
        background: #fd7e14;
        color: #fff;
        box-shadow: 0 2px 10px 0 #fd7e1433;
    }
    .btn-delete:hover, .btn-delete:focus {
        background: #dc3545;
        color: #fff;
        box-shadow: 0 2px 10px 0 #dc354533;
    }

    .table th, .table td { vertical-align: middle; }
    .table { border-radius: 16px !important; overflow: hidden; }
    .table thead th {
        background: #f8fafc;
        font-weight: 700;
        border: none;
    }
    .table tbody tr {
        background: #fff;
        border-bottom: 1px solid #f1f3f7;
    }
    .table tbody tr:last-child { border-bottom: none; }
</style>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Xử lý modal xác nhận xóa
                const confirmModal = document.getElementById('confirmModal');
                confirmModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const name = button.getAttribute('data-name');
                    const action = button.getAttribute('data-action');
                    document.getElementById('deleteForm').setAttribute('action', action);
                    document.getElementById('companyName').textContent = name;
                });

                // Kích hoạt tooltip Bootstrap 5
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    @endpush
@endsection
