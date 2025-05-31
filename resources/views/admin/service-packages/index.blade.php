@extends('admin.layouts.default')

@section('title', 'Quản lý Gói Dịch Vụ')

@section('content')
    <h1>Quản lý Gói Dịch Vụ</h1>

    <a href="{{ route('admin.service-packages.create') }}" class="btn btn-primary mb-3">Thêm Gói Dịch Vụ</a>

    <form method="GET" action="{{ route('admin.service-packages.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Lọc</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Thời gian (ngày)</th>
                <th>Tính năng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->name }}</td>
                    <td>{{ number_format($package->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $package->duration_days }}</td>
                    <td>{{ $package->features ?? 'Không có' }}</td>
                    <td>{{ $package->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</td>
                    <td>
                        <a href="{{ route('admin.service-packages.edit', $package) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.service-packages.destroy', $package) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Không có gói dịch vụ nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection