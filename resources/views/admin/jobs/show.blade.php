@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Chi tiết tin tuyển dụng</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 200px">Tiêu đề</th>
                        <td>{{ $job->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Công ty</th>
                        <td>{{ $job->company->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Danh mục</th>
                        <td>{{ $job->category->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Loại hình</th>
                        <td>{{ ucfirst($job->job_type) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Địa điểm</th>
                        <td>{{ $job->location }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Ngày tạo</th>
                        <td>{{ $job->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Mô tả công việc</th>
                        <td class="white-space-pre-line">{{ $job->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Yêu cầu</th>
                        <td class="white-space-pre-line">{{ $job->requirements }}</td>
                    </tr>
                    @if (is_array($job->benefits) || is_string($job->benefits))
                    <tr>
                        <th scope="row">Quyền lợi</th>
                        <td>
                            <ul class="ps-3 mb-0">
                                @foreach (is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true) as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th scope="row">Kỹ năng</th>
                        <td>
                            @foreach ($job->skills as $skill)
                                <span class="badge bg-primary me-1">
                                    {{ $skill->name }} {{ $skill->pivot->required ? '(*)' : '' }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <form id="approve-form" action="{{ route('admin.jobs.approve', $job) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận duyệt?')">Duyệt</button>
        </form>
        <form id="reject-form" action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Xác nhận xoá tin này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xoá</button>
        </form>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection