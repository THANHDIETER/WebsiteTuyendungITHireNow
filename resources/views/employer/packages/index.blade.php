@extends('employer.layouts.default')

@section('content')
<main class="main-content">
    <div class="container py-3">
        <h2 class="mb-2 d-flex align-items-center gap-2">
            <i class="fas fa-boxes text-primary fs-3"></i>
            <span>Các gói dịch vụ đăng tin</span>
        </h2>

        {{-- Danh sách gói --}}
        @if ($packages->isEmpty())
            <div class="alert alert-info shadow-sm rounded-3">
                <i class="fas fa-info-circle me-1"></i>
                Hiện chưa có gói dịch vụ nào. Vui lòng liên hệ quản trị viên để được hỗ trợ.
            </div>
        @else
            <div class="position-relative">
                <div class="d-flex flex-nowrap overflow-auto gap-4 pb-3 px-1">
                    @foreach ($packages as $pkg)
                        <div class="card shadow-sm border border-light-subtle rounded-4 flex-shrink-0 package-card"
                             style="min-width: 360px; max-width: 98%;">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title fw-bold text-primary mb-2">
                                    <i class="fas fa-box-open me-2"></i> {{ $pkg->name }}
                                </h5>

                                <div class="mb-3 text-success h4 fw-bold d-flex align-items-center">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    {{ number_format($pkg->price, 0, ',', '.') }} VNĐ
                                </div>

                                <ul class="list-group list-group-flush mb-3 small">
                                    <li class="list-group-item px-0 border-0"><i class="fas fa-clock text-primary me-2"></i> Thời hạn: {{ $pkg->duration_days }} ngày</li>
                                    <li class="list-group-item px-0 border-0"><i class="fas fa-clipboard-list text-success me-2"></i> Số lượt đăng: {{ $pkg->post_limit }}</li>
                                    <li class="list-group-item px-0 border-0"><i class="fas fa-star text-warning me-2"></i> Nổi bật: {{ $pkg->highlight_days }} ngày</li>
                                </ul>

                                @if ($pkg->description)
                                    <p class="text-muted small flex-grow-1">{{ $pkg->description }}</p>
                                @endif

                                @if ($Bank)
                                    <a href="{{ route('employer.packages.purchase', $pkg->id) }}"
                                       class="btn btn-gradient-primary mt-auto w-100 rounded-pill fw-bold shadow-sm text-black">
                                        <i class="fas fa-shopping-cart me-2"></i> Mua ngay
                                    </a>
                                @else
                                    <div class="alert alert-warning text-center mt-auto w-100 rounded-pill fw-bold shadow-sm">
                                        Admin chưa cài thông tin thanh toán
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <hr>

        {{-- Lịch sử đơn --}}
        <h4 class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-history me-1 text-info"></i> Lịch sử thanh toán & đơn hàng
        </h4>

        @if($payments->isEmpty())
            <div class="alert alert-warning shadow-sm rounded-3">
                <i class="fas fa-exclamation-circle me-1"></i>
                Bạn chưa có hóa đơn nào.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle rounded-4 overflow-hidden shadow-sm text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gói</th>
                            <th>Số tiền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-muted">{{ $payment->id }}</td>
                                <td><span class="fw-semibold text-primary">{{ $payment->package->name ?? 'Không xác định' }}</span></td>
                                <td class="fw-bold text-success">{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                <td>{!! $payment->statusLabel() !!}</td>
                                <td>
                                    {{-- Nút chi tiết --}}
                                    <button class="btn btn-sm btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $payment->id }}">
                                        <i class="fas fa-eye">Xem</i>
                                    </button>

                                    {{-- Nếu pending thì cho phép thanh toán + hủy --}}
                                    @if($payment->status === 'pending')
                                        <a href="{{ route('employer.payment.show', $payment->id) }}"
                                           class="btn btn-sm btn-warning rounded-pill ms-1">
                                            <i class="bi bi-credit-card"></i>
                                        </a>
                                        <!-- <form action="{{ route('employer.payments.cancel', $payment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill ms-1"
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn này?');">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form> -->
                                    @endif
                                </td>
                            </tr>

                            {{-- Modal chi tiết --}}
                            <div class="modal fade" id="detailModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-receipt me-2"></i> Hóa đơn #{{ $payment->invoice_number }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-4">
                                                {{-- Gói --}}
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold"><i class="fas fa-box-open me-1"></i> Thông tin gói</h6>
                                                    @if($payment->package)
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><strong>Tên gói:</strong> {{ $payment->package->name }}</li>
                                                            <li class="list-group-item"><strong>Thời hạn:</strong> {{ $payment->package->duration_days }} ngày</li>
                                                            <li class="list-group-item"><strong>Lượt đăng:</strong> {{ $payment->package->post_limit }}</li>
                                                            <li class="list-group-item"><strong>Nổi bật:</strong> {{ $payment->package->highlight_days }} ngày</li>
                                                            <li class="list-group-item"><strong>Giá gốc:</strong> {{ number_format($payment->package->price, 0, ',', '.') }} VNĐ</li>
                                                        </ul>
                                                    @endif
                                                </div>
                                                {{-- Thanh toán --}}
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold"><i class="fas fa-credit-card me-1"></i> Thông tin thanh toán</h6>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Mã hóa đơn:</strong> {{ $payment->invoice_number }}</li>
                                                        <li class="list-group-item"><strong>Số tiền:</strong> {{ number_format($payment->amount, 0, ',', '.') }} VNĐ</li>
                                                        <li class="list-group-item"><strong>VAT:</strong> {{ $payment->vat_percent }}%</li>
                                                        <li class="list-group-item"><strong>Phương thức:</strong> {{ $payment->payment_method }}</li>
                                                        <li class="list-group-item"><strong>Cổng:</strong> {{ $payment->payment_gateway }}</li>
                                                        <li class="list-group-item"><strong>Mã giao dịch:</strong> {{ $payment->transaction_id ?? '---' }}</li>
                                                        <li class="list-group-item"><strong>Trạng thái:</strong> {!! $payment->statusLabel() !!}</li>
                                                        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</li>
                                                        @if($payment->paid_at)
                                                            <li class="list-group-item"><strong>Ngày thanh toán:</strong> {{ $payment->paid_at->format('d/m/Y H:i') }}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</main>
@endsection

@push('styles')
<style>
    .package-card {
        background: linear-gradient(145deg, #f8f9fc, #ffffff);
        border-radius: 1.2rem;
        border: 1px solid #dee2e6;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    }
    .package-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
        border-color: #0d6efd40;
    }
    .btn-gradient-primary {
        background-image: linear-gradient(to right, #0d6efd, #3b9bfd);
        color: #fff;
        border: none;
        transition: transform 0.2s ease;
    }
    .btn-gradient-primary:hover {
        transform: scale(1.05);
        opacity: 0.95;
        box-shadow: 0 0.75rem 1.5rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush
