@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Chi tiết người dùng</h3>

    <div class="card">
        <table class="table table-bordered mb-0">
            <tbody>
                <tr>
                    <th width="25%">Họ tên</th>
                    <td>{{ $user->name ?? '(chưa có)' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Điện thoại</th>
                    <td>{{ $user->phone_number ?? '(chưa có)' }}</td>
                </tr>
                <tr>
                    <th>Vai trò</th>
                    <td>
                        <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>
                        @if ($user->status === 'active')
                            <span class="badge bg-success">Đang hoạt động</span>
                        @elseif ($user->status === 'inactive')
                            <span class="badge bg-secondary">Chưa kích hoạt</span>
                        @else
                            <span class="badge bg-danger">Đã chặn</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Đã bị block?</th>
                    <td>
                        @if ($user->is_blocked)
                            <span class="text-danger fw-bold">Có</span>
                        @else
                            <span class="text-success">Không</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>IP gần nhất</th>
                    <td>{{ $user->ip_address ?? '(Không xác định)' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-4">⬅ Quay lại danh sách</a>
</div>
@endsection
