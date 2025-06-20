@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold">
            <i class="fas fa-sliders-h me-2 text-primary"></i>Quản lý Cấu hình hệ thống
        </h2>
        <div class="mb-3">
            <form method="POST" action="{{ route('admin.settings.defaults') }}"
                onsubmit="return confirm('Khôi phục lại tất cả cấu hình về mặc định?')">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-undo me-1"></i> Khôi phục mặc định
                </button>
            </form>
        </div>

        {{-- Flash success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        {{-- Thêm mới cấu hình --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="fas fa-plus-circle text-success me-2"></i>Thêm / Cập nhật cấu hình mới
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.save') }}">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <input name="name" class="form-control" placeholder="Tên cấu hình (vd: Thuế VAT)">
                        </div>
                        <div class="col-md-3">
                            <input name="key" class="form-control" placeholder="Key (vd: vat_rate)" required>
                        </div>
                        <div class="col-md-4">
                            <input name="value" class="form-control" placeholder="Giá trị (vd: 5)">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Lưu
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danh sách cấu hình --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light fw-semibold">
                <i class="fas fa-database text-warning me-2"></i>Danh sách cấu hình
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên cấu hình</th>
                            <th>Key</th>
                            <th>Giá trị</th>
                            <th>Cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                            <tr>
                                <td>{{ $setting->id }}</td>

                                {{-- Form sửa --}}
                                <td>
                                    <form method="POST" action="{{ route('admin.settings.save') }}"
                                        class="d-flex gap-2 align-items-center">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $setting->key }}">
                                        <input type="text" name="name" value="{{ $setting->name }}"
                                            class="form-control form-control-sm" placeholder="Tên cấu hình">
                                </td>

                                <td class="align-middle">
                                    <code class="text-muted">{{ $setting->key }}</code>
                                </td>

                                <td>
                                    {{-- Nếu là random_mode: dùng select --}}
                                    @if($setting->key === 'random_mode')
                                        <select name="value" class="form-select form-select-sm">
                                            <option value="alpha" {{ $setting->value === 'alpha' ? 'selected' : '' }}>Chỉ chữ (A-Z)
                                            </option>
                                            <option value="num" {{ $setting->value === 'num' ? 'selected' : '' }}>Chỉ số (0-9)
                                            </option>
                                            <option value="alphanum" {{ $setting->value === 'alphanum' ? 'selected' : '' }}>Chữ + Số
                                                (A1B2...)</option>
                                        </select>
                                        {{-- Nếu là random_length: input number + min/max --}}
                                    @elseif($setting->key === 'random_length')
                                        <input type="number" name="value" value="{{ $setting->value }}"
                                            class="form-control form-control-sm" min="6" max="20" required
                                            placeholder="Từ 6 đến 20">
                                    @else
                                        <input type="text" name="value" value="{{ $setting->value }}"
                                            class="form-control form-control-sm" placeholder="Giá trị">
                                    @endif
                                </td>

                                <td class="align-middle">
                                    <button class="btn btn-success btn-sm me-1">
                                        <i class="fas fa-check-circle me-1"></i> Lưu
                                    </button>
                                    </form>
                                </td>

                                <td class="align-middle">
                                    <form action="{{ route('admin.settings.delete', $setting->id) }}" method="POST"
                                        onsubmit="return confirm('Xoá cấu hình này?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt me-1"></i> Xoá
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-circle-info me-1"></i>Chưa có cấu hình nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection