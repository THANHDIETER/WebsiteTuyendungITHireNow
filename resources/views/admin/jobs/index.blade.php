@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4">Tin tuyển dụng chờ duyệt</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Tìm theo tiêu đề</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm theo tiêu đề">
        </div>
        <div class="col-md-4">
            <label class="form-label">Danh mục</label>
            <select name="category" class="form-select">
                <option value="">Tất cả danh mục</option>
                @foreach (App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Công ty</th>
                        <th>Danh mục</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>
                                <a href="{{ route('admin.jobs.show', $job) }}" class="text-decoration-underline">{{ $job->title }}</a>
                            </td>
                            <td>{{ $job->company->name }}</td>
                            <td>{{ $job->category->name }}</td>
                            <td>{{ $job->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form id="approve-form-{{ $job->id }}" action="{{ route('admin.jobs.approve', $job) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                         <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận duyệt?')">Duyệt</button>
                                    </form>
                                    <form id="delete-form-{{ $job->id }}" action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Xác nhận xoá tin này?')">
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
        {{ $jobs->appends(request()->query())->links() }}
    </div>
</div>
@endsection