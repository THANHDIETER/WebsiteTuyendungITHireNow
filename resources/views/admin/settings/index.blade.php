@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold text-primary">
            <i class="fas fa-sliders-h me-2"></i>Quản lý Cấu hình hệ thống
        </h2>

        {{-- Form thêm cấu hình --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="fas fa-plus-circle me-2"></i>Thêm hoặc cập nhật cấu hình
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
                                <i class="fas fa-save me-1"></i> Lưu
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
                    <i class="fas fa-database text-warning me-2"></i>Danh sách cấu hình
                </div>

               <form method="POST" action="{{ route('admin.settings.defaults') }}"
      class="d-inline needs-confirm-restore" data-message="Khôi phục tất cả cấu hình về mặc định?">
    @csrf
    <button class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-undo me-1"></i> Khôi phục mặc định
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
                                {{-- Form chỉnh sửa từng dòng --}}
                                <td>
                                    <form method="POST" action="{{ route('admin.settings.save') }}" class="d-flex gap-2 ">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $setting->key }}">
                                        <input type="text" name="name" value="{{ $setting->name }}"
                                            class="form-control form-control-sm">
                                </td>
                                <td class="text-muted"><code>{{ $setting->key }}</code></td>
                                <td>
                                    @if($setting->key === 'random_mode')
                                        <select name="value" class="form-select form-select-sm">
                                            <option value="alpha" {{ $setting->value === 'alpha' ? 'selected' : '' }}>Chỉ chữ (A-Z)
                                            </option>
                                            <option value="num" {{ $setting->value === 'num' ? 'selected' : '' }}>Chỉ số (0-9)
                                            </option>
                                            <option value="alphanum" {{ $setting->value === 'alphanum' ? 'selected' : '' }}>Chữ + Số
                                            </option>
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
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.settings.delete', $setting->id) }}" method="POST"
      class="d-inline needs-confirm-delete" data-message="Bạn có chắc muốn xoá cấu hình '{{ $setting->name }}'?">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-circle-info me-2"></i>Chưa có cấu hình nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showAlertModal({
                title: 'Thành công',
                message: '{{ session("success") }}',
                status: 'success',
                type: 'alert'
            });
        });
    </script>
@endif
@if(session('error'))
    <script>
        showAlertModal({
            title: 'Lỗi',
            message: '{{ session("error") }}',
            status: 'error',
            type: 'alert'
        });
    </script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Xác nhận form khôi phục mặc định
    document.querySelectorAll('form.needs-confirm-restore').forEach(function (formEl) {
        formEl.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = formEl.dataset.message || 'Bạn có chắc muốn khôi phục mặc định?';

            showAlertModal({
                title: 'Xác nhận khôi phục',
                message: message,
                status: 'warning',
                type: 'confirm',
                onConfirm: () => formEl.submit()
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form.needs-confirm-delete').forEach(function (formEl) {
        formEl.addEventListener('submit', function (e) {
            e.preventDefault(); // Chặn submit mặc định

            const message = formEl.dataset.message || 'Bạn có chắc chắn muốn xoá?';

            showAlertModal({
                title: 'Xác nhận xoá',
                message: message,
                status: 'warning',
                type: 'confirm',
                onConfirm: () => formEl.submit() // Nếu xác nhận, submit form
            });
        });
    });
});
</script>
