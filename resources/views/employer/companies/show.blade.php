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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('employer.companies.index') }}" class="btn btn-outline-secondary me-3"
                            title="Quay lại">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h2 class="mb-0">{{ $company->name }}</h2>
                    </div>
                    <div>
                        <a href="{{ route('employer.companies.edit', $company) }}" class="btn btn-sm btn-warning me-2">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <form action="{{ route('employer.companies.destroy', $company) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc muốn xóa công ty này?')">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Main Content: Basic Info + Scrollable Description/Benefits --}}
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-info-circle me-2 text-primary"></i> Thông tin cơ
                                    bản</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="bi bi-globe me-2"></i><strong>Website:</strong>
                                        @if ($company->website)
                                            <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                        @else
                                            —
                                        @endif
                                    </li>
                                    <li class="mb-2"><i class="bi bi-envelope me-2"></i><strong>Email:</strong>
                                        {{ $company->email ?? '—' }}</li>
                                    <li class="mb-2"><i class="bi bi-phone me-2"></i><strong>Điện thoại:</strong>
                                        {{ $company->phone ?? '—' }}</li>
                                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><strong>Địa chỉ:</strong>
                                        {{ $company->address ?? '—' }}</li>
                                    <li class="mb-2"><i class="bi bi-building me-2"></i><strong>Thành phố:</strong>
                                        {{ $company->city ?? '—' }}</li>
                                    <li class="mb-2"><i class="bi bi-people me-2"></i><strong>Quy mô:</strong>
                                        {{ $company->company_size ?? '—' }}</li>
                                    <li class="mb-2"><i class="bi bi-calendar-event me-2"></i><strong>Năm thành
                                            lập:</strong> {{ $company->founded_year ?? '—' }}</li>
                                    <li><i class="bi bi-briefcase me-2"></i><strong>Ngành:</strong>
                                        {{ $company->industry ?? '—' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-card-text me-2 text-secondary"></i> Mô tả &amp;
                                    Phúc lợi</h5>
                                {{-- Scrollable mô tả --}}
                                <div class="mb-3">
                                    <h6>Mô tả</h6>
                                    <div class="border p-2 rounded" style="max-height:150px; overflow-y:auto;">
                                        <p class="text-muted small mb-0">{!! nl2br(e($company->description)) !!}</p>
                                    </div>
                                </div>
                                {{-- Scrollable phúc lợi --}}
                                <div>
                                    <h6>Phúc lợi</h6>
                                    <div class="border p-2 rounded" style="max-height:150px; overflow-y:auto;">
                                        @if (is_array($company->benefits) && count($company->benefits))
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($company->benefits as $item)
                                                    <li class="mb-1"><span
                                                            class="badge bg-light text-dark border">{{ $item }}</span>
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
                        <h5 class="card-title mb-3"><i class="bi bi-gear me-2 text-info"></i> Thông tin hệ thống</h5>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 align-middle">
                                <tbody>
                                    <tr>
                                        <th scope="row">Xác thực</th>
                                        <td>{{ $company->is_verified ? 'Đã xác thực' : 'Chưa xác thực' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Trạng thái</th>
                                        <td><span
                                                class="badge bg-{{ $company->status === 'active' ? 'success' : ($company->status === 'banned' ? 'danger' : 'secondary') }}">{{ ucfirst($company->status) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Quota miễn phí</th>
                                        <td>
                                            {{ $company->free_post_quota_used }} / {{ $company->free_post_quota }}
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-hourglass-split"></i> Hết hạn:
                                                {{ $company->free_post_quota_expired_at ? $company->free_post_quota_expired_at->format('d/m/Y') : '—' }}
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ngày tạo</th>
                                        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Cập nhật</th>
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
