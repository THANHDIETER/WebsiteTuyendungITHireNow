<div class="p-2 rounded" style="background-color: var(--bs-body-bg); max-width: 100%;">
    <!-- Trạng thái -->
    <div class="mb-3 d-flex align-items-center gap-2">
        <h6 class="fw-bold mb-0 text-secondary">
            <i class="fa fa-toggle-on me-2 text-body"></i> Trạng thái:
        </h6>
        <span
            class="badge px-3 py-1 rounded-pill {{ $service_package->is_active ? 'bg-success text-white' : 'bg-secondary text-light' }}">
            <i class="fa {{ $service_package->is_active ? 'fa-check-circle' : 'fa-eye-slash' }} me-1"></i>
            {{ $service_package->is_active ? 'Hoạt động' : 'Ẩn' }}
        </span>
    </div>

    <!-- Thông tin chính và nâng cao -->
    <div class="d-flex flex-wrap gap-4 mb-4 justify-content-between">
        <!-- Cột trái -->
        <div class="flex-grow-1" style="min-width: 280px;">
            <h6 class="fw-bold text-secondary mb-3">
                <i class="fa fa-info-circle me-2 text-primary"></i> Thông tin chính
            </h6>
            <ul class="list-unstyled small mb-0">
                <li><span class="text-muted">Tên gói:</span> <strong>{{ $service_package->name }}</strong></li>
                <li><span class="text-muted">Giá:</span> {{ number_format($service_package->price) }} VND</li>
                <li><span class="text-muted">Số ngày sử dụng:</span> {{ $service_package->duration_days }}</li>
                <li><span class="text-muted">Số bài đăng:</span> {{ $service_package->post_limit }}</li>
            </ul>
        </div>

        <!-- Cột phải -->
        <div class="flex-grow-1" style="min-width: 280px;">
            <h6 class="fw-bold text-secondary mb-3">
                <i class="fa fa-star me-2 text-warning"></i> Nâng cao
            </h6>
            <ul class="list-unstyled small mb-0">
                <li><span class="text-muted">Hiển thị nổi bật:</span> {{ $service_package->highlight_days }}</li>
                <li><span class="text-muted">Giới hạn xem CV:</span> {{ $service_package->cv_view_limit }}</li>
                <li><span class="text-muted">Cấp độ hỗ trợ:</span> {{ $service_package->support_level ?? '—' }} </li>
                <li><span class="text-muted">Thứ tự hiển thị:</span> {{ $service_package->sort_order }}</li>
            </ul>
        </div>
    </div>

    <!-- Mô tả -->
    <div class="mb-4">
        <h6 class="fw-bold text-secondary mb-2">
            <i class="fa fa-align-left me-2 text-info"></i> Mô tả
        </h6>
        <div class="p-3 rounded" style="background-color: var(--bs-secondary-bg);">
            <p class="mb-0 small text-body">{{ $service_package->description ?: '—' }}</p>
        </div>
    </div>

    <!-- Thời gian -->
    <div class="pt-3 border-top text-muted small">
        <div><i class="fa fa-calendar-alt me-2"></i> Ngày tạo: {{ $service_package->created_at?->format('d/m/Y H:i') }}
        </div>
        <div><i class="fa fa-clock me-2"></i> Cập nhật: {{ $service_package->updated_at?->format('d/m/Y H:i') }}</div>
    </div>
</div>