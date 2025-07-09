@extends('employer.layouts.default')

@section('content')
    <div class="container py-5">
        {{-- Tiêu đề và nút thêm --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <h2 class="h4 mb-0"><i class="bi bi-building me-2"></i>Quản lý Công ty</h2>
            <a href="{{ route('employer.companies.create') }}" class="btn btn-success d-flex align-items-center">
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

        {{-- Form tìm kiếm & lọc --}}
        <form method="GET" action="{{ route('employer.companies.index') }}" class="row mb-4 g-2">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên công ty..."
                    value="{{ request('keyword') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động
                    </option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Bị cấm</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i>Tìm</button>
            </div>
        </form>

        {{-- Bảng danh sách --}}
        <div class="card border-0 shadow-sm rounded-3">
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
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('employer.companies.show', $company) }}">
                                                            <i class="bi bi-eye me-2"></i>Xem
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('employer.companies.edit', $company) }}">
                                                            <i class="bi bi-pencil me-2"></i>Sửa
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger delete-btn"
                                                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                                                            data-id="{{ $company->id }}" data-name="{{ $company->name }}"
                                                            data-action="{{ route('employer.companies.destroy', $company) }}">
                                                            <i class="bi bi-trash me-2"></i>Xóa
                                                        </button>
                                                    </li>
                                                </ul>
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
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa công ty <strong id="companyName"></strong> không?</p>
                        <p class="text-danger small mb-0">* Hành động này không thể hoàn tác.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const confirmModal = document.getElementById('confirmModal');
                confirmModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const name = button.getAttribute('data-name');
                    const action = button.getAttribute('data-action');
                    document.getElementById('deleteForm').setAttribute('action', action);
                    document.getElementById('companyName').textContent = name;
                });
            });
        </script>
    @endpush
@endsection
