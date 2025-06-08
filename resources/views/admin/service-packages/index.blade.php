@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4">Danh sách Gói dịch vụ</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.service-packages.create') }}" class="btn btn-primary">+ Thêm gói mới</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên gói</th>
                        <th>Giá</th>
                        <th>Số ngày</th>
                        <th>Số tin</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $pkg)
                        <tr>
                            <td>{{ $pkg->name }}</td>
                            <td>{{ number_format($pkg->price) }} VND</td>
                            <td>{{ $pkg->duration_days }}</td>
                            <td>{{ $pkg->post_limit }}</td>
                            <td>
                                <span class="badge {{ $pkg->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $pkg->is_active ? 'Hoạt động' : 'Ẩn' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.service-packages.show', $pkg) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                    <a href="{{ route('admin.service-packages.edit', $pkg) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form method="POST" action="{{ route('admin.service-packages.destroy', $pkg) }}" onsubmit="return confirm('Xác nhận xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xoá</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $packages->links() }}
    </div>
</div>
@endsection