@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4">Tin tuyển dụng chờ duyệt</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Công ty</th>
                        <th>Danh mục</th>
                        <th>Hình thức</th>
                        <th>Mức lương</th>
                        <th>Hạn nộp</th>
                        <th>Nổi bật</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>
                                <a href="{{ route('admin.jobs.show', $job) }}" class="text-decoration-underline fw-semibold">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td>{{ $job->company->name }}</td>
                            <td>{{ $job->category->name }}</td>
                            <td>{{ ucfirst($job->job_type) }}</td>
                            <td>
                                @if($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ optional($job->deadline)->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                {!! $job->is_featured ? '<span class="badge bg-warning text-dark">Nổi bật</span>' : '<span class="text-muted">-</span>' !!}
                            </td>
                            <td>
                                @if($job->is_approved)
                                    <span class="badge bg-success">Đã duyệt</span>
                                @else
                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                @endif
                            </td>
                            <td>{{ $job->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.jobs.approve', $job) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Xác nhận duyệt tin này?')">Duyệt</button>
                                    </form>

                                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-secondary btn-sm">Xem</a>

                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Xác nhận xoá tin này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xoá</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">
                                Không có tin tuyển dụng nào phù hợp.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($jobs->hasPages())
        <div class="mt-4">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
