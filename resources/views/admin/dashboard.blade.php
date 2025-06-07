@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📊 Thống kê hệ thống</h2>

    <div class="row">
        <div class="col-md-4">
            <h5>Người dùng</h5>
            <ul>
                <li>Seeker: {{ $userStats['seeker'] }}</li>
                <li>Employer: {{ $userStats['employer'] }}</li>
                <li>Admin: {{ $userStats['admin'] }}</li>
            </ul>
        </div>
        <div class="col-md-4">
            <h5>Jobs</h5>
            <ul>
                <li>Đang mở: {{ $jobStats['open'] }}</li>
                <li>Đã đóng: {{ $jobStats['closed'] }}</li>
            </ul>
        </div>
    </div>

    <hr>

    <h5>Biểu đồ lượt ứng tuyển</h5>
    <canvas id="weeklyChart"></canvas>
    <canvas id="monthlyChart" class="mt-4"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const weeklyChart = new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($applicationsWeekly->pluck('week')) !!},
            datasets: [{
                label: 'Lượt ứng tuyển theo tuần',
                data: {!! json_encode($applicationsWeekly->pluck('total')) !!},
                backgroundColor: '#4e73df'
            }]
        }
    });

    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($applicationsMonthly->pluck('month')) !!},
            datasets: [{
                label: 'Lượt ứng tuyển theo tháng',
                data: {!! json_encode($applicationsMonthly->pluck('total')) !!},
                backgroundColor: '#1cc88a'
            }]
        }
    });
</script>
@endsection
