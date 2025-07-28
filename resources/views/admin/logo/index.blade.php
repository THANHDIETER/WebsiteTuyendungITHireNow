@extends('admin.layouts.default')

@section('content')
<div class="container">
    <h4>Danh sách Logo</h4>
    <a href="{{ route('admin.logos.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Đang hoạt động</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logos as $logo)
                <tr>
                    <td><img src="{{ asset('storage/' . $logo->image_path) }}" alt="{{ $logo->name }}" width="100"></td>
                    <td>{{ $logo->is_active ? '✔️' : '❌' }}</td>
                    <td>
                        <a href="{{ route('admin.logos.edit', $logo->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.logos.destroy', $logo->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa logo này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logos->links() }}
</div>
@endsection
