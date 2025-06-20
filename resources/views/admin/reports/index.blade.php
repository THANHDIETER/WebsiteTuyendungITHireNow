@extends('admin.layouts.default') {{-- Nếu bạn dùng layout chung --}}
@section('content')
<div class="container mt-4">
    <h3>Danh sách báo cáo vi phạm</h3>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Đối tượng</th>
                <th>Người báo cáo</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ class_basename($report->target_type) }} #{{ $report->target_id }}</td>
                    <td>{{ $report->reporter->email }}</td>
                    <td>{{ ucfirst($report->reason_code) }}</td>
                    <td>
                        @if ($report->status === 'pending')
                            <span class="badge bg-warning text-dark">Đang chờ</span>
                        @elseif ($report->status === 'approved')
                            <span class="badge bg-success">Đã duyệt</span>
                        @else
                            <span class="badge bg-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>
<button class="btn btn-sm btn-primary btn-view-report" 
        data-id="{{ $report->id }}">
    Xem
</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Không có báo cáo nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $reports->links() }}
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel">Chi tiết báo cáo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <div id="report-detail-content">
          Đang tải...
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-view-report').forEach(button => {
        button.addEventListener('click', function () {
            const reportId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('reportModal'));
            const contentDiv = document.getElementById('report-detail-content');
            
            contentDiv.innerHTML = 'Đang tải...';

            fetch(`/admin/reports/${reportId}`)
                .then(response => response.text())
                .then(data => {
                    contentDiv.innerHTML = data;
                    modal.show();
                })
                .catch(error => {
                    contentDiv.innerHTML = 'Lỗi khi tải dữ liệu.';
                    console.error('Error:', error);
                });
        });
    });
});
</script>
@endpush
