@extends('employer.layouts.default')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📜 Lịch sử gói dịch vụ</h2>

    <div class="table-responsive shadow-sm border rounded">
        <table id="logsTable" class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>Job</th>
                    <!-- <th>Thời gian sử dụng</th> -->
                    <th>Hành động</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->order?->id ?? '-' }}</td>
                        <td>{{ $log->job?->title ?? $log->job_id ?? '-' }}</td>
                        <!-- <td>{{ $log->used_at ? $log->used_at->format('d/m/Y H:i') : '-' }}</td> -->
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#logsTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json" },
        pageLength: 10, 
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        order: [[0, 'desc']]
    });
});
</script>
@endpush
