@extends('admin.layouts.default')
@section('content')
<div class="container mt-4">
    <h3>Cập nhật thông tin người dùng</h3>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-select">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employer" {{ $user->role === 'employer' ? 'selected' : '' }}>Employer</option>
                <option value="job_seeker" {{ $user->role === 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Chưa kích hoạt</option>
                <option value="banned" {{ $user->status === 'banned' ? 'selected' : '' }}>Đã chặn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection