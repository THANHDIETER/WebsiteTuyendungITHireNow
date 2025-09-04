@extends('employer.layouts.default')

@push('styles')
<style>
  :root {
    --card-min-h: 112px;
    --chart-h: 380px;
    --primary-color: #4e73df;
    --secondary-color: #f8f9fc;
    --text-muted-light: #6c757d;
    --border-light: #dee2e6;
    --bg-table-head-light: #f8f9fa;
  }

  /* Card KPI */
  .stat-card { 
    min-height: var(--card-min-h); 
    border: none;
    border-radius: 0.75rem;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    background-color: var(--bs-white);
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  }

  /* Chart */
  .chart-wrap { 
    height: var(--chart-h); 
    position: relative; 
  }

  /* Table fixed header */
  .table-fixed-head { 
    overflow: auto; 
    max-height: calc(var(--chart-h) - 16px); 
    border-radius: .5rem;
    border: 1px solid var(--border-light);
  }
  .table-fixed-head thead th { 
    position: sticky; 
    top: 0; 
    background: var(--bg-table-head-light); 
    z-index: 2; 
    font-weight: 600;
  }

  /* Text ellipsis */
  .text-ellipsis { 
    max-width: 420px; 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
  }

  /* Equal columns */
  @media (min-width: 768px) {
    .equal-col { display: flex; }
    .equal-col > .card { flex: 1; display: flex; flex-direction: column; }
    .equal-col .card-body { flex: 1; display: flex; flex-direction: column; }
  }

  /* Card header style */
  .card-header {
    background-color: var(--secondary-color);
    font-weight: 600;
    border-bottom: 1px solid #e3e6f0;
  }

  /* KPI number color */
  .fs-3 {
    color: var(--primary-color);
  }

  /* ===== DARK MODE ===== */
  html.dark {
    --secondary-color: #1e1e1e;
    --bg-table-head-light: #2a2a2a;
    --border-light: #444;
    --text-muted-light: #bbb;
    background-color: #121212;
    color: #ddd;
  }

  html.dark .stat-card {
    background-color: #1e1e1e;
    color: #ddd;
    border: 1px solid var(--border-light);
  }

  html.dark .stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }

  html.dark .card-header {
    background-color: var(--bg-table-head-light);
    border-bottom: 1px solid var(--border-light);
    color: #fff;
  }

  html.dark .table-fixed-head {
    border: 1px solid var(--border-light);
  }

  html.dark .table-fixed-head thead th {
    background: var(--bg-table-head-light);
    color: #fff;
  }

  html.dark .text-muted {
    color: var(--text-muted-light) !important;
  }
</style>
@endpush

@section('content')

<div class="container-fluid py-3">

  {{-- KPI --}}
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <div class="col">
      <div class="card shadow-sm stat-card">
        <div class="card-body">
          <div class="text-muted">Tổng Job</div>
          <div class="fs-3 fw-bold">{{ number_format($jobsTotal ?? 0) }}</div>
          <!-- @isset($jobsActive)
            <div class="small text-muted">Active: {{ number_format($jobsActive ?? 0) }}</div>
          @endisset -->
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card shadow-sm stat-card">
        <div class="card-body">
          <div class="text-muted">Tổng Applications</div>
          <div class="fs-3 fw-bold">{{ number_format($appsTotal ?? 0) }}</div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card shadow-sm stat-card">
        <div class="card-body">
          <div class="text-muted">TB Applications/Job</div>
          <div class="fs-3 fw-bold">{{ $avgAppPerJob ?? 0 }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Content --}}
  <div class="row g-3 mt-1 align-items-stretch">
    {{-- Bảng Top Jobs --}}
    <div class="col-12 col-lg-5 equal-col">
      <div class="card shadow-sm">
        <div class="card-header fw-semibold">Top Job theo số Applications</div>
        <div class="card-body">
          <div class="table-fixed-head">
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Job</th>
                  <th class="text-end">Applications</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($topJobsByApps ?? []) as $j)
                  <tr title="{{ $j->title ?? ('Job #'.$j->id) }}">
                    <td><span class="text-ellipsis">{{ $j->title ?? ('Job #'.$j->id) }}</span></td>
                    <td class="text-end fw-semibold">{{ $j->applications_count ?? 0 }}</td>
                  </tr>
                @empty
                  <tr><td colspan="2" class="text-center text-muted py-4">Chưa có dữ liệu</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Biểu đồ --}}
    <div class="col-12 col-lg-7 equal-col">
      <div class="card shadow-sm">
        <div class="card-header fw-semibold">
          30 ngày gần nhất
          @if(!empty($chartNote)) <small class="text-muted ms-2">{{ $chartNote }}</small> @endif
        </div>
        <div class="card-body">
          <div class="chart-wrap">
            <canvas id="line30" width="400" height="380"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
(() => {
  const labels = @json($series['jobs']['labels'] ?? []);
  const jobs   = @json($series['jobs']['data'] ?? []);
  const apps   = @json($series['apps']['data'] ?? []);

  if (!labels.length) return;

  const ctx = document.getElementById('line30').getContext('2d');

  // Gradient màu
  const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
  gradientBlue.addColorStop(0, 'rgba(78, 115, 223, 0.4)');
  gradientBlue.addColorStop(1, 'rgba(78, 115, 223, 0)');

  const gradientRed = ctx.createLinearGradient(0, 0, 0, 400);
  gradientRed.addColorStop(0, 'rgba(231, 74, 59, 0.4)');
  gradientRed.addColorStop(1, 'rgba(231, 74, 59, 0)');

  const isDark = document.documentElement.classList.contains('dark');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [
        { 
          label: 'Jobs', 
          data: jobs, 
          borderColor: '#4e73df', 
          backgroundColor: gradientBlue, 
          pointRadius: 3, 
          pointBackgroundColor: '#4e73df',
          borderWidth: 2, 
          fill: true, 
          tension: 0.3 
        },
        { 
          label: 'Applications', 
          data: apps, 
          borderColor: '#e74a3b', 
          backgroundColor: gradientRed, 
          pointRadius: 3, 
          pointBackgroundColor: '#e74a3b',
          borderWidth: 2, 
          fill: true, 
          tension: 0.3 
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: { 
        legend: { position: 'top', labels: { color: isDark ? '#fff' : '#333', boxWidth: 12, padding: 15 } },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: { 
        y: { beginAtZero: true, grid: { color: isDark ? '#444' : '#e5e5e5' }, ticks: { color: isDark ? '#fff' : '#333' } },
        x: { grid: { color: 'transparent' }, ticks: { color: isDark ? '#fff' : '#333' } }
      }
    }
  });
})();
</script>
@endpush
