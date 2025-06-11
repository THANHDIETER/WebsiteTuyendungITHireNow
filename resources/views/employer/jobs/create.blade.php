@extends('employer.layouts.default')

@section('content')
<main class="main-content">
<div class="container py-5">
    <h2>📝 Đăng tin tuyển dụng mới</h2>

    {{-- Alert khi vượt quá số lượng job --}}
    @if (session('exceed_job_limit'))
        <div class="alert alert-warning">
            <strong>Bạn đã đăng đủ <span class="text-danger">3 tin miễn phí</span>!</strong>
            Vui lòng <a href="{{ route('employer.service-packages') }}" class="btn btn-sm btn-success ms-2">Nâng cấp gói dịch vụ</a> để tiếp tục đăng tin.
        </div>
    @endif

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST">
        @csrf

        {{-- Tiêu đề --}}
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề công việc</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror"
                name="title" value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Mô tả --}}
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả công việc</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                name="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Yêu cầu --}}
        <div class="mb-3">
            <label for="requirements" class="form-label">Yêu cầu</label>
            <textarea class="form-control @error('requirements') is-invalid @enderror"
                name="requirements" rows="3">{{ old('requirements') }}</textarea>
            @error('requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Quyền lợi --}}
        <div class="mb-3">
            <label for="benefits" class="form-label">Quyền lợi</label>
            <textarea class="form-control @error('benefits') is-invalid @enderror"
                name="benefits" rows="3">{{ old('benefits') }}</textarea>
            @error('benefits') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Loại công việc --}}
        <div class="mb-3">
            <label for="job_type" class="form-label">Loại công việc</label>
            <select name="job_type" class="form-select @error('job_type') is-invalid @enderror" required>
                <option value="">-- Chọn loại --</option>
                <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Toàn thời gian</option>
                <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Bán thời gian</option>
                <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Thực tập</option>
                <option value="remote" {{ old('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Hợp đồng</option>
            </select>
            @error('job_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Lương --}}
        <div class="row mb-3">
            <div class="col">
                <label for="salary_min" class="form-label">Lương tối thiểu</label>
                <input type="number" name="salary_min"
                    class="form-control @error('salary_min') is-invalid @enderror"
                    min="0" max="2147483647" value="{{ old('salary_min') }}">
                @error('salary_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col">
                <label for="salary_max" class="form-label">Lương tối đa</label>
                <input type="number" name="salary_max"
                    class="form-control @error('salary_max') is-invalid @enderror"
                    min="0" max="2147483647" value="{{ old('salary_max') }}">
                @error('salary_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Địa điểm --}}
        <div class="mb-3">
            <label for="location" class="form-label">Thành phố / Khu vực</label>
            <input type="text" name="location"
                class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Địa chỉ --}}
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ cụ thể</label>
            <input type="text" name="address"
                class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Level & Experience --}}
        <div class="row mb-3">
            <div class="col">
                <label for="level" class="form-label">Cấp bậc</label>
                <input type="text" name="level"
                    class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}">
                @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col">
                <label for="experience" class="form-label">Kinh nghiệm</label>
                <input type="text" name="experience"
                    class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience') }}">
                @error('experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Ngành nghề --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Ngành nghề</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Chọn ngành nghề --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Hạn nộp --}}
        <div class="mb-3">
            <label for="deadline" class="form-label">Hạn nộp</label>
            <input type="date" name="deadline"
                class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
            @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Các trường bổ sung --}}
        <div class="mb-3">
            <label for="apply_url" class="form-label">URL ứng tuyển</label>
            <input type="url" name="apply_url"
                class="form-control @error('apply_url') is-invalid @enderror" value="{{ old('apply_url') }}">
            @error('apply_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="remote_policy" class="form-label">Chính sách làm việc</label>
            <input type="text" name="remote_policy"
                class="form-control @error('remote_policy') is-invalid @enderror" value="{{ old('remote_policy') }}">
            @error('remote_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="language" class="form-label">Ngôn ngữ sử dụng</label>
            <input type="text" name="language"
                class="form-control @error('language') is-invalid @enderror" value="{{ old('language') }}">
            @error('language') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title (SEO)</label>
            <input type="text" name="meta_title"
                class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}">
            @error('meta_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description (SEO)</label>
            <textarea name="meta_description"
                class="form-control @error('meta_description') is-invalid @enderror" rows="2">{{ old('meta_description') }}</textarea>
            @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Search index --}}
        <div class="form-check mb-4">
            <input type="hidden" name="search_index" value="0">
            <input class="form-check-input" type="checkbox" name="search_index" id="search_index" value="1"
                {{ old('search_index', '1') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="search_index">
                Cho phép hiển thị công việc trong tìm kiếm
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Đăng tin</button>
    </form>
</div>
</main>
@endsection
