@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-semibold"><i class="bi bi-people-fill me-2"></i>Danh sách nhà tuyển dụng</h2>

    <div class="table-responsive shadow-sm border rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small">
                <tr class="text-center">
                    <th class="text-start">Email</th>
                    <th class="text-start">Tên</th>
                    <th class="text-start">Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employers as $employer)
                <tr>
                    <td class="text-start">{{ $employer->email }}</td>
                    <td class="fw-semibold text-start">{{ $employer->name }}</td>
                    <td class="text-start">{{ $employer->phone_number ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill px-3 py-2 fw-medium
                            @if ($employer->status === 'active') bg-success-subtle text-success
                            @elseif($employer->status === 'inactive') bg-secondary-subtle text-secondary
                            @else bg-danger-subtle text-danger @endif">
                            {{ ucfirst($employer->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Xem nhà tuyển dụng -->
                            <button class="btn btn-sm btn-outline-info rounded-circle" title="Xem"
                                data-bs-toggle="modal" data-bs-target="#showEmployerModal{{ $employer->id }}">
                                <i class="bi bi-eye-fill"></i>
                            </button>

                            <!-- Xóa nhà tuyển dụng -->
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa"
                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $employer->id }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal xem nhà tuyển dụng -->
                <div class="modal fade" id="showEmployerModal{{ $employer->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Chi tiết nhà tuyển dụng</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Email:</strong> {{ $employer->email }}</p>
                                <p><strong>Tên:</strong> {{ $employer->name }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $employer->phone_number ?? '-' }}</p>
                                <p><strong>Trạng thái:</strong> 
                                    <span class="badge
                                        {{ $employer->status === 'active' ? 'bg-success' : ($employer->status === 'inactive' ? 'bg-secondary' : 'bg-danger') }}">
                                        {{ ucfirst($employer->status) }}
                                    </span>
                                </p>

                                <h6 class="mt-4">Danh sách công ty</h6>
                                @if ($employer->companies && $employer->companies->count() > 0)
                                    <ul class="list-group">
                                        @foreach ($employer->companies as $company)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $company->name }}
                                                <button type="button" class="btn btn-sm btn-outline-primary company-btn"
                                                    data-bs-toggle="modal" data-bs-target="#showCompanyModal{{ $company->id }}"
                                                    data-employer-modal="#showEmployerModal{{ $employer->id }}">
                                                    Xem công ty
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Nhà tuyển dụng chưa có công ty nào.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal xóa nhà tuyển dụng -->
                <div class="modal fade" id="deleteModal{{ $employer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $employer->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $employer->id }}">Xác nhận xóa</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Bạn có chắc chắn muốn xóa?</p>
                                <p class="fw-bold text-danger">{{ $employer->name }}</p>
                            </div>
                            <div class="modal-footer justify-content-center border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <form action="{{ route('admin.employers.destroy', $employer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Không có nhà tuyển dụng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $employers->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<!-- Modal xem công ty riêng biệt (popup) -->
@foreach ($employers as $employer)
    @foreach ($employer->companies as $company)
    <div class="modal fade" id="showCompanyModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Chi tiết công ty: {{ $company->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Tên công ty:</strong> {{ $company->name }}</p>
                    <p><strong>Email:</strong> {{ $company->email }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $company->address ?? '-' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $company->phone ?? '-' }}</p>
                    <p><strong>Website:</strong> 
                        @if ($company->website)
                            <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>Mô tả:</strong> {!! nl2br(e($company->description ?? '-')) !!}</p>
                    <p><strong>Lợi ích:</strong> {!! nl2br(e($company->benefits ?? '-')) !!}</p>
                    <p><strong>Năm thành lập:</strong> {{ $company->founded_year ?? '-' }}</p>
                    <p><strong>Quy mô công ty:</strong> {{ $company->company_size ?? '-' }}</p>
                    <p><strong>Ngành nghề:</strong> {{ $company->industry ?? '-' }}</p>
                    <p><strong>Trạng thái:</strong> {{ ucfirst($company->status) ?? '-' }}</p>
                    <p><strong>Ngày tạo:</strong> {{ $company->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="modal-footer border-0 justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Khi mở modal công ty, ẩn modal nhà tuyển dụng để tránh lỗi
document.querySelectorAll('.company-btn').forEach(button => {
    button.addEventListener('click', () => {
        const employerModalSelector = button.getAttribute('data-employer-modal');
        const employerModalEl = document.querySelector(employerModalSelector);
        if (employerModalEl) {
            const employerModal = bootstrap.Modal.getInstance(employerModalEl);
            if (employerModal) employerModal.hide();
        }
    });
});

// Khi đóng modal công ty, hiện lại modal nhà tuyển dụng tương ứng
document.querySelectorAll('[id^="showCompanyModal"]').forEach(modalEl => {
    modalEl.addEventListener('hidden.bs.modal', () => {
        // Tìm modal nhà tuyển dụng có chứa nút bấm mở modal công ty này
        const companyId = modalEl.id.replace('showCompanyModal', '');
        const btn = document.querySelector(`button[data-bs-target="#showCompanyModal${companyId}"]`);
        if (btn) {
            const employerModalSelector = btn.getAttribute('data-employer-modal');
            const employerModalEl = document.querySelector(employerModalSelector);
            if (employerModalEl) {
                const employerModal = new bootstrap.Modal(employerModalEl);
                employerModal.show();
            }
        }
    });
});

// Xóa backdrop thừa khi modal đóng
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('hidden.bs.modal', () => {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
    });
});
</script>
@endsection
