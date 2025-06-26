@extends('employer.layouts.default')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0"><i class="bi bi-building me-2"></i>Quản lý Công ty</h2>
            <a href="{{ route('employer.companies.create') }}" class="btn btn-success d-flex align-items-center">
                <i class="bi bi-plus-lg me-1"></i>Thêm Công ty
            </a>
        </div>

        <div class="card border-0 shadow">
            <div class="card-body p-0">
                @if ($companies->count())
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Tên công ty</th>
                                    <th style="width: 15%;">Trạng thái</th>
                                    <th style="width: 20%;">Ngày tạo</th>
                                    <th style="width: 20%;" class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr>
                                        <td>{{ $company->id }}</td>
                                        <td>
                                            <strong>{{ $company->name }}</strong>
                                            @if ($company->created_at->greaterThan(\Carbon\Carbon::now()->subDays(7)))
                                                <span class="badge bg-info ms-1 align-middle">Mới</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($company->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($company->status == 'inactive')
                                                <span class="badge bg-secondary">Inactive</span>
                                            @else
                                                <span class="badge bg-danger">Banned</span>
                                            @endif
                                        </td>
                                        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('employer.companies.show', $company) }}"
                                                class="btn btn-sm btn-info me-1" title="Xem">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('employer.companies.edit', $company) }}"
                                                class="btn btn-sm btn-warning me-1" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                data-bs-toggle="modal" data-bs-target="#confirmModal"
                                                data-id="{{ $company->id }}" data-name="{{ $company->name }}"
                                                data-action="{{ route('employer.companies.destroy', $company) }}"
                                                title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-exclamation-circle me-2"></i>Chưa có công ty nào. <a
                            href="{{ route('employer.companies.create') }}">Thêm ngay</a>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white border-0 text-center">
                {{ $companies->links() }}
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xóa
                        Công ty</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa công ty <strong id="companyName"></strong> không?</p>
                        <p class="text-danger small">* Hành động này không thể hoàn tác.</p>
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
                var confirmModal = document.getElementById('confirmModal');
                confirmModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var action = button.getAttribute('data-action');
                    var name = button.getAttribute('data-name');
                    var form = document.getElementById('deleteForm');
                    form.setAttribute('action', action);
                    document.getElementById('companyName').textContent = name;
                });
            });
        </script>
    @endpush

@endsection
