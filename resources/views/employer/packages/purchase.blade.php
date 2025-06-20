@extends('employer.layouts.default')

@section('content')
<main class="main-content mb-3" class="bg-white">
  <div class="container">
    <!-- Header -->
    <div class="text-center mb-3 mt-3">
      <h1 class="display-5 fw-bold text-primary">Thanh toán gói <span class="text-dark">{{ $package->name }}</span></h1>
    </div>
    <div class="row gx-5 gy-4">
      <!-- Package Summary -->
      <div class="col-xl-4 col-lg-5">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="overflow: hidden;">
          <div style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
                      height:120px; clip-path: polygon(0 0, 100% 0%, 100% 70%, 0 100%);"></div>
          <div class="card-body d-flex flex-column pt-0 px-4">
            <div class="text-center mt-n5">
              <h4 class="fw-bold text-white bg-primary px-3 py-2 rounded-pill shadow-sm d-inline-block">
                {{ $package->name }}
              </h4>
            </div>

            <!-- ✅ Giá + VAT + Tổng -->
            <div class="text-center my-2">
              <h2 class="fw-bold text-success mb-1">{{ number_format($package->price) }} VNĐ</h2>
              <p class="text-muted mb-1" style="font-size: 0.9rem;">
                Thuế VAT ({{ $vat }}%): <strong>{{ number_format($vatAmount) }} VNĐ</strong>
              </p>
              <p class="fw-semibold" style="font-size: 1rem;">
                Tổng thanh toán: <span class="text-primary">{{ number_format($totalWithVat) }} VNĐ</span>
              </p>
            </div>

            @if($package->description)
            <p class="text-center text-muted mb-2" style="font-size: .95rem;">
              {{ $package->description }}
            </p>
            @endif

            <div class="table-responsive">
              <table class="table table-sm table-borderless text-muted">
                <tbody>
                  <tr>
                    <th><i class="fa fa-clock text-primary me-2"></i>Thời hạn</th>
                    <td>{{ $package->duration_days }} ngày</td>
                  </tr>
                  <tr>
                    <th><i class="fa fa-bullhorn text-success me-2"></i>Lượt đăng</th>
                    <td>{{ $package->post_limit }} tin</td>
                  </tr>
                  <tr>
                    <th><i class="fa fa-star text-warning me-2"></i>Làm nổi bật</th>
                    <td>{{ $package->highlight_days }} ngày</td>
                  </tr>
                  <tr>
                    <th><i class="fa fa-eye text-info me-2"></i>Lượt xem hồ sơ</th>
                    <td>{{ $package->cv_view_limit }} lượt</td>
                  </tr>
                  <tr>
                    <th><i class="fa fa-headset text-secondary me-2"></i>Hỗ trợ</th>
                    <td>{{ $package->support_level }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Form -->
      <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm h-100 rounded-4">
          <div class="card-body p-4 d-flex flex-column">
            <h4 class="fw-semibold mb-4">Chọn phương thức thanh toán</h4>
            <form id="paymentForm" action="{{ route('employer.packages.subscribe', $package->id) }}" method="POST"
              class="d-flex flex-column flex-grow-1">
              @csrf

              <div class="row g-4 mb-4">
                @foreach($bankAccounts as $bank)
                <div class="col-md-6 col-xl-4">
                  <label class="d-flex flex-column align-items-center p-3 bg-white border rounded-4 hover-shadow text-center"
                    style="cursor:pointer;">
                    <input class="form-check-input mb-2" type="radio" name="bank" value="{{ $bank->id }}"
                      {{ $loop->first ? 'checked' : '' }}>
                    @if($bank->image)
                    <img src="{{ asset('storage/' . $bank->image) }}" alt="{{ $bank->bank }}" class="mb-2"
                      style="height: 40px; object-fit: contain;">
                    @else
                    <div class="mb-2" style="height: 40px;"></div>
                    @endif
                    <span class="fw-medium">{{ $bank->bank }}</span>
                  </label>
                </div>
                @endforeach
              </div>

              <div class="mt-auto d-flex justify-content-end">
                <a href="{{ route('employer.packages.index') }}"
                  class="btn btn-outline-secondary me-3 rounded-pill px-4">Quay lại</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">Thanh toán</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@push('styles')
<style>
  .hover-shadow:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.075);
    transform: translateY(-4px);
    transition: all 0.3s ease;
  }
</style>
@endpush

@push('scripts')

<script>
  function showAlertModal({
    title = 'Thông báo',
    message = '',
    type = 'confirm',
    status = 'info',
    onConfirm = () => {}
  }) {
    if (type === 'confirm') {
      Swal.fire({
        title: title,
        html: message,
        icon: status,
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        customClass: {
          confirmButton: 'btn btn-primary mx-2',
          cancelButton: 'btn btn-outline-secondary'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          onConfirm();
        }
      });
    } else {
      Swal.fire({
        title: title,
        html: message,
        icon: status,
        confirmButtonText: 'Đóng',
        customClass: {
          confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
      });
    }
  }

  // ✅ Thêm đoạn này để chặn submit và xác nhận trước
  document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', function (e) {
      e.preventDefault(); // chặn submit mặc định

      showAlertModal({
        title: 'Xác nhận thanh toán',
        message: 'Bạn có chắc chắn muốn thanh toán gói không?',
        type: 'confirm',
        status: 'question',
        onConfirm: () => {
          paymentForm.submit(); // chỉ submit nếu người dùng xác nhận
        }
      });
    });
  });
</script>


@endpush('scripts')

