@extends('employer.layouts.default')

@section('content')
    @php
        use Carbon\Carbon;
        use App\Models\Setting;

        $timeoutMinutes = (int) Setting::getValue('payment_timeout_minutes', 60);
        $expiresAt = Carbon::parse($payment->created_at)->addMinutes($timeoutMinutes);
    @endphp

    <div class="container py-4">
        <div class="alert alert-warning mt-4 rounded-3">
            <ul class="mb-0">
                <li>🔹 Chuyển khoản đúng <strong>số tiền & nội dung</strong> để được xử lý tự động.</li>
                <li>🔹 Thời gian xử lý giao dịch: <strong>1–5 phút</strong>.</li>
                <li>🔹 Nếu sau <strong>30 phút</strong> chưa nhận được tiền, hãy <a href="#">liên hệ hỗ trợ</a>.</li>
            </ul>
        </div>

        <div class="row d-flex align-items-stretch">
            {{-- Cột trái --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="card border-0 shadow-sm rounded-4 w-100 d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title mb-3">💳 Thông tin chuyển khoản</h5>

                        <p><strong>Số tiền:</strong>
                            <span class="text-success fw-bold fs-4">
                                {{ number_format($payment->amount, 0, ',', '.') }}đ
                            </span>
                        </p>

                        <p><strong>Ngân hàng:</strong> {{ $bankAccount->bank }}</p>

                        <p><strong>Số tài khoản:</strong>
                            <span class="text-danger fw-semibold">{{ $bankAccount->account_number }}</span>
                            <button onclick="copyToClipboard('{{ $bankAccount->account_number }}')"
                                class="btn btn-outline-secondary btn-sm ms-2">📋</button>
                        </p>

                        <p><strong>Chủ tài khoản:</strong>
                            <span class="text-danger text-uppercase fw-semibold">{{ $bankAccount->account_name }}</span>
                        </p>

                        <p><strong>Nội dung chuyển khoản:</strong>
                            <span class="fw-bold text-primary">{{ $payment->transaction_id }}</span>
                            <button onclick="copyToClipboard('{{ $payment->transaction_id }}')"
                                class="btn btn-outline-secondary btn-sm ms-2">📋</button>
                        </p>

                        <p><strong>Trạng thái:</strong> {!! $payment->statusLabel() !!}</p>

                        <a href="{{ route('employer.packages.index') }}" class="btn btn-outline-danger w-100 mt-3">
                            + Tạo hóa đơn mới
                        </a>
                    </div>
                </div>
            </div>

            {{-- Cột phải --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="card border-0 shadow-sm text-center rounded-4 w-100 d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title mb-3">📱 Quét mã QR để thanh toán</h5>

                        @if ($payment->payment_method === 'momo')
                            @php
                                $momoData = "2|99|{$bankAccount->account_number}|||0|0|{$payment->amount}|{$payment->transaction_id}|transfer_myqr";
                                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($momoData);
                            @endphp
                        @else
                            @php
                                $qrUrl = "https://api.vietqr.io/{$bankAccount->bank}/{$bankAccount->account_number}/{$payment->amount}/{$payment->transaction_id}/vietqr_net_2.jpg";
                            @endphp
                        @endif

                        <img src="{{ $qrUrl }}" alt="QR Code" class="img-fluid rounded mb-2" style="max-width: 200px;">
                        <br>
                        <button onclick="downloadImage('{{ $qrUrl }}', 'qr_code.png')" class="btn btn-link btn-sm">
                            ⬇️ Tải QR về máy
                        </button>

                        @if ($payment->status === 'pending')
                            <div id="countdown" class="mt-4 fs-4 fw-bold text-warning">
                                ⏳ <span id="minutes">--</span> PHÚT : <span id="seconds">--</span> GIÂY
                            </div>
                            <small class="text-muted d-block mt-1">Thời gian còn lại để thanh toán</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Countdown + kiểm tra trạng thái --}}
    <script>
        const expiresAt = new Date("{{ $expiresAt->toIso8601String() }}").getTime();
        const initialStatus = "{{ $payment->status }}";
        const isFinalStatus = ['paid', 'expired', 'failed', 'canceled'].includes(initialStatus);
        let expiredNotified = false;
        let paidNotified = false;

        function updateCountdown() {
            if (isFinalStatus) return;
            const now = Date.now();
            let timeLeft = Math.floor((expiresAt - now) / 1000);
            const el = document.getElementById('countdown');

            if (timeLeft <= 0 && !expiredNotified) {
                el.innerHTML = "⛔ ĐÃ HẾT HẠN";
                el.classList.remove('text-warning');
                el.classList.add('text-danger');
                expiredNotified = true;

                showAlertModal({
                    title: 'Hết thời gian thanh toán',
                    message: 'Hóa đơn của bạn đã hết hạn sau 60 phút. Vui lòng tạo hóa đơn mới.',
                    status: 'warning',
                    type: 'alert',
                });
                return;
            }

            let min = Math.floor(timeLeft / 60);
            let sec = timeLeft % 60;
            document.getElementById('minutes').textContent = String(min).padStart(2, '0');
            document.getElementById('seconds').textContent = String(sec).padStart(2, '0');
        }

        if (!isFinalStatus) {
            setInterval(updateCountdown, 1000);
            updateCountdown();
        }

        // Kiểm tra trạng thái thanh toán mỗi 3 giây
        setInterval(() => {
            fetch("{{ route('employer.payments.check', $payment->id) }}")
                .then(res => res.json())
                .then(data => {
                    const status = data.status;

                    if (status === 'paid' && !paidNotified) {
                        paidNotified = true;
                        showAlertModal({
                            title: 'Thanh toán thành công',
                            message: 'Bạn đã thanh toán thành công. Hệ thống sẽ chuyển hướng...',
                            status: 'success',
                            type: 'alert',
                            onConfirm: () => {
                                window.location.href = "{{ route('employer.packages.index') }}";
                            }
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('employer.packages.index') }}";
                        }, 5000);
                    }

                    if (status === 'expired' && !expiredNotified) {
                        expiredNotified = true;
                        document.getElementById('countdown').innerHTML = "⛔ ĐÃ HẾT HẠN";
                        showAlertModal({
                            title: 'Hết hạn',
                            message: 'Thanh toán không thành công do quá thời gian quy định.',
                            status: 'warning',
                            type: 'alert',
                            onConfirm: () => {
                                window.location.href = "{{ route('employer.packages.index') }}";
                            }
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('employer.packages.index') }}";
                        }, 5000);
                    }

                    if (status === 'failed') {
                        showAlertModal({
                            title: 'Thanh toán thất bại',
                            message: 'Có lỗi trong quá trình xử lý giao dịch.',
                            status: 'error',
                            type: 'alert',
                            onConfirm: () => {
                                window.location.href = "{{ route('employer.packages.index') }}";
                            }
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('employer.packages.index') }}";
                        }, 5000);
                    }

                    if (status === 'canceled') {
                        showAlertModal({
                            title: 'Hóa đơn đã bị hủy',
                            message: 'Bạn đã hủy hóa đơn thanh toán này.',
                            status: 'warning',
                            type: 'alert',
                            onConfirm: () => {
                                window.location.href = "{{ route('employer.packages.index') }}";
                            }
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('employer.packages.index') }}";
                        }, 5000);
                    }
                })
                .catch(err => console.error('Lỗi kiểm tra trạng thái:', err));
        }, 3000);

        // Sao chép vào clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showAlertModal({
                    title: 'Đã sao chép',
                    message: 'Nội dung đã được sao chép vào clipboard.',
                    status: 'info',
                    type: 'alert',
                });
            });
        }

        // Tải ảnh QR
        function downloadImage(url, filename) {
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const blobUrl = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = blobUrl;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(blobUrl);
                })
                .catch(() => {
                    showAlertModal({
                        title: 'Lỗi tải QR',
                        message: 'Không thể tải mã QR. Vui lòng thử lại.',
                        status: 'error',
                        type: 'alert',
                    });
                });
        }
    </script>
@endsection
