<div class="container py-4" style="max-width: 760px">
    <h2 class="h4 mb-4">
        <i class="fa fa-box text-primary me-2"></i> {{ isset($service_package) ? 'Cập nhật' : 'Thêm' }} Gói Dịch Vụ
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ isset($service_package)
        ? route('admin.service-packages.update', $service_package)
        : route('admin.service-packages.store') }}">
        @csrf
        @if(isset($service_package)) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-tag me-1"></i> Tên gói *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $service_package->name ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-dollar-sign me-1"></i> Giá (VND)</label>
                <input type="number" name="price" class="form-control" min="0"
                       value="{{ old('price', $service_package->price ?? 0) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-calendar me-1"></i> Số ngày sử dụng *</label>
                <input type="number" name="duration_days" class="form-control" min="1" required
                       value="{{ old('duration_days', $service_package->duration_days ?? 30) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-newspaper me-1"></i> Số bài đăng *</label>
                <input type="number" name="post_limit" class="form-control" min="1" required
                       value="{{ old('post_limit', $service_package->post_limit ?? 1) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-star me-1"></i> Số ngày hiển thị nổi bật</label>
                <input type="number" name="highlight_days" class="form-control" min="0"
                       value="{{ old('highlight_days', $service_package->highlight_days ?? 0) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-eye me-1"></i> Giới hạn xem CV</label>
                <input type="number" name="cv_view_limit" class="form-control" min="0"
                       value="{{ old('cv_view_limit', $service_package->cv_view_limit ?? 0) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-headset me-1"></i> Cấp độ hỗ trợ</label>
                <select name="support_level" class="form-select">
                    <option value="0" {{ old('support_level', $service_package->support_level ?? 0) == 0 ? 'selected' : '' }}>Thường</option>
                    <option value="1" {{ old('support_level', $service_package->support_level ?? 0) == 1 ? 'selected' : '' }}>Ưu tiên</option>
                    <option value="2" {{ old('support_level', $service_package->support_level ?? 0) == 2 ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fa fa-sort-numeric-up me-1"></i> Thứ tự hiển thị</label>
                <input type="number" name="sort_order" class="form-control" min="0"
                       value="{{ old('sort_order', $service_package->sort_order ?? 0) }}">
            </div>

            <div class="col-12">
                <label class="form-label"><i class="fa fa-align-left me-1"></i> Mô tả</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $service_package->description ?? '') }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                        {{ old('is_active', $service_package->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        <i class="fa fa-eye me-1"></i> Hiển thị gói dịch vụ
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fa fa-save me-1"></i> {{ isset($service_package) ? 'Cập nhật' : 'Tạo mới' }}
            </button>
        </div>
    </form>
</div>
