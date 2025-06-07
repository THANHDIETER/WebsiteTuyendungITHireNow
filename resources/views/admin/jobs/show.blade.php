@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Chi tiết tin tuyển dụng</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr><th style="width: 200px">Tiêu đề công việc</th><td>{{ $job->title }}</td></tr>
                    <tr><th>Công ty tuyển dụng</th><td>{{ $job->company->name }}</td></tr>
                    <tr><th>Danh mục công việc</th><td>{{ $job->category->name }}</td></tr>
                    <tr><th>Hình thức làm việc</th><td>{{ ucfirst($job->job_type) }}</td></tr>
                    <tr><th>Khu vực làm việc</th><td>{{ $job->location }}</td></tr>
                    <tr><th>Địa chỉ cụ thể</th><td>{{ $job->address }}</td></tr>
                    <tr><th>Chính sách làm việc từ xa</th><td>{{ $job->remote_policy ?? '-' }}</td></tr>
                    <tr><th>Ngôn ngữ sử dụng</th><td>{{ $job->language ?? '-' }}</td></tr>
                    <tr><th>Kinh nghiệm yêu cầu</th><td>{{ $job->experience ?? '-' }}</td></tr>
                    <tr><th>Cấp bậc công việc</th><td>{{ $job->level ?? '-' }}</td></tr>
                    <tr><th>Mức lương</th>
                        <td>{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}</td>
                    </tr>
                    <tr><th>Hạn chót nộp hồ sơ</th><td>{{ optional($job->deadline)->format('d/m/Y') ?? '-' }}</td></tr>
                    <tr><th>Liên kết ứng tuyển</th>
                        <td>
                            @if ($job->apply_url)
                                <a href="{{ $job->apply_url }}" target="_blank">{{ $job->apply_url }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr><th>Lượt xem</th><td>{{ $job->views }}</td></tr>
                    <tr><th>Trạng thái đăng tin</th>
                        <td>
                            <span class="badge bg-{{ $job->status === 'published' ? 'success' : ($job->status === 'pending' ? 'warning text-dark' : 'secondary') }}">
                                {{ $job->status === 'published' ? 'Đã đăng' : ($job->status === 'pending' ? 'Chờ duyệt' : ucfirst($job->status)) }}
                            </span>
                        </td>
                    </tr>
                    <tr><th>Tiêu đề SEO (Meta title)</th><td>{{ $job->meta_title ?? '-' }}</td></tr>
                    <tr><th>Mô tả SEO (Meta description)</th><td>{{ $job->meta_description ?? '-' }}</td></tr>
                    <tr><th>Cho phép hiển thị trên Google</th>
                        <td>
                            {!! $job->search_index ? '<span class="text-success">✔ Có</span>' : '<span class="text-danger">✖ Không</span>' !!}
                        </td>
                    </tr>
                    <tr><th>Ghim tin nổi bật</th>
                        <td>
                            {!! $job->is_featured ? '<span class="text-success">✔ Có</span>' : '<span class="text-muted">Không</span>' !!}
                        </td>
                    </tr>
                    <tr><th>Ngày tạo tin</th><td>{{ $job->created_at->format('d/m/Y H:i') }}</td></tr>

                    <tr><th>Mô tả công việc</th>
                        <td class="white-space-pre-line">{{ $job->description }}</td>
                    </tr>
                    <tr><th>Yêu cầu công việc</th>
                        <td class="white-space-pre-line">{{ $job->requirements }}</td>
                    </tr>

                    @if (is_array($job->benefits) || is_string($job->benefits))
                        <tr><th>Quyền lợi được hưởng</th>
                            <td>
                                <ul class="ps-3 mb-0">
                                    @foreach (is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true) as $benefit)
                                        <li>{{ $benefit }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif

                    <tr><th>Kỹ năng yêu cầu</th>
                        <td>
                            @forelse ($job->skills as $skill)
                                <span class="badge bg-primary me-1">
                                    {{ $skill->name }}{{ $skill->pivot->required ? ' (*)' : '' }}
                                </span>
                            @empty
                                <span class="text-muted">Không có kỹ năng</span>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <form action="{{ route('admin.jobs.approve', $job) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận duyệt tin này?')">✅ Duyệt</button>
        </form>

        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Xác nhận xoá tin này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑 Xoá</button>
        </form>

        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>
</div>
@endsection
