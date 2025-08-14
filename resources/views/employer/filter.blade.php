@extends('employer.layouts.default')

@push('styles')
<style>
  .chart-wrap { height: 380px; }
  .quick-filters .btn { min-width: 120px; }
  .stat-card {
    color: #fff;
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  }
  .stat-card h4 { font-size: 1.8rem; }
  .card-icon {
    font-size: 2rem;
    opacity: 0.8;
  }
  /* Overlay loading */
  #loading-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255,255,255,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
  }
  #loading-overlay .spinner-border {
    width: 3rem; height: 3rem;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">

  {{-- Overlay loading --}}
  <div id="loading-overlay">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  {{-- Form lọc --}}
  <form id="filter-form" class="row g-3 mb-3 align-items-end bg-light p-3 rounded shadow-sm">
    <div class="col-auto">
      <label class="form-label fw-semibold">Từ ngày</label>
      <input type="date" name="from" class="form-control" value="{{ $defaultFrom }}">
    </div>
    <div class="col-auto">
      <label class="form-label fw-semibold">Đến ngày</label>
      <input type="date" name="to" class="form-control" value="{{ $defaultTo }}">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-filter"></i> Lọc
      </button>
    </div>
  </form>

  {{-- Nút lọc nhanh --}}
  <div class="mb-4 quick-filters text-center">
    <div class="btn-group flex-wrap" role="group">
      <button type="button" class="btn btn-outline-primary" onclick="quickFilter('thisMonth')">Tháng này</button>
      <button type="button" class="btn btn-outline-primary" onclick="quickFilter('lastMonth')">Tháng trước</button>
      <button type="button" class="btn btn-outline-success" onclick="quickFilter('thisYear')">Năm nay</button>
      <button type="button" class="btn btn-outline-success" onclick="quickFilter('lastYear')">Năm trước</button>
      <button type="button" class="btn btn-outline-warning" onclick="quickFilter('last7')">7 ngày gần nhất</button>
      <button type="button" class="btn btn-outline-warning" onclick="quickFilter('last30')">30 ngày gần nhất</button>
    </div>
  </div>

  {{-- Thống kê tổng quan --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card stat-card bg-primary">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold">Tổng Job</h6>
            <h4 id="total-jobs">0</h4>
          </div>
          <i class="bi bi-briefcase-fill card-icon"></i>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card bg-danger">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold">Tổng Applications</h6>
            <h4 id="total-apps">0</h4>
          </div>
          <i class="bi bi-people-fill card-icon"></i>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card bg-success">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold">TB Applications/Job</h6>
            <h4 id="avg-apps">0</h4>
          </div>
          <i class="bi bi-bar-chart-fill card-icon"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- Top jobs --}}
  <div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold bg-light">
      <i class="bi bi-trophy-fill text-warning"></i> Top Job theo số Applications
    </div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-primary">
          <tr>
            <th>Job</th>
            <th class="text-end">Applications</th>
          </tr>
        </thead>
        <tbody id="top-jobs-body"></tbody>
      </table>
    </div>
  </div>

  {{-- Biểu đồ --}}
  <div class="card shadow-sm">
    <div class="card-header fw-semibold bg-light">
      <i class="bi bi-graph-up-arrow text-success"></i> Biểu đồ thống kê
    </div>
    <div class="card-body chart-wrap">
      <canvas id="chart-filter"></canvas>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
let chart;
const overlay = document.getElementById('loading-overlay');
const quickFilterButtons = document.querySelectorAll('.quick-filters .btn');
const filterForm = document.getElementById('filter-form');

document.getElementById('filter-form').addEventListener('submit', function(e) {
  e.preventDefault();
  fetchData();
});

function showLoading() {
  overlay.style.display = 'flex';
  quickFilterButtons.forEach(btn => btn.disabled = true);
  filterForm.querySelectorAll('input, button').forEach(el => el.disabled = true);
}

function hideLoading() {
  overlay.style.display = 'none';
  quickFilterButtons.forEach(btn => btn.disabled = false);
  filterForm.querySelectorAll('input, button').forEach(el => el.disabled = false);
}

// Highlight nút lọc nhanh
function highlightQuickFilter(type) {
  document.querySelectorAll('.quick-filters .btn').forEach(btn => btn.classList.remove('active'));
  const map = {
    thisMonth: 'Tháng này',
    lastMonth: 'Tháng trước',
    thisYear: 'Năm nay',
    lastYear: 'Năm trước',
    last7: '7 ngày gần nhất',
    last30: '30 ngày gần nhất'
  };
  const btn = Array.from(document.querySelectorAll('.quick-filters .btn'))
                   .find(b => b.textContent.trim() === map[type]);
  if (btn) btn.classList.add('active');
}

function quickFilter(type) {
  highlightQuickFilter(type);
  const today = new Date();
  let from, to = new Date();

  switch (type) {
    case 'thisMonth':
      from = new Date(today.getFullYear(), today.getMonth(), 1);
      break;
    case 'lastMonth':
      from = new Date(today.getFullYear(), today.getMonth() - 1, 1);
      to = new Date(today.getFullYear(), today.getMonth(), 0);
      break;
    case 'thisYear':
      from = new Date(today.getFullYear(), 0, 1);
      break;
    case 'lastYear':
      from = new Date(today.getFullYear() - 1, 0, 1);
      to = new Date(today.getFullYear() - 1, 11, 31);
      break;
    case 'last7':
      from = new Date(today);
      from.setDate(today.getDate() - 6);
      break;
    case 'last30':
      from = new Date(today);
      from.setDate(today.getDate() - 29);
      break;
  }

  document.querySelector('input[name="from"]').value = from.toISOString().slice(0, 10);
  document.querySelector('input[name="to"]').value = to.toISOString().slice(0, 10);
  fetchData();
}

function fetchData() {
  const form = document.getElementById('filter-form');
  const from = form.from.value;
  const to = form.to.value;

  showLoading();

  fetch(`{{ route('employer.stats.filter.data') }}?from=${from}&to=${to}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById('total-jobs').textContent = data.jobs;
      document.getElementById('total-apps').textContent = data.applications;
      document.getElementById('avg-apps').textContent = data.avgAppPerJob;

      // top jobs
      const tbody = document.getElementById('top-jobs-body');
      tbody.innerHTML = '';
      data.topJobsByApps.forEach(j => {
        tbody.innerHTML += `<tr>
          <td>${j.title ?? 'Job #' + j.id}</td>
          <td class="text-end fw-semibold">${j.applications_count}</td>
        </tr>`;
      });

      // chart
      const labels = data.series.jobs.labels;
      const jobs = data.series.jobs.data;
      const apps = data.series.apps.data;
      if (chart) chart.destroy();
      const ctx = document.getElementById('chart-filter').getContext('2d');
      chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [
            { 
              label: 'Jobs', 
              data: jobs, 
              borderColor: '#0d6efd', 
              backgroundColor: 'rgba(13, 110, 253, 0.3)', 
              pointRadius: 4, 
              borderWidth: 2, 
              tension: 0.3 
            },
            { 
              label: 'Applications', 
              data: apps, 
              borderColor: '#dc3545', 
              backgroundColor: 'rgba(220, 53, 69, 0.3)', 
              pointRadius: 4, 
              borderWidth: 2, 
              tension: 0.3 
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'nearest', intersect: false },
          plugins: {
            tooltip: { enabled: true },
            legend: { position: 'top' }
          },
          scales: { y: { beginAtZero: true, grid: { color: '#e9ecef' } } }
        }
      });
    })
    .finally(() => {
      hideLoading();
    });
}

// Khi load trang tự động lọc tháng này và highlight
quickFilter('thisMonth');
</script>
@endpush
