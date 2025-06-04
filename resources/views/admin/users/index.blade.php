@extends('admin.layouts.default')
@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">👤 Quản lý người dùng</h4>
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-center">
            <label class="me-2 fw-semibold">Lọc vai trò:</label>
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Tất cả --</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Nhà tuyển dụng</option>
                <option value="job_seeker" {{ request('role') == 'job_seeker' ? 'selected' : '' }}>Ứng viên</option>
            </select>
        </form>
    </div>

    {{-- Bảng người dùng --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">📧 Email</th>
                        <th scope="col">🔖 Vai trò</th>
                        <th scope="col">🚫 Bị chặn?</th>
                        <th scope="col">⚙️ Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'employer' ? 'info' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="is_blocked" value="{{ $user->is_blocked ? 0 : 1 }}">
                                <button type="submit" class="btn btn-sm btn-{{ $user->is_blocked ? 'success' : 'warning' }}">
                                    {{ $user->is_blocked ? 'Bỏ chặn' : 'Chặn' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Xoá</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Không có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
