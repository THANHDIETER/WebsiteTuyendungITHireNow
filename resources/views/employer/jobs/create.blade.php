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
                                    @if (old('job_type_id')==$type->id) selected
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
                        <textarea id="benefits" name="benefits" rows="3" class="form-control">{{ old('benefits') }}</textarea>
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
                        @if(false)
                        <div class="mb-3 col">
                            <label>Hạn ứng tuyển</label>
                            <input type="date" name="application_deadline" class="form-control"
                                value="{{ old('application_deadline') }}">
                        </div>
                        @endif
                    </div>
                    {{-- Vị trí tuyển dụng --}}
                    <div class="card mb-4 shadow-sm border-0 rounded-3">
                        <div class="card-header bg-primary text-white fw-semibold">Vị trí tuyển dụng</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Chọn chi nhánh / địa chỉ --}}
                                <div class="mb-3 col-md-6">
                                    <label for="branch_id" class="form-label fw-semibold">
                                        Địa chỉ làm việc <span class="text-danger">*</span>
                                    </label>
                                    <select name="branch_id" id="branch_id" class="form-select" required>
                                        <!-- Địa chỉ mặc định công ty -->
                                        <option value="0"
                                            data-city-id="{{ $company->city_id ?? '' }}"
                                            data-address="{{ $company->address }}"
                                            class="text-danger fw-bold"
                                            {{ old('branch_id') == 0 ? 'selected' : '' }}>
                                            {{ $company->address }} - {{ $company->city?->name }}
                                        </option>

                                        <!-- Danh sách chi nhánh -->
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            data-city-id="{{ $branch->city_id }}"
                                            data-address="{{ $branch->address }}"
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name ?? 'Chi nhánh' }} - {{ $branch->address }} - {{ $branch->city?->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Chọn thành phố (location_id) --}}
                                <div class="mb-3 col-md-6">
                                    <label for="location_id" class="form-label">
                                        Thành phố / Khu vực <span class="text-danger">*</span>
                                    </label>
                                    <select name="location_id" id="location_id" class="form-select shadow-sm border-primary" required>
                                        <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>-- Chọn khu vực --</option>
                                        @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Nhập địa chỉ chi tiết --}}
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">
                                    Địa chỉ chi tiết <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="address"
                                    id="address"
                                    class="form-control"
                                    value="{{ old('address', $company->address) }}"
                                    placeholder="VD: Số 25 ngõ 80 Xuân Phương, Nam Từ Liêm">
                            </div>
                        </div>
                    </div>
                    @push('scripts')
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const branchSelect = document.getElementById('branch_id');
                            const locationSelect = document.getElementById('location_id');
                            const addressInput = document.getElementById('address');

                            function syncLocationAndAddress() {
                                const selected = branchSelect.options[branchSelect.selectedIndex];
                                const cityId = selected.dataset.cityId;
                                const addr = selected.dataset.address;

                                // sync location_id
                                if (cityId) {
                                    locationSelect.value = cityId;
                                } else {
                                    locationSelect.value = "";
                                }

                                // sync address
                                if (addr) {
                                    addressInput.value = addr;
                                }

                                // Nếu location có select2 thì trigger lại
                                if ($(locationSelect).hasClass("select2")) {
                                    $(locationSelect).trigger('change');
                                }
                            }

                            branchSelect.addEventListener('change', syncLocationAndAddress);

                            // chạy khi load trang
                            syncLocationAndAddress();
                        });
                    </script>
                    @endpush

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
            <!-- <div class="card mb-4 shadow-sm border-0 rounded-3">
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
                </div> -->
            {{-- Chọn gói dịch vụ nếu có --}}
            @if ($activePackages->count())
            <div class="mb-3">
                <label class="form-label fw-semibold d-block">Chọn gói dịch vụ muốn sử dụng</label>

                <div class="d-flex flex-wrap gap-3">
                    @foreach ($activePackages as $pkg)
                    <div class="package-wrapper" style="position: relative; min-width:280px; max-width:320px; flex:1;">
                        {{-- Radio ẩn --}}
                        <input type="radio" name="selected_package_id"
                            id="pkg{{ $pkg->id }}" value="{{ $pkg->id }}"
                            {{ old('selected_package_id') == $pkg->id ? 'checked' : '' }}
                            class="package-radio">

                        {{-- Card --}}
                        <label for="pkg{{ $pkg->id }}"
                            class="package-card card shadow-sm p-3 w-100">

                            {{-- Vòng tròn hiển thị trong card --}}
                            <span class="radio-circle"></span>

                            <h5 class="card-title text-primary mb-1">{{ $pkg->package->name }}</h5>
                            <h6 class="text-success mb-2">{{ number_format($pkg->package->price, 0, ',', '.') }} VNĐ</h6>

                            <ul class="list-unstyled mb-2 small">
                                <li><strong>Thời hạn sử dụng:</strong> {{ $pkg->package->duration_days }} ngày</li>
                                <li><strong>Số lượt đăng:</strong> {{ $pkg->posts_used }} / {{ $pkg->post_limit }}</li>
                                <li><strong>Nổi bật:</strong> {{ $pkg->package->highlight_days }} ngày</li>
                                @if(false)
                                <li><strong>Lượt xem CV:</strong> {{ $pkg->package->cv_views }}</li>
                                @endif
                                <li><strong>Hỗ trợ:</strong> {{ $pkg->package->support_level }}</li>
                            </ul>

                            @if (!empty($pkg->package->description))
                            <p class="text-muted small">{{ $pkg->package->description }}</p>
                            @endif
                        </label>
                    </div>
                    @endforeach
                </div>

                <small class="text-muted d-block mt-2">
                    Nếu không chọn, hệ thống sẽ tự động chọn gói đầu tiên còn lượt.
                </small>
            </div>
            @else
            <div class="alert alert-info">
                Bạn chưa có gói dịch vụ nào.
                <a href="{{ route('employer.packages.index') }}" class="btn btn-primary btn-sm ms-2">
                    Mua gói dịch vụ
                </a>
            </div>
            @endif


            {{-- CSS --}}
            @push('styles')
            <style>
                .package-radio {
                    display: none;
                    /* Ẩn radio mặc định */
                }

                .package-card {
                    border: 2px solid transparent;
                    transition: all 0.25s ease;
                    position: relative;
                    border-radius: 12px;
                    cursor: pointer;
                }

                /* Vòng tròn góc phải */
                .radio-circle {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    width: 20px;
                    height: 20px;
                    border: 2px solid #007bff;
                    border-radius: 50%;
                    background: #fff;
                    pointer-events: none;
                    transition: all 0.2s;
                }

                /* Khi chọn → vòng tròn xanh + dấu tick */
                .package-radio:checked+.package-card .radio-circle {
                    background: #007bff;
                }

                .package-radio:checked+.package-card .radio-circle::after {
                    content: "✓";
                    color: #fff;
                    font-size: 14px;
                    position: absolute;
                    top: -2px;
                    left: 4px;
                }

                /* Khi chọn card */
                .package-radio:checked+.package-card {
                    border-color: #007bff;
                    background: #f8fbff;
                    box-shadow: 0 0 15px rgba(0, 123, 255, 0.25);
                    transform: scale(1.02);
                }

                /* Hover */
                .package-card:hover {
                    border-color: #80bdff;
                    background: #f9fcff;
                }
            </style>
            @endpush





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