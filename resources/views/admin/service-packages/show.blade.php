<div class="container py-3 px-2" >
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body px-4 py-4">

            <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                <!-- Thông tin chính -->
                <div>
                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="fa fa-info-circle me-1"></i> Thông tin chính
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li><span class="text-muted">Tên gói:</span> <strong>{{ $service_package->name }}</strong></li>
                        <li><span class="text-muted">Giá:</span> {{ number_format($service_package->price) }} VND</li>
                        <li><span class="text-muted">Số ngày sử dụng:</span> {{ $service_package->duration_days }}</li>
                        <li><span class="text-muted">Số bài đăng:</span> {{ $service_package->post_limit }}</li>
                    </ul>
                </div>

                <!-- Thông tin nâng cao -->
                <div>
                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="fa fa-star me-1 text-warning"></i> Nâng cao
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li><span class="text-muted">Hiển thị nổi bật:</span> {{ $service_package->highlight_days }}</li>
                        <li><span class="text-muted">Giới hạn xem CV:</span> {{ $service_package->cv_view_limit }}</li>
                        <li><span class="text-muted">Cấp độ hỗ trợ:</span>
                            @php $levels = ['Thường', 'Ưu tiên', 'VIP']; @endphp
                            {{ $levels[$service_package->support_level] ?? '—' }}
                        </li>
                        <li><span class="text-muted">Thứ tự hiển thị:</span> {{ $service_package->sort_order }}</li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <!-- Mô tả -->
            <div class="mb-4">
                <h6 class="fw-bold mb-2 text-secondary">
                    <i class="fa fa-align-left me-1"></i> Mô tả
                </h6>
                <p class="mb-0 text-body">{{ $service_package->description ?: '—' }}</p>
            </div>

            <!-- Trạng thái -->
            <div class="mb-4 d-flex align-items-center gap-2">
                <h6 class="fw-bold mb-0 text-secondary">
                    <i class="fa fa-toggle-on me-1"></i> Trạng thái:
                </h6>
                <span class="badge px-3 py-1 rounded-pill {{ $service_package->is_active ? 'bg-success' : 'bg-secondary' }}">
                    <i class="fa {{ $service_package->is_active ? 'fa-check-circle' : 'fa-eye-slash' }} me-1"></i>
                    {{ $service_package->is_active ? 'Hoạt động' : 'Ẩn' }}
                </span>
            </div>

            <!-- Thời gian -->
            <div class="border-top pt-3 text-muted small">
                <div><i class="fa fa-calendar-alt me-1"></i> Ngày tạo: {{ $service_package->created_at?->format('d/m/Y H:i') }}</div>
                <div><i class="fa fa-clock me-1"></i> Cập nhật: {{ $service_package->updated_at?->format('d/m/Y H:i') }}</div>
            </div>

        </div>
    </div>
</div>
