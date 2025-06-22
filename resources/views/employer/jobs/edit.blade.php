@extends('employer.layouts.default')

@section('content')
<main class="main-content">
<div class="container py-5">
    <h2><i class="bi bi-pencil-square me-2"></i> Sửa tin tuyển dụng</h2>

    {{-- Thông báo lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Thông tin cơ bản --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Thông tin cơ bản</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Tiêu đề công việc <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
                </div>

                <div class="mb-3">
                    <label>Ảnh đại diện (thumbnail)</label>
                    <input type="file" name="thumbnail" class="form-control">
                    @if($job->thumbnail)
                        <img src="{{ asset('storage/'.$job->thumbnail) }}" alt="Thumbnail" class="mt-2" style="width: 120px">
                    @endif
                </div>

                <div class="mb-3">
                    <label>Mô tả công việc <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description', $job->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Yêu cầu</label>
                    <textarea name="requirements" rows="4" class="form-control">{{ old('requirements', $job->requirements) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Lương & Chế độ --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Lương & Chế độ</div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="checkbox" name="salary_negotiable" class="form-check-input" id="salary_negotiable" {{ old('salary_negotiable', $job->salary_min === null && $job->salary_max === null ? true : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="salary_negotiable">Lương thương lượng</label>
                </div>

                <div class="row mb-3 salary-inputs">
                    <div class="col">
                        <label>Lương tối thiểu</label>
                        <input type="number" name="salary_min" class="form-control" value="{{ old('salary_min', $job->salary_min) }}">
                    </div>
                    <div class="col">
                        <label>Lương tối đa</label>
                        <input type="number" name="salary_max" class="form-control" value="{{ old('salary_max', $job->salary_max) }}">
                    </div>
                    <div class="col">
                        <label>Đơn vị</label>
                        <select name="currency" class="form-select">
                            <option value="VND" {{ old('currency', $job->currency) == 'VND' ? 'selected' : '' }}>VND</option>
                            <option value="USD" {{ old('currency', $job->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Chế độ đãi ngộ</label>
                    <textarea name="benefits" rows="3" class="form-control">{{ old('benefits', $job->benefits) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Vị trí tuyển dụng --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Vị trí tuyển dụng</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Ngành nghề <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>

                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $job->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>

                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Địa chỉ làm việc</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $job->address) }}">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Cấp bậc</label>
                        <select name="level" class="form-select">
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ old('level', $job->level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label>Kinh nghiệm</label>
                        <select name="experience" class="form-select">
                            @foreach ($experiences as $exp)
                                <option value="{{ $exp }}" {{ old('experience', $job->experience) == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Hạn ứng tuyển</label>
                    <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}">
                </div>
            </div>
        </div>

        {{-- Kỹ năng --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Kỹ năng</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Kỹ năng (cách nhau bằng dấu phẩy)</label>
                    <input type="text" name="skills_text" class="form-control" value="{{ old('skills_text', $job->skills) }}">
                </div>
            </div>
        </div>

        {{-- SEO & Tìm kiếm --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">SEO & Tìm kiếm</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Từ khoá</label>
                    <input type="text" name="keyword" class="form-control" value="{{ old('keyword', $job->keyword) }}">
                </div>
                <div class="mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $job->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $job->meta_description) }}</textarea>
                </div>

                <div class="form-check">
                    <input type="hidden" name="search_index" value="0">
                    <input class="form-check-input" type="checkbox" name="search_index" id="search_index" value="1" {{ old('search_index', $job->search_index) ? 'checked' : '' }}>
                    <label class="form-check-label" for="search_index">Hiển thị công việc trong tìm kiếm</label>
                </div>
            </div>
        </div>

        {{-- Nút Submit --}}
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
            <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-secondary px-4">Huỷ</a>
        </div>
    </form>
</div>
</main>
@endsection
