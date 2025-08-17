@extends('admin.settings.layout')

@section('settings-content')
    <h2 class="mb-4 fw-bold text-primary">
        <i class="bi bi-sliders me-2"></i> Quản lý Cấu hình hệ thống
    </h2>

    {{-- Form thêm cấu hình --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-plus-circle me-2"></i> Thêm hoặc cập nhật cấu hình
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label mb-0">Tên cấu hình</label>
                        <input name="name" class="form-control" placeholder="VD: Thuế VAT">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label mb-0">Key</label>
                        <input name="key" class="form-control" placeholder="VD: vat_rate" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-0">Giá trị</label>
                        <input name="value" class="form-control" placeholder="VD: 5">
                    </div>
                    <div class="col-md-1 d-grid">
                        <label class="form-label invisible">Lưu</label>
                        <button class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Lưu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách cấu hình --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-semibold d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-database me-2 text-warning"></i> Danh sách cấu hình
            </div>

            <form method="POST" action="{{ route('admin.settings.defaults') }}"
                  class="d-inline needs-confirm-restore"
                  data-message="Khôi phục tất cả cấu hình về mặc định?">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Khôi phục mặc định
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="align-middle text-center">
                        <th>#</th>
                        <th>Tên</th>
                        <th>Key</th>
                        <th>Giá trị</th>
                        <th></th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td>{{ $setting->id }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.settings.save') }}" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $setting->key }}">
                                    <input type="text" name="name" value="{{ $setting->name }}"
                                           class="form-control form-control-sm">
                            </td>
                            <td class="text-muted"><code>{{ $setting->key }}</code></td>
                            <td>
                                @if($setting->key === 'random_mode')
                                    <select name="value" class="form-select form-select-sm">
                                        <option value="alpha" {{ $setting->value === 'alpha' ? 'selected' : '' }}>Chỉ chữ</option>
                                        <option value="num" {{ $setting->value === 'num' ? 'selected' : '' }}>Chỉ số</option>
                                        <option value="alphanum" {{ $setting->value === 'alphanum' ? 'selected' : '' }}>Chữ + Số</option>
                                    </select>
                                @elseif($setting->key === 'random_length')
                                    <input type="number" name="value" value="{{ $setting->value }}"
                                           class="form-control form-control-sm" min="6" max="20" required>
                                @else
                                    <input type="text" name="value" value="{{ $setting->value }}"
                                           class="form-control form-control-sm">
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.settings.delete', $setting->id) }}" method="POST"
                                      class="d-inline needs-confirm-delete"
                                      data-message="Bạn có chắc muốn xoá cấu hình '{{ $setting->name }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i> Chưa có cấu hình nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
