@extends('employer.layouts.default')

@section('content')
<main class="main-content" class="bg-white">
  <div class="container">
    <!-- Header -->
    <div class="text-center mb-3 mt-3">
      <h1 class="display-5 fw-bold text-primary">Thanh toán gói <span class="text-dark">{{ $package->name }}</span></h1>
      <p class="text-muted lead">Hoàn tất thanh toán để kích hoạt dịch vụ ngay hôm nay.</p>
    </div>

    <div class="row gx-5 gy-4">
      <!-- Package Summary -->
      <div class="col-xl-4 col-lg-5">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="overflow: hidden;">
          <div style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); height:120px;
                      clip-path: polygon(0 0, 100% 0%, 100% 70%, 0 100%);"></div>
          <div class="card-body d-flex flex-column pt-0 px-4">
            <div class="text-center mt-n5">
              <h4 class="fw-bold text-white bg-primary px-3 py-2 rounded-pill shadow-sm d-inline-block">{{ $package->name }}</h4>
            </div>
            <div class="text-center my-4">
              <h2 class="fw-bold text-success mb-1">{{ number_format($package->price) }} VNĐ</h2>
              <small class="text-muted">Giá gói dịch vụ</small>
            </div>
            @if($package->description)
              <p class="text-center text-muted mb-4" style="font-size: .95rem;">
                {{ Str::limit($package->description, 120) }}
              </p>
            @endif
            <div class="mt-auto">
              <div class="row text-center">
                <div class="col-6">
                  <i class="bi bi-calendar-check fs-2 text-info"></i>
                  <p class="mt-2 mb-0"><strong>{{ $package->duration_days }} ngày</strong></p>
                  <small class="text-secondary">Thời hạn</small>
                </div>
                <div class="col-6">
                  <i class="bi bi-journal-text fs-2 text-warning"></i>
                  <p class="mt-2 mb-0"><strong>{{ $package->post_limit }} tin</strong></p>
                  <small class="text-secondary">Lượt đăng</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Form -->
      <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm h-100 rounded-4">
          <div class="card-body p-4 d-flex flex-column">
            <h4 class="fw-semibold mb-4">Chọn phương thức thanh toán</h4>
            <form id="paymentForm" action="{{ route('employer.packages.subscribe', $package->id) }}" method="POST" class="d-flex flex-column flex-grow-1">
              @csrf
              <div class="row g-3 mb-4">
                @foreach(['VCB'=>'Vietcombank','TCB'=>'Techcombank','ACB'=>'ACB','MBB'=>'MB Bank','SCB'=>'Sacombank'] as $code => $name)
                  <div class="col-md-4 col-sm-6">
                    <label class="d-flex align-items-center p-3 bg-white border rounded-3 hover-shadow" style="cursor:pointer;">
                      <input class="form-check-input me-2" type="radio" name="bank" value="{{ $code }}" {{ $loop->first ? 'checked' : '' }}>
                      <span class="fw-medium">{{ $name }}</span>
                    </label>
                  </div>
                @endforeach
              </div>

              <div class="mt-auto d-flex justify-content-end">
                <a href="{{ route('employer.packages.index') }}" class="btn btn-outline-secondary me-3 rounded-pill px-4">Quay lại</a>
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
  /* Hover effect on cards and options */
  .hover-shadow:hover {
    box-shadow: 0 12px 24px rgba(0,0,0,0.075);
    transform: translateY(-4px);
    transition: all 0.3s ease;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Xác nhận thanh toán',
      html: `Bạn chắc chắn muốn thanh toán gói <strong>{{ $package->name }}</strong> với giá <strong>{{ number_format($package->price) }} VNĐ</strong>?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Xác nhận',
      cancelButtonText: 'Hủy',
      customClass: {
        confirmButton: 'btn btn-primary mx-2',
        cancelButton: 'btn btn-outline-secondary'
      },
      buttonsStyling: false
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Thành công!',
          text: 'Bạn đã thanh toán thành công gói dịch vụ.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => e.target.submit());
      }
    });
  });
</script>
@endpush
