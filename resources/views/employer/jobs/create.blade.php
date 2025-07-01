@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-5">
            <h2>📝 Đăng tin tuyển dụng mới</h2>

            {{-- Thông báo quota --}}
            @if (session('exceed_job_limit'))
                <div class="alert alert-warning">
                    <strong>Bạn đã đăng đủ <span class="text-danger">3 tin miễn phí</span>!</strong>
                    Vui lòng <a href="{{ route('employer.service-packages') }}" class="btn btn-sm btn-success ms-2">Nâng cấp
                        gói</a>.
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
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Thông tin cơ bản</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title">Tiêu đề công việc <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label>Ảnh đại diện (thumbnail)</label>
                                <input type="file" name="thumbnail" class="form-control">
                            </div>
                            <div class="mb-3 col">
                                <label for="job_type_id" class="form-label">Hình thức làm việc <span
                                        class="text-danger">*</span></label>
                                <select name="job_type_id" id="job_type_id" class="form-select" required>
                                    <option value="">-- Chọn --</option>
                                    @foreach ($jobTypes as $type)
                                        <option value="{{ $type->id }}"
                                            @if (old('job_type_id') == $type->id) selected
                                    @elseif(isset($job) && $job->job_type_id == $type->id)
                                    selected @endif>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>




                        </div>

                        <div class="mb-3">
                            <label>Mô tả công việc <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Mô tả ngắn / yêu cầu</label>
                            <textarea name="requirements" id="requirements" rows="4" class="form-control">{{ old('requirements') }}</textarea>
                        </div>


                    </div>
                </div>

                {{-- Lương & chế độ --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Lương & Chế độ</div>
                    <div class="card-body">
                        <div class="row mb-3 salary-inputs">
                            <div class="col">
                                <label>Lương tối thiểu</label>
                                <input type="number" name="salary_min" class="form-control"
                                    value="{{ old('salary_min') }}">
                            </div>
                            <div class="col">
                                <label>Lương tối đa</label>
                                <input type="number" name="salary_max" class="form-control"
                                    value="{{ old('salary_max') }}">
                            </div>
                            <div class="col">
                                <label>Đơn vị tiền tệ</label>
                                <select name="currency" class="form-select">
                                    <option value="VND" {{ old('currency') == 'VND' ? 'selected' : '' }}>VND</option>
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check ms-auto">
                                <input type="checkbox" class="form-check-input" name="salary_negotiable"
                                    id="salary_negotiable" {{ old('salary_negotiable') ? 'checked' : '' }}>
                                <label class="form-check-label" for="salary_negotiable">
                                    Lương thương lượng
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Chế độ đãi ngộ</label>
                            <textarea name="benefits" rows="3" class="form-control">{{ old('benefits') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Vị trí tuyển dụng --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Vị trí tuyển dụng</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="categories[]" class="form-label fw-semibold">Ngành nghề <span
                                        class="text-danger">*</span></label>
                                <select name="categories[]" class="form-select select2" multiple required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ collect(old('categories'))->contains($cat->id) ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col">
                                <label>Cấp bậc</label>
                                <select name="level_id" class="form-select" required>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label>Kinh nghiệm</label>
                                <select name="experience_id" class="form-select shadow-sm border-primary">
                                    <option value="">-- Chọn kinh nghiệm --</option>
                                    @foreach ($experiences as $exp)
                                        <option value="{{ $exp->id }}"
                                            {{ old('experience_id') == $exp->id ? 'selected' : '' }}>
                                            {{ $exp->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3 col">
                                <label>Hạn ứng tuyển</label>
                                <input type="date" name="application_deadline" class="form-control"
                                    value="{{ old('application_deadline') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label>Địa chỉ làm việc <span class="text-danger">*</span></label>
                                <select name="address" class="form-select" required>
                                    @foreach ($company_addresses as $address)
                                        <option value="{{ $address }}"
                                            {{ old('address') == $address ? 'selected' : '' }}>{{ $address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col">
                                <label for="location_id" class="form-label  select2 ">Địa điểm khu vực <span
                                        class="text-danger">*</span></label>
                                <select name="location_id" id="location_id" class="form-select shadow-sm border-primary"
                                    required>
                                    <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>-- Chọn khu
                                        vực --</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Kỹ năng --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">
                        Kỹ năng & Cài đặt khác
                    </div>
                    <div class="card-body">

                        {{-- Nhập kỹ năng --}}
                        <div class="mb-4">
                            <label for="skills_text" class="form-label fw-semibold">Kỹ năng <span
                                    class="text-muted small">(phân cách bằng dấu phẩy)</span></label>
                            <input type="text" name="skills_text" id="skills_text"
                                class="form-control border-primary shadow-sm" placeholder="Ví dụ: PHP, Laravel, MySQL"
                                value="{{ old('skills_text', $selectedSkills ?? '') }}">
                        </div>

                        {{-- Chính sách làm việc --}}
                        <div class="mb-4">
                            <label for="remote_policy_id" class="form-label fw-semibold">Chính sách làm việc</label>
                            <select name="remote_policy_id" id="remote_policy_id"
                                class="form-select shadow-sm border-primary">
                                <option value="">-- Chọn chính sách --</option>
                                @foreach ($remote_policies as $policy)
                                    <option value="{{ $policy->id }}"
                                        {{ old('remote_policy_id') == $policy->id ? 'selected' : '' }}>
                                        {{ $policy->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Ngôn ngữ sử dụng --}}
                        <div class="mb-2">
                            <label for="language_id" class="form-label fw-semibold">Ngôn ngữ sử dụng</label>
                            <select name="language_id" id="language_id" class="form-select shadow-sm border-primary">
                                <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}"
                                        {{ old('language_id') == $lang->id ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                </div>
                {{-- SEO --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">SEO & Tìm kiếm</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{ old('meta_title') }}">
                        </div>
                        <div class="mb-3">
                            <label>Từ khoá (keyword)</label>
                            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}">
                        </div>
                        <div class="mb-3">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="search_index" value="0">
                            <input class="form-check-input" type="checkbox" name="search_index" id="search_index"
                                value="1" {{ old('search_index', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="search_index">
                                Hiển thị trong tìm kiếm
                            </label>
                        </div>
                    </div>
                </div>
                {{-- Chọn gói dịch vụ nếu có --}}
                @if ($activePackages->count())
                    <div class="mb-3">
                        <label for="selected_package" class="form-label fw-semibold">Chọn gói dịch vụ muốn sử dụng</label>
                        <select name="selected_package_id" id="selected_package" class="form-select">
                            <option value="">-- Tự động chọn gói đầu tiên còn lượt --</option>
                            @foreach ($activePackages as $pkg)
                                <option value="{{ $pkg->id }}">
                                    {{ $pkg->package->name }} ({{ $pkg->post_limit - $pkg->posts_used }} lượt còn lại, hết
                                    hạn {{ \Carbon\Carbon::parse($pkg->end_date)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nếu không chọn, hệ thống sẽ chọn gói đầu tiên còn lượt.</small>
                    </div>
                @endif

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
        document.addEventListener('DOMContentLoaded', function() {
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
        $(document).ready(function() {
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
            $('#salary_negotiable').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.salary-inputs').hide();
                } else {
                    $('.salary-inputs').show();
                }
            }).trigger('change');

            $('#title').on('blur', function() {
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
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.querySelector('#skills_text');
            new Tagify(input, {
                delimiters: ",",
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });
        });
    </script>
@endpush
