@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-5">
            <h2>✏️ Chỉnh sửa tin tuyển dụng</h2>

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
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Thông tin cơ bản</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title">Tiêu đề công việc <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $job->title) }}" required>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label>Ảnh đại diện (thumbnail)</label>
                                <input type="file" name="thumbnail" class="form-control">
                                @if ($job->thumbnail)
                                    <img src="{{ asset('storage/' . $job->thumbnail) }}" alt="Thumbnail" class="mt-2"
                                        style="width: 120px">
                                @endif
                            </div>
                            <div class="mb-3 col">
                                <label for="job_type_id" class="form-label">Hình thức làm việc <span
                                        class="text-danger">*</span></label>
                                <select name="job_type_id" id="job_type_id" class="form-select" required>
                                    <option value="">-- Chọn --</option>
                                    @foreach ($jobTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('job_type_id', $job->job_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label>Mô tả công việc</label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', html_entity_decode($job->description)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Yêu cầu</label>
                            <textarea name="requirements" id="requirements" rows="4" class="form-control">{{ old('requirements', html_entity_decode($job->requirements)) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Lương & Chế độ --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Lương & Chế độ</div>
                    <div class="card-body">
                        <div class="row mb-3 salary-inputs">
                            <div class="col">
                                <label>Lương tối thiểu</label>
                                <input type="number" name="salary_min" class="form-control"
                                    value="{{ old('salary_min', $job->salary_min) }}">
                            </div>
                            <div class="col">
                                <label>Lương tối đa</label>
                                <input type="number" name="salary_max" class="form-control"
                                    value="{{ old('salary_max', $job->salary_max) }}">
                            </div>
                            <div class="col">
                                <label>Đơn vị tiền tệ</label>
                                <select name="currency" class="form-select">
                                    <option value="VND"
                                        {{ old('currency', $job->currency) == 'VND' ? 'selected' : '' }}>VND
                                    </option>
                                    <option value="USD"
                                        {{ old('currency', $job->currency) == 'USD' ? 'selected' : '' }}>USD
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="salary_negotiable" id="salary_negotiable"
                                {{ old('salary_negotiable', $job->salary_negotiable) ? 'checked' : '' }}>
                            <label class="form-check-label" for="salary_negotiable">Lương thương lượng</label>
                        </div>
                        <div class="mb-3">
                            <label>Chế độ đãi ngộ</label>
                            <textarea name="benefits" id="benefits" rows="3" class="form-control">{{ old('benefits', $job->benefits) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Vị trí tuyển dụng --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Vị trí tuyển dụng</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col ">
                                <label for="categories[]" class="form-label fw-semibold">Ngành nghề <span
                                        class="text-danger">*</span></label>
                                <select name="categories[]" class="form-select select2" multiple required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ in_array($cat->id, old('categories', $selectedCategories ?? [])) ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label>Cấp bậc</label>
                                <select name="level_id" class="form-select">
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('level_id', $job->level_id) == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label>Kinh nghiệm</label>
                                <select name="experience_id" class="form-select">
                                    @foreach ($experiences as $exp)
                                        <option value="{{ $exp->id }}"
                                            {{ old('experience_id', $job->experience_id) == $exp->id ? 'selected' : '' }}>
                                            {{ $exp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label>Hạn ứng tuyển</label>
                                <input type="date" name="application_deadline" class="form-control"
                                    value="{{ old('application_deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Địa chỉ làm việc</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $job->address) }}">
                            </div>
                            <div class="col">
                                <label>Địa điểm khu vực</label>
                                <select name="location_id" class="form-select">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id', $job->location_id) == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kỹ năng & chính sách --}}
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white fw-semibold">Kỹ năng & Cài đặt khác</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Kỹ năng</label>
                            <input type="text" name="skills_text" id="skills_text" class="form-control"
                                value="{{ old('skills_text', $selectedSkills ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label>Chính sách làm việc</label>
                            <select name="remote_policy_id" class="form-select">
                                @foreach ($remote_policies as $policy)
                                    <option value="{{ $policy->id }}"
                                        {{ old('remote_policy_id', $job->remote_policy_id) == $policy->id ? 'selected' : '' }}>
                                        {{ $policy->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Ngôn ngữ sử dụng</label>
                            <select name="language_id" class="form-select">
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}"
                                        {{ old('language_id', $job->language_id) == $lang->id ? 'selected' : '' }}>
                                        {{ $lang->name }}</option>
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
                                value="{{ old('meta_title', $job->meta_title) }}">
                        </div>
                        <div class="mb-3">
                            <label>Từ khoá</label>
                            <input type="text" name="keyword" class="form-control"
                                value="{{ old('keyword', $job->keyword) }}">
                        </div>
                        <div class="mb-3">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $job->meta_description) }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="search_index" value="0">
                            <input class="form-check-input" type="checkbox" name="search_index" id="search_index"
                                value="1" {{ old('search_index', $job->search_index) ? 'checked' : '' }}>
                            <label class="form-check-label" for="search_index">Hiển thị trong tìm kiếm</label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">Cập nhật</button>
                    <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-secondary">Huỷ</a>
                </div>
            </form>
        </div>
    </main>
@endsection
