@extends('admin.layouts.default')
@section('content')
<div class="container mt-4">
    <h3>Thêm người dùng mới</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone_number" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="employer">Employer</option>
                <option value="job_seeker">Job Seeker</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Huỷ</a>
    </form>
</div>
@endsection