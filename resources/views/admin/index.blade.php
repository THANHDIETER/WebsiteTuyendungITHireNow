@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Người dùng -->
        <h5 class="mt-4 mb-3">
            <i class="bi bi-people-fill me-2 text-primary"></i> Thống Kê Thành Viên
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-primary shadow-sm text-center p-2">
                    <i class="bi bi-people-fill fs-2 text-primary mb-2"></i>
                    <h6>Tổng thành viên</h6>
                    <h4>{{ $totalUsers }}</h4>
                </div>
            </div>
            @foreach($usersByRole as $role => $count)
                <div class="col-md-3">
                    <div class="card border-info shadow-sm text-center p-2">
                        <i class="bi bi-person-badge-fill fs-2 text-info mb-2"></i>
                        <h6>{{ ucfirst($role) }}</h6>
                        <h4>{{ $count }}</h4>
                    </div>
                </div>
            @endforeach
            <div class="col-md-3">
                <div class="card border-success shadow-sm text-center p-2">
                    <i class="bi bi-person-plus-fill fs-2 text-success mb-2"></i>
                    <h6>Thành viên mới (tháng này)</h6>
                    <h4>{{ $newUsersThisMonth }}</h4>
                </div>
            </div>
            @foreach($newUsersByRole as $role => $count)
                <div class="col-md-3">
                    <div class="card border-success shadow-sm text-center p-2">
                        <i class="bi bi-person-plus-fill fs-2 text-success mb-2"></i>
                        <h6>{{ ucfirst($role) }} mới</h6>
                        <h4>{{ $count }}</h4>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Đơn ứng tuyển -->
        <h5 class="mt-4 mb-3">
            <i class="bi bi-file-earmark-text-fill me-2 text-secondary"></i> Đơn Ứng Tuyển
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-dark shadow-sm text-center p-2">
                    <i class="bi bi-file-earmark-text-fill fs-2 text-dark mb-2"></i>
                    <h6>Tổng đơn</h6>
                    <h4>{{ $totalApplications }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-primary shadow-sm text-center p-2">
                    <i class="bi bi-calendar-check-fill fs-2 text-primary mb-2"></i>
                    <h6>Trong tháng</h6>
                    <h4>{{ $applicationsThisMonth }}</h4>
                </div>
            </div>
            @foreach($applicationsByStatus as $status => $count)
                <div class="col-md-3">
                    <div class="card border-info shadow-sm text-center p-2">
                        <i class="bi bi-flag-fill fs-2 text-info mb-2"></i>
                        <h6>{{ $status }}</h6>
                        <h4>{{ $count }}</h4>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Việc làm -->
        <h5 class="mt-4 mb-3">
            <i class="bi bi-briefcase-fill me-2 text-success"></i> Thống Kê Việc Làm
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-success shadow-sm text-center p-2">
                    <i class="bi bi-briefcase-fill fs-2 text-success mb-2"></i>
                    <h6>Tổng việc làm</h6>
                    <h4>{{ $totalJobs }}</h4>
                </div>
            </div>
            @foreach($jobStatus as $status => $count)
                <div class="col-md-3">
                    <div class="card border-secondary shadow-sm text-center p-2">
                        <i class="bi bi-flag-fill fs-2 text-secondary mb-2"></i>
                        <h6>{{ ucfirst($status) }}</h6>
                        <h4>{{ $count }}</h4>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Đơn hàng & Doanh thu -->
        <h5 class="mt-4 mb-3">
            <i class="bi bi-cart-fill me-2 text-warning"></i> Thống Kê Doanh Thu
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-warning shadow-sm text-center p-2">
                    <i class="bi bi-cart-fill fs-2 text-warning mb-2"></i>
                    <h6>Tổng đơn hàng</h6>
                    <h4>{{ $totalOrders }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger shadow-sm text-center p-2">
                    <i class="bi bi-cash-stack fs-2 text-danger mb-2"></i>
                    <h6>Tổng doanh thu</h6>
                    <h4>{{ number_format($totalRevenue, 0, ',', '.') }} đ</h4>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <h5 class="mt-4 mb-3">
            <i class="bi bi-graph-up-arrow me-2 text-danger"></i> Biểu Đồ Phân Tích
        </h5>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-3 rounded-3">
                    <h6 class="text-center">
                        <i class="bi bi-flag-fill me-2 text-secondary"></i> Việc làm theo trạng thái
                    </h6>
                    <div class="d-flex justify-content-center align-items-center" style="height:220px">
                        <canvas id="jobStatusChart" style="max-width:250px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-3 rounded-3">
                    <h6 class="text-center">
                        <i class="bi bi-diagram-3-fill me-2 text-primary"></i> Job theo ngành nghề
                    </h6>
                    <div class="d-flex justify-content-center align-items-center" style="height:220px">
                        <canvas id="jobsByCategoryChart" style="max-width:aoto; width:100%"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-3 rounded-3">
                    <h6 class="text-center">
                        <i class="bi bi-lightbulb-fill me-2 text-info"></i> Kỹ năng phổ biến
                    </h6>
                    <div class="d-flex justify-content-center align-items-center" style="height:300px">
                        <canvas id="skillsChart" style="width:auto"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-3 rounded-3">
                    <h6 class="text-center">
                        <i class="bi bi-pie-chart-fill me-2 text-success"></i> Tỷ lệ Đơn Ứng Tuyển
                    </h6>
                    <div class="d-flex justify-content-center align-items-center" style="height:300px">
                        <canvas id="applicationsChart" style="max-width:280px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Job Status
        const jobStatus = @json($jobStatus);
        const statusColors = {
            published: '#28a745',
            pending: '#ffc107',
            closed: '#dc3545',
            draft: '#6c757d'
        };
        new Chart(document.getElementById('jobStatusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(jobStatus),
                datasets: [{
                    data: Object.values(jobStatus),
                    backgroundColor: Object.keys(jobStatus).map(stt => statusColors[stt.toLowerCase()] || '#0d6efd')
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Job Category
        const jobsByCategory = @json($jobsByCategory);
        new Chart(document.getElementById('jobsByCategoryChart'), {
            type: 'bar',
            data: {
                labels: jobsByCategory.map(i => i.category),
                datasets: [{
                    data: jobsByCategory.map(i => i.total),
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Skills
        const skills = @json($skills);
        new Chart(document.getElementById('skillsChart'), {
            type: 'bar',
            data: {
                labels: skills.map(i => i.skill),
                datasets: [{
                    data: skills.map(i => i.total),
                    backgroundColor: '#17a2b8'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                responsive: true,
                maintainAspectRatio: false,
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Applications by Status
        const applicationsByStatus = @json($applicationsByStatus);
        new Chart(document.getElementById('applicationsChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(applicationsByStatus),
                datasets: [{
                    data: Object.values(applicationsByStatus),
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#0d6efd']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } }, responsive: true }
        });
    </script>
@endsection