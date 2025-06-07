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
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-primary">Xem</a>
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
@endsection
