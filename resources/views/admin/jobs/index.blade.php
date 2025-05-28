@extends('admin.layouts.default')

@section('content')
    <div class="container">
        <h1>Danh sách tin tuyển dụng chưa duyệt</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Công ty</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->company->name }}</td>
                        <td>{{ $job->description }}</td>
                        <td>
                            <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Duyệt</button>
                            </form>
                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Không có tin tuyển dụng nào cần duyệt.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection