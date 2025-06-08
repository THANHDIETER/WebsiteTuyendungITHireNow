@extends('admin.layouts.default')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh sách người dùng</h2>
        <a href="#" class="btn btn-primary">+ Thêm người dùng</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Vai trò</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>
                    <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
                </td>
                <td>
                    @if ($user->status === 'active')
                        <span class="badge bg-success">Đang hoạt động</span>
                    @elseif ($user->status === 'inactive')
                        <span class="badge bg-secondary">Chưa kích hoạt</span>
                    @else
                        <span class="badge bg-danger">Đã chặn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xác nhận xoá người dùng này?')">Xoá</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
