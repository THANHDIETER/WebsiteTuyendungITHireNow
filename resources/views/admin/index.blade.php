@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📊 Thống kê hệ thống</h3>

    <!-- Bộ lọc thời gian -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">🔍 Bộ lọc thời gian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="dateFrom" class="form-label">Từ ngày:</label>
                            <input type="date" class="form-control" id="dateFrom" name="dateFrom">
                        </div>
                        <div class="col-md-3">
                            <label for="dateTo" class="form-label">Đến ngày:</label>
                            <input type="date" class="form-control" id="dateTo" name="dateTo">
                        </div>
                        <div class="col-md-3">
                            <label for="filterType" class="form-label">Loại thống kê:</label>
                            <select class="form-control" id="filterType">
                                <option value="all">Tất cả</option>
                                <option value="users">Người dùng</option>
                                <option value="jobs">Việc làm</option>
                                <option value="applications">Ứng tuyển</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-primary me-2" onclick="applyFilter()">
                                <i class="fas fa-filter"></i> Lọc
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetFilter()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5" id="stats">
        <!-- Thống kê người dùng -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Ứng viên</div>
                <div class="card-body">
                    <h5 class="card-title" id="seeker-count">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Nhà tuyển dụng</div>
                <div class="card-body">
                    <h5 class="card-title" id="employer-count">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Admin</div>
                <div class="card-body">
                    <h5 class="card-title" id="admin-count">0</h5>
                </div>
            </div>
        </div>

        <!-- Thống kê việc làm -->
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Việc làm đang hoạt động</div>
                <div class="card-body">
                    <h5 class="card-title" id="active-jobs">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Việc làm đã đóng</div>
                <div class="card-body">
                    <h5 class="card-title" id="closed-jobs">0</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <h4 class="mt-4">📈 Lượt ứng tuyển theo tháng</h4>
    <canvas id="applicationChart" height="100"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentChart = null;

    // Khởi tạo ngày mặc định (30 ngày gần nhất)
    function initializeDefaultDates() {
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);

        document.getElementById('dateFrom').value = thirtyDaysAgo.toISOString().split('T')[0];
        document.getElementById('dateTo').value = today.toISOString().split('T')[0];
    }

    async function loadDashboard(dateFrom = null, dateTo = null) {
        try {
            const params = new URLSearchParams();
            if (dateFrom) params.append('dateFrom', dateFrom);
            if (dateTo) params.append('dateTo', dateTo);

            const [userRes, jobRes, appRes] = await Promise.all([
                fetch(`/api/admin/stats/users?${params}`),
                fetch(`/api/admin/stats/jobs?${params}`),
                fetch(`/api/admin/stats/applications?type=monthly&${params}`)
            ]);

            const users = await userRes.json();
            const jobs = await jobRes.json();
            const apps = await appRes.json();

            // Hiển thị người dùng
            document.getElementById('seeker-count').textContent = users.seeker ?? 0;
            document.getElementById('employer-count').textContent = users.employer ?? 0;
            document.getElementById('admin-count').textContent = users.admin ?? 0;

            // Hiển thị công việc
            document.getElementById('active-jobs').textContent = jobs.active ?? 0;
            document.getElementById('closed-jobs').textContent = jobs.closed ?? 0;

            // Vẽ biểu đồ ứng tuyển
            updateChart(apps);

        } catch (error) {
            console.error('Lỗi khi load dashboard:', error);
        }
    }

    function updateChart(apps) {
        const ctx = document.getElementById('applicationChart').getContext('2d');

        // Xóa biểu đồ cũ nếu có
        if (currentChart) {
            currentChart.destroy();
        }

        const appLabels = apps.map(item => 'Tháng ' + item.period);
        const appCounts = apps.map(item => item.total);

        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: appLabels,
                datasets: [{
                    label: 'Lượt ứng tuyển',
                    data: appCounts,
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    function applyFilter() {
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        const filterType = document.getElementById('filterType').value;

        if (!dateFrom || !dateTo) {
            alert('Vui lòng chọn khoảng thời gian!');
            return;
        }

        if (new Date(dateFrom) > new Date(dateTo)) {
            alert('Ngày bắt đầu không được lớn hơn ngày kết thúc!');
            return;
        }

        loadDashboard(dateFrom, dateTo);
    }

    function resetFilter() {
        initializeDefaultDates();
        loadDashboard();
    }

    // Khởi tạo trang
    document.addEventListener('DOMContentLoaded', function() {
        initializeDefaultDates();
        loadDashboard();
    });
</script>
@endpush
