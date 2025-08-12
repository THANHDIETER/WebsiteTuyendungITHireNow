@extends('admin.layouts.default')

@section('content')
    <div class="container">
        <h1>Chi tiết Notification</h1>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $notification->id }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $notification->type }}</td>
            </tr>
            <tr>
                <th>Notifiable Type</th>
                <td>{{ $notification->notifiable_type }}</td>
            </tr>
            <tr>
                <th>Notifiable ID</th>
                <td>{{ $notification->notifiable_id }}</td>
            </tr>
            <tr>
                <th>Data</th>
                <td>
                    <pre>{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                </td>
            </tr>
            <tr>
                <th>Read At</th>
                <td>{{ $notification->read_at ? $notification->read_at->format('d/m/Y H:i') : 'Chưa đọc' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $notification->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection
