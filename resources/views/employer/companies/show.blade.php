@extends('employer.layouts.default')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            {{-- Cover Banner --}}
            @if ($company->cover_image_url)
                <div class="bg-secondary position-relative overflow-hidden mx-auto w-90 rounded-top"
                    style="height:400px; width:100%; background: url('{{ asset('storage/' . $company->cover_image_url) }}') center/cover;">
                    {{-- Dark overlay for better contrast --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                    {{-- Logo Overlay --}}
                    <div class="position-absolute top-100 start-50 translate-middle" style="margin-top:-150px;">
                        @if ($company->logo_url)
                            <img src="{{ asset('storage/' . $company->logo_url) }}" alt="Logo {{ $company->name }}"
                                class="rounded-circle border border-white shadow"
                                style="width:250px; height:250px; object-fit:cover; background-color:#fff;">
                        @else
                            <div class="rounded-circle bg-light border border-white d-flex align-items-center justify-content-center shadow"
                                style="width:250px; height:250px;">
                                <i class="bi bi-building fs-2 text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card-body pt-5">
                {{-- Header: Back Button + Title + Actions --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <h3 class="mb-0 text-primary fw-semibold d-flex align-items-center">
                            <i class="bi bi-building me-2 text-secondary"></i>{{ $company->name }}
                        </h3>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employer.companies.edit', $company) }}"
                            class="btn btn-sm btn-outline-warning d-flex align-items-center">
                            <i class="bi bi-pencil me-1"></i> Sửa
                        </a>
                        <a href="{{ route('employer.companies.index') }}"
                            class="btn btn-outline-secondary d-flex align-items-center" title="Quay lại">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                </div>


                {{-- Main Content: Basic Info + Scrollable Description/Benefits --}}
                <div class="row gy-4">
                    {{-- Thông tin cơ bản --}}
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark mb-4">
                                    <i class="bi bi-info-circle me-2 text-primary"></i>Thông tin cơ bản
                                </h5>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-3">
                                        <i class="bi bi-globe me-2 text-secondary"></i><strong>Website:</strong>
                                        @if ($company->website)
                                            <a href="{{ $company->website }}" target="_blank"
                                                class="text-decoration-underline">{{ $company->website }}</a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </li>
                                    <li class="mb-3"><i
                                            class="bi bi-envelope me-2 text-secondary"></i><strong>Email:</strong>
                                        {{ $company->email ?? '—' }}</li>
                                    <li class="mb-3"><i class="bi bi-phone me-2 text-secondary"></i><strong>Điện
                                            thoại:</strong> {{ $company->phone ?? '—' }}</li>
                                    <li class="mb-3"><i class="bi bi-geo-alt me-2 text-secondary"></i><strong>Địa
                                            chỉ:</strong> {{ $company->address ?? '—' }}</li>
                                    <li class="mb-3"><i class="bi bi-building me-2 text-secondary"></i><strong>Thành
                                            phố:</strong> {{ $company->city ?? '—' }}</li>
                                    <li class="mb-3"><i class="bi bi-people me-2 text-secondary"></i><strong>Quy
                                            mô:</strong> {{ $company->company_size ?? '—' }}</li>
                                    <li class="mb-3"><i class="bi bi-calendar-event me-2 text-secondary"></i><strong>Năm
                                            thành lập:</strong> {{ $company->founded_year ?? '—' }}</li>
                                    <li><i class="bi bi-briefcase me-2 text-secondary"></i><strong>Ngành:</strong>
                                        {{ $company->industry ?? '—' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Mô tả & Phúc lợi --}}
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark mb-4">
                                    <i class="bi bi-card-text me-2 text-secondary"></i>Mô tả & Phúc lợi
                                </h5>

                                {{-- Mô tả --}}
                                <div class="mb-4">
                                    <h6 class="fw-semibold mb-2"><i class="bi bi-info-square me-2 text-muted"></i>Mô tả</h6>
                                    <div class="border rounded bg-light-subtle p-3"
                                        style="max-height: 150px; overflow-y: auto;">
                                        <p class="mb-0 text-muted small">{!! nl2br(e($company->description)) !!}</p>
                                    </div>
                                </div>

                                {{-- Phúc lợi --}}
                                <div>
                                    <h6 class="fw-semibold mb-2"><i class="bi bi-gift me-2 text-muted"></i>Phúc lợi</h6>
                                    <div class="border rounded bg-light-subtle p-3"
                                        style="max-height: 150px; overflow-y: auto;">
                                        @if (is_array($company->benefits) && count($company->benefits))
                                            <ul class="list-inline mb-0">
                                                @foreach ($company->benefits as $item)
                                                    <li class="list-inline-item mb-2">
                                                        <span
                                                            class="badge bg-secondary-subtle text-dark border">{{ $item }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted small mb-0">{!! nl2br(e($company->benefits)) ?: '—' !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- System Info --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-dark fw-bold mb-4">
                            <i class="bi bi-gear me-2 text-info"></i>Thông tin hệ thống
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody class="text-sm">
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold" style="width: 200px;">
                                            <i class="bi bi-shield-check me-2 text-secondary"></i>Xác thực
                                        </th>
                                        <td>
                                            <span class="badge bg-{{ $company->is_verified ? 'success' : 'secondary' }}">
                                                {{ $company->is_verified ? 'Đã xác thực' : 'Chưa xác thực' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">
                                            <i class="bi bi-toggle-on me-2 text-secondary"></i>Trạng thái
                                        </th>
                                        <td>
                                            <span
                                                class="badge px-3 bg-{{ $company->status === 'active' ? 'success' : ($company->status === 'banned' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($company->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">
                                            <i class="bi bi-box-seam me-2 text-secondary"></i>Quota miễn phí
                                        </th>
                                        <td>
                                            <span class="fw-semibold">{{ $company->free_post_quota_used }} /
                                                {{ $company->free_post_quota }}</span>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-hourglass-split me-1"></i>Hết hạn:
                                                {{ $company->free_post_quota_expired_at ? $company->free_post_quota_expired_at->format('d/m/Y') : '—' }}
                                            </small>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">
                                            <i class="bi bi-clock-history me-2 text-secondary"></i>Ngày tạo
                                        </th>
                                        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">
                                            <i class="bi bi-arrow-repeat me-2 text-secondary"></i>Cập nhật
                                        </th>
                                        <td>{{ $company->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
