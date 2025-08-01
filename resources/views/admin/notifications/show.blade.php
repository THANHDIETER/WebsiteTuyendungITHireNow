@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Chi tiết Notification</h1>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th scope="row" style="width: 200px;">ID</th>
                    <td>{{ $notification->id }}</td>
                </tr>
                <tr>
                    <th scope="row">Type</th>
                    <td>{{ $notification->type }}</td>
                </tr>
                <tr>
                    <th scope="row">Notifiable Type</th>
                    <td>{{ $notification->notifiable_type }}</td>
                </tr>
                <tr>
                    <th scope="row">Notifiable ID</th>
                    <td>{{ $notification->notifiable_id }}</td>
                </tr>
                <tr>
                    <th scope="row">Data</th>
                    <td>
                        <pre class="mb-0" style="white-space: pre-wrap;">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Read At</th>
                    <td>{{ $notification->read_at ? $notification->read_at->format('d/m/Y H:i') : 'Chưa đọc' }}</td>
                </tr>
                <tr>
                    <th scope="row">Created At</th>
                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th scope="row">Updated At</th>
                    <td>{{ $notification->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>
@endsection
