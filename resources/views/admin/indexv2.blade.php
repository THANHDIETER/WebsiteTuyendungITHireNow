@extends('admin.layouts.default')
@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4">
            <i class="bi bi-bar-chart-fill text-primary me-2"></i>
            Thống kê tổng quan
        </h2>

        {{-- Bộ lọc --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="this_month" {{ $filter == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                    <option value="last_month" {{ $filter == 'last_month' ? 'selected' : '' }}>Tháng trước</option>
                    <option value="this_year" {{ $filter == 'this_year' ? 'selected' : '' }}>Năm nay</option>
                    <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Tùy chọn</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>

        {{-- Thống kê nhanh --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted">Người dùng</h6>
                    <h3 class="fw-bold text-primary">{{ $totalUsers }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted">Việc làm</h6>
                    <h3 class="fw-bold text-success">{{ $totalJobs }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted">Đơn ứng tuyển</h6>
                    <h3 class="fw-bold text-warning">{{ $totalApplications }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted">Doanh thu</h6>
                    <h3 class="fw-bold text-danger">{{ number_format($totalRevenue) }}₫</h3>
                </div>
            </div>
        </div>

        {{-- Biểu đồ --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h6 class="fw-bold mb-3">Trạng thái việc làm</h6>
                    <canvas id="jobStatusChart" style="max-height:200px"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h6 class="fw-bold mb-3">Đơn ứng tuyển</h6>
                    <canvas id="applicationChart" style="max-height:200px"></canvas>
                </div>
            </div>
        </div>


        {{-- Bảng chi tiết --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="fw-bold mb-3">Việc làm theo ngành</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($jobsByCategory as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                {{ $item->category }}
                                <span class="fw-bold">{{ $item->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="fw-bold mb-3">Kỹ năng nổi bật</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($skills as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                {{ $item->skill }}
                                <span class="fw-bold">{{ $item->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ trạng thái việc làm
        new Chart(document.getElementById('jobStatusChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($jobStatus->keys()) !!},
                datasets: [{
                    data: {!! json_encode($jobStatus->values()) !!},
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                }]
            }
        });

        // Biểu đồ đơn ứng tuyển
        new Chart(document.getElementById('applicationChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($applicationsByStatus->keys()) !!},
                datasets: [{
                    data: {!! json_encode($applicationsByStatus->values()) !!},
                    backgroundColor: ['#0dcaf0', '#6610f2', '#fd7e14', '#6c757d']
                }]
            }
        });
    </script>
@endsection