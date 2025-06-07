@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h4>Chi tiết báo cáo #{{ $report->id }}</h4>

    <div class="mb-3">
        <strong>Đối tượng:</strong>
        {{ class_basename($report->target_type) }} #{{ $report->target_id }}
    </div>

    <div class="mb-3">
        <strong>Người báo cáo:</strong> {{ $report->reporter->email }}
    </div>

    <div class="mb-3">
        <strong>Lý do:</strong> {{ ucfirst($report->reason_code) }}
    </div>

    <div class="mb-3">
        <strong>Nội dung chi tiết:</strong> {{ $report->message ?? '(Không có)' }}
    </div>

    <div class="mb-3">
        <strong>Trạng thái:</strong>
        <span class="badge bg-{{ $report->status === 'approved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'warning') }}">
            {{ ucfirst($report->status) }}
        </span>
    </div>

    @if($report->seen_at)
    <div class="mb-3">
        <strong>Đã xem lúc:</strong> {{ $report->seen_at }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Cập nhật trạng thái</label>
            <select name="status" class="form-select">
                <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>Duyệt</option>
                <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Từ chối</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú nội bộ</label>
            <textarea name="admin_note" class="form-control">{{ $report->admin_note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
