@extends('employer.layouts.default')

@section('content')
<main class="main-content">
<div class="container py-5">
    <h2>📝 Đăng tin tuyển dụng mới</h2>

    {{-- Thông báo quota --}}
    @if (session('exceed_job_limit'))
        <div class="alert alert-warning">
            <strong>Bạn đã đăng đủ <span class="text-danger">3 tin miễn phí</span>!</strong>
            Vui lòng <a href="{{ route('employer.service-packages') }}" class="btn btn-sm btn-success ms-2">Nâng cấp gói</a>.
        </div>
    @endif

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Thông tin cơ bản --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Thông tin cơ bản</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title">Tiêu đề công việc <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label>Ảnh đại diện (thumbnail)</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Mô tả công việc <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Mô tả ngắn / yêu cầu</label>
                    <textarea name="requirements" id="requirements" rows="4" class="form-control">{{ old('requirements') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="job_type">Hình thức làm việc</label>
                    <select name="job_type" class="form-select">
                        <option value="">-- Chọn --</option>
                        <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Toàn thời gian</option>
                        <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Bán thời gian</option>
                        <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Thực tập</option>
                        <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Hợp đồng</option>
                        <option value="remote" {{ old('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="freelance" {{ old('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Lương & chế độ --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Lương & Chế độ</div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="salary_negotiable" id="salary_negotiable"
                        {{ old('salary_negotiable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="salary_negotiable">Lương thương lượng</label>
                </div>

                <div class="row mb-3 salary-inputs">
                    <div class="col">
                        <label>Lương tối thiểu</label>
                        <input type="number" name="salary_min" class="form-control" value="{{ old('salary_min') }}">
                    </div>
                    <div class="col">
                        <label>Lương tối đa</label>
                        <input type="number" name="salary_max" class="form-control" value="{{ old('salary_max') }}">
                    </div>
                    <div class="col">
                        <label>Đơn vị tiền tệ</label>
                        <select name="currency" class="form-select">
                            <option value="VND" {{ old('currency') == 'VND' ? 'selected' : '' }}>VND</option>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Chế độ đãi ngộ</label>
                    <textarea name="benefits" rows="3" class="form-control">{{ old('benefits') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Vị trí tuyển dụng --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Vị trí tuyển dụng</div>
            <div class="card-body">
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

                <div class="mb-3">
                    <label>Địa chỉ làm việc <span class="text-danger">*</span></label>
                    <select name="address" class="form-select" required>
                        @foreach ($company_addresses as $address)
                            <option value="{{ $address }}" {{ old('address') == $address ? 'selected' : '' }}>{{ $address }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Hạn ứng tuyển</label>
                    <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline') }}">
                </div>

                <div class="row">
                    <div class="col">
                        <label>Cấp bậc</label>
                        <select name="level" class="form-select" required>
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label>Kinh nghiệm</label>
                        <select name="experience" class="form-select" required>
                            @foreach ($experiences as $exp)
                                <option value="{{ $exp }}" {{ old('experience') == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Địa điểm khu vực</label>
                    <select name="location" class="form-select">
                        <option value="">-- Chọn khu vực --</option>
                        <option value="Hà Nội" {{ old('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Hồ Chí Minh" {{ old('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                        <option value="Đà Nẵng" {{ old('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                        <option value="Remote" {{ old('location') == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Khác" {{ old('location') == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>  
            </div>
        </div>

        {{-- Kỹ năng --}}
        <div class="card mb-4">
    <div class="card-header bg-light fw-bold">Kỹ năng</div>
    <div class="card-body">
        <div class="mb-3">
            <label for="skills_text">Kỹ năng (cách nhau bằng dấu phẩy)</label>
            <input type="text" name="skills_text" id="skills_text" 
                   class="form-control" 
                   value="{{ old('skills_text', isset($selectedSkills) ? $selectedSkills : '') }}">
            <small class="text-muted">Ví dụ: PHP, Laravel, MySQL</small>
        </div>
    </div>
</div>


        {{-- Thông tin bổ sung --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Thông tin bổ sung</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Chính sách làm việc (Remote Policy)</label>
                    <select name="remote_policy" class="form-select">
                        <option value="">-- Chọn chính sách --</option>
                        <option value="Onsite" {{ old('remote_policy') == 'Onsite' ? 'selected' : '' }}>Làm việc tại văn phòng</option>
                        <option value="Hybrid" {{ old('remote_policy') == 'Hybrid' ? 'selected' : '' }}>Làm việc kết hợp</option>
                        <option value="Remote" {{ old('remote_policy') == 'Remote' ? 'selected' : '' }}>Làm việc từ xa hoàn toàn</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Ngôn ngữ sử dụng (Language)</label>
                    <select name="language" class="form-select">
                        <option value="">-- Chọn ngôn ngữ --</option>
                        <option value="Tiếng Việt" {{ old('language') == 'Tiếng Việt' ? 'selected' : '' }}>Tiếng Việt</option>
                        <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Japanese" {{ old('language') == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                        <option value="Korean" {{ old('language') == 'Korean' ? 'selected' : '' }}>Korean</option>
                        <option value="Khác" {{ old('language') == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                
            </div>
        </div>

        {{-- SEO --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">SEO & Tìm kiếm</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Từ khoá (keyword)</label>
                    <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}">
                </div>
                <div class="mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>
                <div class="mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                </div>

                <div class="form-check">
                    <input type="hidden" name="search_index" value="0">
                    <input class="form-check-input" type="checkbox" name="search_index" id="search_index" value="1"
                        {{ old('search_index', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="search_index">
                        Hiển thị trong tìm kiếm
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-5">Đăng tin</button>
        </div>
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
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.querySelector('#skills_text');
        new Tagify(input, {
            delimiters: ",",
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        });
    });
</script>
@endpush
