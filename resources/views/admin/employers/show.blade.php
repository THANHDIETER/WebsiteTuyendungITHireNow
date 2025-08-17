@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-semibold">
        <i class="bi bi-person-badge-fill me-2"></i>Chi tiết Nhà tuyển dụng
    </h2>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border rounded">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-envelope-fill fs-3 text-info"></i>
                        <div>
                            <div class="small text-muted">Email</div>
                            <div class="fw-semibold">{{ $employer->email }}</div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-person-fill fs-3 text-info"></i>
                        <div>
                            <div class="small text-muted">Tên</div>
                            <div class="fw-semibold">{{ $employer->name }}</div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-telephone-fill fs-3 text-info"></i>
                        <div>
                            <div class="small text-muted">Số điện thoại</div>
                            <div class="fw-semibold">{{ $employer->phone_number ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border rounded">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="small text-muted">Trạng thái</div>
                            <span class="badge
                                {{ $employer->status === 'active' ? 'bg-success' : ($employer->status === 'inactive' ? 'bg-secondary' : 'bg-danger') }} fs-6">
                                {{ ucfirst($employer->status) }}
                            </span>
                        </div>
                        <i class="bi bi-info-circle-fill text-info fs-4"></i>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="small text-muted">Ngày tạo</div>
                            <div class="fw-semibold">{{ $employer->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <i class="bi bi-calendar-fill text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Danh sách công ty</h4>
    @if ($employer->companies && $employer->companies->count() > 0)
        <div class="table-responsive shadow-sm border rounded">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Tên công ty</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employer->companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->address ?? '-' }}</td>
                        <td>{{ $company->phone ?? '-' }}</td>
                        <td class="text-center">
                            <!-- Link xem chi tiết công ty (bạn có thể thay bằng modal nếu muốn) -->
                            <a href="{{ route('admin.companies.show', $company->id) }}" class="btn btn-sm btn-outline-info">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Nhà tuyển dụng chưa có công ty nào.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
</div>
@endsection
