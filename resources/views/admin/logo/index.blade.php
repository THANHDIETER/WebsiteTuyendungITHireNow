@extends('admin.layouts.default')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mb-4">Danh sách Logo</h4>

    <a href="{{ route('admin.logos.create') }}" class="btn btn-primary mb-3">
        <i class="fa fa-plus"></i> Thêm logo mới
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tên mô tả</th>
                        <th>Loại</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logos as $logo)
                        <tr>
                            <td>{{ $logo->id }}</td>
                            <td>{{ $logo->name ?? 'Không có' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $logo->type }}</span></td>
                            <td>
                                <img src="{{ asset('storage/' . $logo->image_path) }}"
                                     alt="{{ $logo->name }}"
                                     width="100"
                                     class="img-thumbnail">
                            </td>
                            <td>
                                @if ($logo->is_active)
                                    <span class="badge bg-success">Đang hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                @endif
                            </td>
                            <td>{{ $logo->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.logos.edit', $logo->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.logos.destroy', $logo->id) }}" method="POST" class="d-inline-block"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa logo này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có logo nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $logos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
