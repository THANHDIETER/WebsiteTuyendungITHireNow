@extends('employer.layouts.default')

@section('content')
<main class="main-content">
<div class="container py-5">
    <h2>📝 Đăng tin tuyển dụng mới</h2>

    {{-- Alert & Errors --}}
    @if (session('exceed_job_limit'))
        <div class="alert alert-warning">
            <strong>Bạn đã đăng đủ <span class="text-danger">3 tin miễn phí</span>!</strong>
            Vui lòng <a href="{{ route('employer.service-packages') }}" class="btn btn-sm btn-success ms-2">Nâng cấp gói</a>.
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('employer.jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tiêu đề --}}
        <div class="mb-3">
            <label for="title">Tiêu đề công việc <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            <label>Ảnh đại diện (thumbnail)</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        {{-- Mô tả --}}
        <div class="mb-3">
            <label for="description">Mô tả công việc <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="7">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="requirements">Mô tả ngắn / yêu cầu <span class="text-danger">*</span></label>
            <textarea name="requirements" id="requirements" class="form-control" rows="4">{{ old('requirements') }}</textarea>
        </div>

        {{-- Công ty --}}

        {{-- Lương --}}
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="salary_negotiable" id="salary_negotiable"
                {{ old('salary_negotiable') ? 'checked' : '' }}>
            <label class="form-check-label" for="salary_negotiable">Lương thương lượng</label>
        </div>

        <div class="row mb-3 salary-inputs">
            <div class="col">
                <label for="salary_min">Từ (Lương tối thiểu)</label>
                <input type="number" name="salary_min" id="salary_min" class="form-control" value="{{ old('salary_min') }}">
            </div>
            <div class="col">
                <label for="salary_max">Up to (Lương tối đa)</label>
                <input type="number" name="salary_max" id="salary_max" class="form-control" value="{{ old('salary_max') }}">
            </div>
            <div class="col">
                <label for="currency">Đơn vị tiền tệ</label>
                <select name="currency" class="form-select">
                    <option value="VND" {{ old('currency') == 'VND' ? 'selected' : '' }}>VND</option>
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                </select>
            </div>
        </div>

        {{-- Ngành nghề --}}
        <div class="mb-3">
            <label>Ngành nghề <span class="text-danger">*</span></label>
            <select name="categories[]" class="form-select select2" multiple required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ collect(old('categories'))->contains($cat->id) ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Địa chỉ --}}
        <div class="mb-3">
            <label>Địa chỉ làm việc <span class="text-danger">*</span></label>
            <select name="address" class="form-select" required>
                @foreach ($company_addresses as $address)
                    <option value="{{ $address }}" {{ old('address') == $address ? 'selected' : '' }}>
                        {{ $address }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Hạn ứng tuyển --}}
        <div class="mb-3">
            <label for="application_deadline">Hạn ứng tuyển</label>
            <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline') }}">
        </div>

        {{-- Cấp bậc --}}
        <div class="mb-3">
            <label>Cấp bậc</label>
            <select name="level" class="form-select" required>
                @foreach ($levels as $level)
                    <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        {{-- Kinh nghiệm --}}
        <div class="mb-3">
            <label>Kinh nghiệm</label>
            <select name="experience" class="form-select" required>
                @foreach ($experiences as $exp)
                    <option value="{{ $exp }}" {{ old('experience') == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                @endforeach
            </select>
        </div>

        {{-- Kỹ năng --}}
        <div class="mb-3">
            <label>Kỹ năng (Stack)</label>
            <select name="skills[]" class="form-select select2" multiple>
                @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}" {{ collect(old('skills'))->contains($skill->id) ? 'selected' : '' }}>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Đãi ngộ --}}
        <div class="mb-3">
            <label for="benefits">Chế độ đãi ngộ</label>
            <textarea name="benefits" id="benefits">{{ old('benefits') }}</textarea>
        </div>

        {{-- SEO --}}
        <div class="mb-3">
            <label>Từ khoá (keyword)</label>
            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}">
        </div>
        <div class="mb-3">
            <label>Meta Title</label>
            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
        </div>
        <div class="mb-3">
            <label>Meta Description</label>
            <textarea name="meta_description" id="meta_description" class="form-control">{{ old('meta_description') }}</textarea>
        </div>

        {{-- Search Index --}}
        <div class="form-check mb-4">
            <input type="hidden" name="search_index" value="0">
            <input class="form-check-input" type="checkbox" name="search_index" id="search_index" value="1"
                {{ old('search_index', '1') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="search_index">
                Hiển thị trong kết quả tìm kiếm
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Đăng tin</button>
    </form>
</div>
</main>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof CKEDITOR !== 'undefined' && document.getElementById('description')) {
        CKEDITOR.replace('description', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 200
        });
    }
    if (typeof CKEDITOR !== 'undefined' && document.getElementById('benefits')) {
        CKEDITOR.replace('benefits', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 150
        });
    }
    if (typeof CKEDITOR !== 'undefined' && document.getElementById('meta_description')) {
        CKEDITOR.replace('meta_description', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 150
        });
    }
    if (typeof CKEDITOR !== 'undefined' && document.getElementById('requirements')) {
        CKEDITOR.replace('requirements', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 100
        });
    }
});

</script>
<style>
/* Ẩn khối thông báo CKEditor nhưng vẫn giữ chiều cao để không làm "giật layout" */
.cke_notifications_area {
    visibility: hidden;
    height: 0 !important;
    overflow: hidden;
    padding: 0 !important;
    margin: 0 !important;
}
</style>
<script>
    $(document).ready(function () {
        $('.select2').select2();

        CKEDITOR.replace('description', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 200
        });

        CKEDITOR.replace('benefits', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 150
        });
        CKEDITOR.replace('meta_description', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 150
        });
            CKEDITOR.replace('requirements', {
            removePlugins: 'exportpdf',
            allowedContent: true,
            height: 100
        });
        $('#salary_negotiable').on('change', function () {
            if ($(this).is(':checked')) {
                $('.salary-inputs').hide();
            } else {
                $('.salary-inputs').show();
            }
        }).trigger('change');

        $('#title').on('blur', function () {
            const meta = $('#meta_title');
            if (!meta.val()) meta.val($(this).val());
        });
    });
</script>
@endpush
