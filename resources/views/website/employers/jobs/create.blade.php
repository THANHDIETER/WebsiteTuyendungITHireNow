@extends('website.layouts.master')

@section('content')
<main class="main-content">
<div class="container py-5">
    <h2>📝 Đăng tin tuyển dụng mới</h2>

    {{-- Hiển thị lỗi nếu có --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form đăng tin --}}
    <form action="{{ route('employer.jobs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề công việc</label>
            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả công việc</label>
            <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="requirements" class="form-label">Yêu cầu</label>
            <textarea class="form-control" name="requirements" rows="3">{{ old('requirements') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="benefits" class="form-label">Quyền lợi</label>
            <textarea class="form-control" name="benefits" rows="3">{{ old('benefits') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="job_type" class="form-label">Loại công việc</label>
            <select name="job_type" class="form-select" required>
                <option value="">-- Chọn loại --</option>
                <option value="full-time">Toàn thời gian</option>
                <option value="part-time">Bán thời gian</option>
                <option value="internship">Thực tập</option>
                <option value="remote">Remote</option>
                <option value="contract">Hợp đồng</option>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="salary_min" class="form-label">Lương tối thiểu</label>
                <input type="number" name="salary_min" class="form-control" min="0" max="2147483647" value="{{ old('salary_min') }}">
            </div>
            <div class="col">
                <label for="salary_max" class="form-label">Lương tối đa</label>
                <input type="number" name="salary_max" class="form-control" min="0" max="2147483647" value="{{ old('salary_max') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Thành phố / Khu vực</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ cụ thể</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="level" class="form-label">Cấp bậc</label>
                <input type="text" name="level" class="form-control" value="{{ old('level') }}">
            </div>
            <div class="col">
                <label for="experience" class="form-label">Kinh nghiệm</label>
                <input type="text" name="experience" class="form-control" value="{{ old('experience') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Ngành nghề</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Chọn ngành nghề --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Hạn nộp</label>
            <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
        </div>

        <div class="mb-3">
            <label for="apply_url" class="form-label">URL ứng tuyển</label>
            <input type="url" name="apply_url" class="form-control" value="{{ old('apply_url') }}">
        </div>

        <div class="mb-3">
            <label for="remote_policy" class="form-label">Chính sách làm việc</label>
            <input type="text" name="remote_policy" class="form-control" value="{{ old('remote_policy') }}">
        </div>

        <div class="mb-3">
            <label for="language" class="form-label">Ngôn ngữ sử dụng</label>
            <input type="text" name="language" class="form-control" value="{{ old('language') }}">
        </div>

        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title (SEO)</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
        </div>

        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description (SEO)</label>
            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="search_index" id="search_index" {{ old('search_index', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="search_index">
                Cho phép hiển thị công việc trong tìm kiếm
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Đăng tin</button>
    </form>
</div>
</main>
@endsection
