<div class="container-fluid py-2 px-2" style="max-width: 100%;">
    <form method="POST" action="{{ isset($service_package)
        ? route('admin.service-packages.update', $service_package)
        : route('admin.service-packages.store') }}">
        @csrf
        @if(isset($service_package)) @method('PUT') @endif

        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <!-- Hàng 1 -->
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-tag me-1 text-primary"></i> Tên gói *</label>
                <input type="text" name="name" class="form-control form-control-lg" autocomplete="off"
                       value="{{ old('name', $service_package->name ?? '') }}" required>
            </div>
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-dollar-sign me-1 text-success"></i> Giá (VND)</label>
                <input type="number" name="price" class="form-control form-control-lg" autocomplete="off"
                       value="{{ old('price', $service_package->price ?? 0) }}" min="0">
            </div>
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-calendar me-1 text-info"></i> Số ngày sử dụng *</label>
                <input type="number" name="duration_days" class="form-control form-control-lg"
                       value="{{ old('duration_days', $service_package->duration_days ?? 30) }}" min="1" required>
            </div>

            <!-- Hàng 2 -->
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-newspaper me-1 text-warning"></i> Số bài đăng *</label>
                <input type="number" name="post_limit" class="form-control form-control-lg"
                       value="{{ old('post_limit', $service_package->post_limit ?? 1) }}" min="1" required>
            </div>
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-star me-1 text-warning"></i> Số ngày nổi bật</label>
                <input type="number" name="highlight_days" class="form-control form-control-lg"
                       value="{{ old('highlight_days', $service_package->highlight_days ?? 0) }}" min="0">
            </div>
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-eye me-1 text-secondary"></i> Giới hạn xem CV</label>
                <input type="number" name="cv_view_limit" class="form-control form-control-lg"
                       value="{{ old('cv_view_limit', $service_package->cv_view_limit ?? 0) }}" min="0">
            </div>

            <!-- Hàng 3 -->
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-headset me-1 text-info"></i> Cấp độ hỗ trợ</label>
                <select name="support_level" class="form-select form-select-lg">
                    <option value="0" {{ old('support_level', $service_package->support_level ?? 0) == 0 ? 'selected' : '' }}>Thường</option>
                    <option value="1" {{ old('support_level', $service_package->support_level ?? 0) == 1 ? 'selected' : '' }}>Ưu tiên</option>
                    <option value="2" {{ old('support_level', $service_package->support_level ?? 0) == 2 ? 'selected' : '' }}>VIP</option>
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label fs-5"><i class="fa fa-sort-numeric-up me-1 text-muted"></i> Thứ tự hiển thị</label>
                <input type="number" name="sort_order" class="form-control form-control-lg"
                       value="{{ old('sort_order', $service_package->sort_order ?? 0) }}" min="0">
            </div>
            <div class="col-lg-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                           value="1" {{ old('is_active', $service_package->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fs-5 fw-semibold" for="is_active">
                        Hiển thị gói
                    </label>
                </div>
            </div>

            <!-- Hàng 4 - mô tả -->
            <div class="col-lg-12">
                <label class="form-label fs-5"><i class="fa fa-align-left me-1 text-body"></i> Mô tả</label>
                <textarea name="description" rows="2" class="form-control form-control-lg">{{ old('description', $service_package->description ?? '') }}</textarea>
            </div>

            <!-- Nút -->
            <div class="col-lg-12 text-end mt-4">
                <button type="submit" class="btn btn-lg btn-primary px-5">
                    <i class="fa fa-save me-1"></i> {{ isset($service_package) ? 'Cập nhật' : 'Tạo mới' }}
                </button>
            </div>
        </div>
    </form>
</div>
