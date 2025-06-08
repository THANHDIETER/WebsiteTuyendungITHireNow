@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📊 Thống kê hệ thống</h3>

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
    async function loadDashboard() {
        try {
            const [userRes, jobRes, appRes] = await Promise.all([
                fetch('/api/admin/stats/users'),
                fetch('/api/admin/stats/jobs'),
                fetch('/api/admin/stats/applications?type=monthly')
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
            const appLabels = apps.map(item => 'Tháng ' + item.period);
            const appCounts = apps.map(item => item.total);

            const ctx = document.getElementById('applicationChart').getContext('2d');
            new Chart(ctx, {
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

        } catch (error) {
            console.error('Lỗi khi load dashboard:', error);
        }
    }

    loadDashboard();
</script>
@endpush
