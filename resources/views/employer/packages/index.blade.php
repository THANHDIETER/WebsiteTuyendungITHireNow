@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-3">
            <h2 class="mb-4"><i class="fas fa-boxes"></i> Các gói dịch vụ đăng tin</h2>

            @if ($packages->isEmpty())
                <div class="alert alert-info">
                    Hiện chưa có gói dịch vụ nào. Vui lòng liên hệ quản trị viên để được hỗ trợ.
                </div>
            @else
                <div class="row">
                    @foreach ($packages as $pkg)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow rounded-4 border-0">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-semibold text-primary">
                                        <i class="fas fa-cube me-1"></i> {{ $pkg->name }}
                                    </h5>
                                    <div class="text-success h4 mb-3">
                                        <i class="fas fa-money-bill-wave me-1"></i>
                                        {{ number_format($pkg->price, 0, ',', '.') }} VNĐ
                                    </div>

                                    <ul class="list-unstyled small mb-3">
                                        <li><i class="fas fa-clock me-1"></i> <strong>Thời hạn:</strong> {{ $pkg->duration_days }}
                                            ngày</li>
                                        <li><i class="fas fa-clipboard-list me-1"></i> <strong>Lượt đăng:</strong>
                                            {{ $pkg->post_limit }}</li>
                                    </ul>

                                    @if ($pkg->description)
                                        <p class="text-muted flex-grow-1">{{ $pkg->description }}</p>
                                    @endif

                                    @if ($currentSubscription && $currentSubscription->id === $pkg->id)
                                        <button class="btn btn-success mt-auto w-100" disabled>
                                            <i class="fas fa-check-circle me-1"></i> Đang sử dụng
                                        </button>
                                    @else
                                        <a href="{{ route('employer.packages.purchase', $pkg->id) }}"
                                            class="btn btn-outline-primary mt-auto w-100">
                                            <i class="fas fa-shopping-cart me-1"></i> Mua ngay
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <hr class="my-4">

            <h4 class="mb-3"><i class="fas fa-history me-1"></i> Lịch sử đơn mua gói</h4>

            @if($payments->isEmpty())
                <div class="alert alert-warning">Bạn chưa mua gói nào.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Gói</th>
                                <th>Số tiền</th>
                                <th>Phương thức</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td class="text-muted">{{ $payment->id }}</td>
                                    <td>{{ $payment->package->name ?? 'Không xác định' }}</td>
                                    <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                                    <td><span class="text-uppercase">{{ $payment->payment_gateway }}</span></td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{!! $payment->statusLabel() !!}</td>
                                    <td class="text-nowrap  align-middle" style="width: 200px;">
                                        <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal{{ $payment->id }}">
                                            <i class="fas fa-eye me-1"></i> Chi tiết
                                        </button>

                                        @if ($payment->status === 'pending')
                                            <a href="{{ route('employer.payment.show', $payment->id) }}"
                                                class="btn btn-sm btn-warning mb-1">
                                                <i class="fas fa-credit-card me-1"></i> Thanh toán
                                            </a>

                                            <form action="{{ route('employer.payments.cancel', $payment->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn này?');">
                                                    <i class="fas fa-times-circle me-1"></i> Hủy
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Các modal chi tiết -->
                @foreach($payments as $payment)
                    <div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="modalLabel{{ $payment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content shadow rounded-4">
                                <div class="modal-header bg-primary text-white">
                                    <div class="d-flex align-items-center #modal-title-container">
                                        <h5 class="modal-title mb-0" id="modalLabel{{ $payment->id }}">
                                            <i class="fas fa-receipt me-2"></i> Chi tiết thanh toán #{{ $payment->id }}
                                        </h5>
                                        <span class="ms-5">{!! $payment->statusLabel() !!}</span>
                                    </div>

                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Đóng"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">
                                        <!-- Cột 1: Thông tin thanh toán -->
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-file-invoice me-1"></i> Thông tin đơn thanh toán</h6>
                                            <ul class="list-group list-group-flush mb-3">
                                                <li class="list-group-item"><strong>Tên gói:</strong>
                                                    {{ $payment->package->name ?? 'Đã xóa' }}</li>
                                                <li class="list-group-item"><strong>Số tiền:</strong>
                                                    {{ number_format($payment->amount, 0, ',', '.') }} VNĐ</li>
                                                <li class="list-group-item"><strong>VAT:</strong> {{ $payment->vat_percent }}%</li>
                                                <li class="list-group-item"><strong>Phương thức:</strong>
                                                    {{ strtoupper($payment->payment_method) }}</li>
                                                <li class="list-group-item"><strong>Mã giao dịch:</strong>
                                                    {{ $payment->transaction_id ?? 'Chưa có' }}</li>
                                                <li class="list-group-item"><strong>Ngày tạo:</strong>
                                                    {{ $payment->created_at->format('d/m/Y H:i') }}</li>
                                                @if ($payment->paid_at)
                                                    <li class="list-group-item"><strong>Ngày thanh toán:</strong>
                                                        {{ $payment->paid_at->format('d/m/Y H:i') }}</li>
                                                @endif
                                            </ul>
                                        </div>

                                        <!-- Cột 2: Thông tin gói dịch vụ -->
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-box-open me-1"></i> Thông tin gói dịch vụ</h6>
                                            @if ($payment->package)
                                                <ul class="list-group list-group-flush mb-3">
                                                    <li class="list-group-item"><strong><i class="fas fa-cube me-1"></i> Tên
                                                            gói:</strong> {{ $payment->package->name }}</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-calendar-check me-1"></i> Thời
                                                            hạn:</strong> {{ $payment->package->duration_days }} ngày</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-list-ol me-1"></i> Lượt
                                                            đăng:</strong> {{ $payment->package->post_limit }}</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-star me-1"></i> Ngày làm nổi
                                                            bật:</strong> {{ $payment->package->highlight_days }}</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-eye me-1"></i> Giới hạn xem
                                                            CV:</strong> {{ $payment->package->cv_view_limit }}</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-headset me-1"></i> Hỗ
                                                            trợ:</strong> {{ $payment->package->support_level ?? 'Không có' }}</li>
                                                    <li class="list-group-item"><strong><i class="fas fa-toggle-on me-1"></i> Kích
                                                            hoạt:</strong> {{ $payment->package->is_active ? 'Có' : 'Không' }}</li>
                                                </ul>
                                            @else
                                                <div class="alert alert-warning">Gói đã bị xóa hoặc không tồn tại.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Phân cách -->
                                    <hr>

                                    <!-- Mô tả gói dịch vụ -->
                                    @if ($payment->package && $payment->package->description)
                                        <h6 class="text-muted"><i class="fas fa-align-left me-1"></i> Mô tả gói dịch vụ</h6>

                                        <div class="p-3 bg-light rounded border">
                                            {{ $payment->package->description }}
                                        </div>
                                    @endif
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i> Cập nhật lúc:
                                        {{ $payment->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Đóng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



            @endif
        </div>
    </main>
@endsection