@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-3">
            <h2 class="mb-2 d-flex align-items-center gap-2">
                <i class="fas fa-boxes text-primary fs-3"></i>
                <span>Các gói dịch vụ đăng tin</span>
            </h2>

            @if ($packages->isEmpty())
                <div class="alert alert-info shadow-sm rounded-3">
                    <i class="fas fa-info-circle me-1"></i>
                    Hiện chưa có gói dịch vụ nào. Vui lòng liên hệ quản trị viên để được hỗ trợ.
                </div>
            @else
                <div class="position-relative">
                    <div class="d-flex flex-nowrap overflow-auto gap-4 pb-3 px-1">
                        @foreach ($packages as $pkg)
                        

                            <div class="card shadow-sm border border-light-subtle rounded-4 flex-shrink-0 package-card animate__animated animate__fadeInUp"
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
                                        <li class="list-group-item px-0 border-0 d-flex align-items-start gap-2">
                                            <i class="fas fa-clock text-primary mt-1"></i>
                                            <div>
                                                <strong>Thời hạn:</strong> {{ $pkg->duration_days }} ngày
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 border-0 d-flex align-items-start gap-2">
                                            <i class="fas fa-clipboard-list text-success mt-1"></i>
                                            <div>
                                                <strong>Số lượt đăng:</strong> {{ $pkg->post_limit }} lượt
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 border-0 d-flex align-items-start gap-2">
                                            <i class="fas fa-star text-warning mt-1"></i>
                                            <div>
                                                <strong>Nổi bật:</strong> {{ $pkg->highlight_days }} ngày
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 border-0 d-flex align-items-start gap-2">
                                            <i class="fas fa-eye text-info mt-1"></i>
                                            <div>
                                                <strong>Lượt xem CV:</strong> {{ $pkg->cv_view_limit }}
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 border-0 d-flex align-items-start gap-2">
                                            <i class="fas fa-headset text-secondary mt-1"></i>
                                            <div>
                                                <strong>Hỗ trợ:</strong> {{ $pkg->support_level ?? 'Không có' }}
                                            </div>
                                        </li>
                                    </ul>

                                    @if ($pkg->description)
                                        <p class="text-muted small flex-grow-1">{{ $pkg->description }}</p>
                                    @else
                                        <div class="flex-grow-1"></div>
                                    @endif

                                   @if ($currentSubscription && $currentSubscription->id === $pkg->id)
                                     <a href="{{ route('employer.packages.purchase', $pkg->id) }}"
                                    class="btn btn-gradient-primary mt-auto w-100 rounded-pill fw-bold shadow-sm text-black">
                                        <i class="fas fa-shopping-cart me-2"></i> Mua ngay
                                    </a>
                                   <!-- <button class="btn btn-light border border-success text-success fw-semibold mt-auto w-100 rounded-pill" disabled>
                                        <i class="fas fa-check-circle me-1"></i>
                                    </button> -->
                                @else
                                    <a href="{{ route('employer.packages.purchase', $pkg->id) }}"
                                    class="btn btn-gradient-primary mt-auto w-100 rounded-pill fw-bold shadow-sm text-black">
                                        <i class="fas fa-shopping-cart me-2"></i> Mua ngay
                                    </a>
                                @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

            <hr>

            <h4 class="mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-history me-1 text-info"></i> Lịch sử đơn mua gói
            </h4>

            @if($payments->isEmpty())
                <div class="alert alert-warning shadow-sm rounded-3">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Bạn chưa mua gói nào.
                </div>
            @else
                <div class="table-responsive">
                    <table
                        class="table table-hover table-bordered align-middle rounded-4 overflow-hidden shadow-sm text-center">
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
                                    <td>
                                        <span
                                            class="fw-semibold text-primary">{{ $payment->package->name ?? 'Không xác định' }}</span>
                                    </td>
                                    <td class="fw-bold text-success">
                                        {{ number_format($payment->amount, 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>
                                        <span class="badge bg-dark text-uppercase">{{ $payment->payment_gateway }}</span>
                                    </td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{!! $payment->statusLabel() !!}</td>
                                    <td class="text-nowrap align-middle" style="width: 220px;">
                                        <button class="btn btn-sm btn-info rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal{{ $payment->id }}" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($payment->status === 'pending')
                                            <a href="{{ route('employer.payment.show', $payment->id) }}"
                                                class="btn btn-sm btn-warning rounded-circle ms-1" title="Thanh toán">
                                                <i class="fas fa-credit-card"></i>
                                            </a>
                                            <form action="{{ route('employer.payments.cancel', $payment->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle ms-1"
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn này?');" title="Hủy đơn">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @foreach($payments as $payment)
                    <div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="modalLabel{{ $payment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg animate__animated animate__fadeInDown">
                            <div class="modal-content shadow-lg rounded-4">
                                <div class="modal-header bg-primary text-white">
                                    <div class="d-flex align-items-center gap-3">
                                        <h5 class="modal-title mb-0" id="modalLabel{{ $payment->id }}">
                                            <i class="fas fa-receipt me-2"></i> Chi tiết thanh toán #{{ $payment->id }}
                                        </h5>
                                        <span class="ms-3">{!! $payment->statusLabel() !!}</span>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-2"><i class="fas fa-file-invoice me-1"></i> Thông tin đơn thanh
                                                toán</h6>
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
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-2"><i class="fas fa-box-open me-1"></i> Thông tin gói dịch vụ</h6>
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
                                    <hr>
                                    @if ($payment->package && $payment->package->description)
                                        <h6 class="text-muted"><i class="fas fa-align-left me-1"></i> Mô tả gói dịch vụ</h6>
                                        <div class="p-3 bg-light rounded border small">
                                            {{ $payment->package->description }}
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i> Cập nhật lúc:
                                        {{ $payment->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
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

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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

        .overflow-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 3px;
        }

        .overflow-auto:hover::-webkit-scrollbar-thumb {
            background: #6c757d;
        }
    </style>
@endpush
