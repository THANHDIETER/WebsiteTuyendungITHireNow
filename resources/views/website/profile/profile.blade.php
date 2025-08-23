@extends('website.layouts.master1')

@section('content')
   <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <div class="container py-4">

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-white shadow-sm rounded p-4">
                    <h6 class="fw-semibold text-center mb-3">👋 Xin
                        chào,{{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</h6>
                    <hr>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('profile.dashboard') ? 'active' : 'text-dark' }}"
                                href="{{ route('profile.dashboard') }}">
                                <i class="fa-solid fa-house me-2"></i> Tổng quan
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : 'text-dark' }}"
                                href="{{ route('profile.show') }}">
                                <i class="fa-solid fa-file-lines me-2"></i> Hồ sơ HireNow
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('profile.my-jobs') ? 'active' : 'text-dark' }}"
                                href="{{ route('profile.my-jobs') }}">
                                <i class="fa-solid fa-briefcase me-2"></i> Việc làm của tôi
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.settings') ? 'active' : 'text-dark' }}"
                                href="{{ route('profile.settings') }}">
                                <i class="fa-solid fa-gear me-2"></i> Cài đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="col-md-9">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="bg-white shadow-sm rounded p-4 position-relative">
                    {{-- Edit Profile Button --}}
                    <button type="button" class="btn btn-sm btn-light border position-absolute top-0 end-0 m-3"
                        data-bs-toggle="modal" data-bs-target="#editProfileModal" title="Chỉnh sửa hồ sơ">
                        <i class="bi bi-plus-circle text-danger"></i>
                    </button>

                    {{-- Avatar and Information --}}
                    <div class="d-flex flex-wrap align-items-start gap-4">
                        {{-- Avatar --}}

                        <div class="flex-shrink-0">
                            @if ($profile && $profile->avatar)
                                <img src="{{ asset($profile->avatar) }}" alt="Avatar" class="rounded-circle border"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center text-muted"
                                    style="width: 100px; height: 100px; font-size: 36px;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow-1">
                            <h5 class="mb-1">
                                {{ $profile && $profile->name ? $profile->name : Auth::user()->name }}
                            </h5>
                            <p class="text-decoration-none mt-2 d-inline-block">
                                Cập nhật tiêu đề của bạn
                            </p>
                        </div>
                        {{-- User Info --}}

                        <div class="flex-grow-1">
                            <div class="row row-cols-1 row-cols-md-2 g-3 fs-6">
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-envelope text-secondary"></i>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-phone text-secondary"></i>
                                    <span>{{ $profile->phone_number ?? 'Chưa cập nhật' }}</span>
                                </div>
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-gift text-secondary"></i>
                                    <span>{{ $profile->date_of_birth ?? '' ? \Carbon\Carbon::parse($profile->date_of_birth)->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                                </div>
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-user text-secondary"></i>
                                    <span>{{ ucfirst($profile->gender ?? 'Chưa cập nhật') }}</span>
                                </div>
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-secondary"></i>
                                    <span>{{ $profile->address ?? 'Chưa cập nhật' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- About Me Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giới thiệu bản thân</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Giới thiệu điểm mạnh và số năm kinh nghiệm của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#aboutMeModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>
                    {{-- CV Section --}}
                <div class="mt-5">
                    <h4 class="fw-bold mb-2">CV của tôi</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-100 me-3 me-5">
                            @if ($profile && $profile->cvs && count($profile->cvs) > 0)
                                <ul class="list-group">
                                    @foreach ($profile->cvs as $cv)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-pdf text-danger fs-7"></i>
                                                <a href="{{ asset('storage/' . $cv->file_path) }}" target="_blank" class="fw-semibold text-decoration-none">
                                                    {{ $cv->title ?? basename($cv->file_path) }}
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi bi-calendar-event"></i> {{ $cv->created_at->format('d/m/Y') }}
                                                </span>

                                                <form action="{{ route('profile.cv.delete', $cv->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá CV này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <h6 class="text-muted">Bạn chưa tải lên CV nào</h6>
                            @endif
                        </div>
                        <button type="button" class="ms-2 btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                            data-bs-toggle="modal" data-bs-target="#cvModal">
                            <i class="bi bi-plus-circle text-danger"></i>
                        </button>
                    </div>
                </div>

                    {{-- Education Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Học vấn</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Chia sẻ nền tảng giáo dục của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#educationModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Work Experience Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Kinh nghiệm làm việc</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Làm nổi bật thông tin chi tiết về lịch sử công việc của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#workExperienceModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Skills Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Kỹ năng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Thể hiện kỹ năng và trình độ của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#skillModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Languages Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Ngoại ngữ</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp kỹ năng và trình độ ngôn ngữ của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#languageModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Projects Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Dự án nổi bật</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Trưng bày dự án nổi bật của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#projectModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Certificates and Awards Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Chứng chỉ</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp bằng chứng về chuyên môn và kỹ năng cụ thể của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#certificateModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Achievements Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giải thưởng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Làm nổi bật các giải thưởng hoặc sự công nhận của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#awardModal">
                                <i class="bi bi-plus-circle text-danger"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa hồ sơ -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Cập nhật hồ sơ cá nhân</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- Ảnh đại diện -->
                            <div class="col-md-4 border-end">
                                <label class="form-label fw-semibold">Ảnh đại diện</label>
                                <input type="file" name="avatar" class="form-control mb-2">
                                @error('avatar')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                @if (!empty($profile->avatar))
                                    <p class="mb-1">Ảnh hiện tại:</p>
                                    <img src="{{ asset($profile->avatar) }}" alt="Avatar" class="rounded border"
                                        width="120">
                                @endif
                            </div>

                            <!-- Cột giữa -->
                            <div class="col-md-4 border-end">
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $profile && $profile->name ? $profile->name : Auth::user()->name }}">
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control bg-light" name="email"
                                        value="{{ Auth::user()->email }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                                    @error('phone_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}">
                                    @error('date_of_birth')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cột phải -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <select name="gender" class="form-select">
                                        <option value="">-- Chọn giới tính --</option>
                                        <option value="nam"
                                            {{ old('gender', $profile->gender ?? '') === 'nam' ? 'selected' : '' }}>Nam
                                        </option>
                                        <option value="nữ"
                                            {{ old('gender', $profile->gender ?? '') === 'nữ' ? 'selected' : '' }}>Nữ
                                        </option>
                                        <option value="khác"
                                            {{ old('gender', $profile->gender ?? '') === 'khác' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Thành phố</label>
                                    <select name="city" class="form-select">
                                        <option value="">-- Chọn thành phố --</option>
                                        @foreach (['Hà Nội', 'Hồ Chí Minh', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng', 'Khác'] as $city)
                                            <option value="{{ $city }}"
                                                {{ old('city', $profile->city ?? '') === $city ? 'selected' : '' }}>
                                                {{ $city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $profile->address ?? '') }}">
                                    @error('address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu hồ sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Upload CV --}}
<div class="modal fade" id="cvModal" tabindex="-1" aria-labelledby="cvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.uploadCVs') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="cvModalLabel">Tải lên CV (PDF)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn CV (nhiều file)</label>
                        <input type="file" name="cv_files[]" class="form-control" accept="application/pdf" multiple>
                        <div class="form-text">Chỉ hỗ trợ file PDF, dung lượng tối đa 2MB.</div>
                        @error('cv_files')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal: Giới thiệu bản thân -->
    <div class="modal fade" id="aboutMeModal" tabindex="-1" aria-labelledby="aboutMeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.about-me.update') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="aboutMeModalLabel">Giới thiệu bản thân</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="about_me" class="form-label">Nội dung</label>
                            <textarea id="about_me" name="about_me" class="form-control" placeholder="...">{{ old('about_me') }}</textarea>
                            @error('about_me')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Học vấn --}}
    <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.education.update') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="educationModalLabel">Học vấn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="school" class="form-label">Trường <span class="text-danger">*</span></label>
                            <input type="text" id="school" name="school" class="form-control"
                                value="{{ old('school') }}" placeholder="Nhập tên trường học">
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="degree" class="form-label">Trình độ <span
                                        class="text-danger">*</span></label>
                                <select id="degree" name="degree" class="form-select">
                                    <option value="">Chọn trình độ</option>
                                    <option value="dai-hoc">Đại học</option>
                                    <option value="cao-dang">Cao đẳng</option>
                                    <option value="thac-si">Thạc sĩ</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="field" class="form-label">Ngành học <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="field" name="field" class="form-control"
                                    value="{{ old('field') }}" placeholder="Nhập ngành học">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Từ (tháng/năm)</label>
                                <input type="month" id="start_date" name="start_date" class="form-control"
                                    value="{{ old('start_date') }}">
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">Đến (tháng/năm)</label>
                                <input type="month" id="end_date" name="end_date" class="form-control"
                                    value="{{ old('end_date') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="details" class="form-label">Thông tin chi tiết khác</label>
                            <textarea id="details" name="details" class="form-control" rows="3">{{ old('details') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Kinh nghiệm làm việc --}}
    <div class="modal fade" id="workExperienceModal" tabindex="-1" aria-labelledby="workExperienceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.work_experience.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="workExperienceModalLabel">Kinh nghiệm làm việc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="position" class="form-label">Chức danh <span class="text-danger">*</span></label>
                            <input type="text" id="position" name="position" class="form-control"
                                placeholder="Nhập chức danh" value="{{ old('position') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="companyName" class="form-label">Tên công ty <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="companyName" name="company_name" class="form-control"
                                placeholder="Nhập tên công ty" value="{{ old('company_name') }}">
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Từ (tháng/năm)</label>
                                <input type="month" id="start_date" name="start_date" class="form-control"
                                    value="{{ old('start_date') }}">
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">Đến (tháng/năm)</label>
                                <input type="month" id="end_date" name="end_date" class="form-control"
                                    value="{{ old('end_date') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="work_description" class="form-label">Mô tả chi tiết</label>
                            <textarea id="work_description" name="work_description" class="form-control" placeholder="...">{{ old('work_description') }}</textarea>
                            @error('work_description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="project_details" class="form-label">Dự án</label>
                            <textarea id="project_details" name="project_details" class="form-control" placeholder="...">{{ old('project_details') }}</textarea>
                            @error('project_details')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Kỹ năng --}}
    <div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.skills.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="skillModalLabel">Kỹ năng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Tên nhóm <span class="text-danger">*</span></label>
                            <select name="group_name" id="groupName" class="form-select" required>
                                <option value="" disabled selected>-- Chọn kỹ năng --</option>
                                <option value="soft_skills">Kỹ năng mềm</option>
                                <option value="hard_skills">Kỹ năng chuyên môn</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="skillInput" class="form-label">Tên kỹ năng <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="skillInput" name="skill_input" class="form-control"
                                placeholder="Nhập kỹ năng" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger" id="saveBtn">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Ngoại ngữ --}}
    <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.languages.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="languageModalLabel">Ngoại ngữ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Dòng nhập ngôn ngữ -->
                        <div class="d-flex gap-2 mb-3">
                            <select name="language" id="languageSelect" class="form-select">
                                <option value="" disabled selected>Chọn ngôn ngữ</option>
                                <option value="english">Tiếng Anh</option>
                                <option value="french">Tiếng Pháp</option>
                                <option value="german">Tiếng Đức</option>
                                <option value="spanish">Tiếng Tây Ban Nha</option>
                                <option value="chinese">Tiếng Trung</option>
                                <option value="japanese">Tiếng Nhật</option>
                                <option value="korean">Tiếng Hàn Quốc</option>
                            </select>

                            <select id="languageLevel" name="language_level" class="form-select">
                                <option value="" disabled selected>Chọn trình độ</option>
                                <option value="basic">Cơ bản</option>
                                <option value="intermediate">Trung cấp</option>
                                <option value="advanced">Nâng cao</option>
                                <option value="native">Thành thạo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Dự án nổi bật --}}
    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.project.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="projectModalLabel">Dự án nổi bật</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên dự án --}}
                        <div class="mb-3">
                            <label for="projectName" class="form-label">Tên dự án <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="project_name" class="form-control" placeholder="Nhập tên dự án">
                        </div>

                        {{-- Ngày bắt đầu / kết thúc --}}
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                <input type="month" id="start_date" name="start_date" class="form-control"
                                    value="{{ old('start_date') }}">
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">Ngày kết thúc</label>
                                <input type="month" id="end_date" name="end_date" class="form-control"
                                    value="{{ old('end_date') }}">
                            </div>
                        </div>

                        {{-- Mô tả --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="projectModal" class="form-label fw-semibold mb-0">Mô tả dự án</label>
                            </div>
                            <textarea id="project_description" name="project_description" class="form-control" placeholder="...">{{ old('project_description') }}</textarea>
                        </div>

                        {{-- Website --}}
                        <div class="mb-3">
                            <input type="url" name="project_link" class="form-control"
                                placeholder="Đường dẫn website (nếu có)">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Chứng chỉ --}}
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.certificates.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="certificateModalLabel">Chứng chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên chứng chỉ --}}
                        <div class="mb-3">
                            <label for="certificateName" class="form-label">Tên chứng chỉ <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="certificate_name" class="form-control"
                                placeholder="Nhập tên chứng chỉ">
                        </div>

                        {{-- Tổ chức --}}
                        <div class="mb-3">
                            <label for="organization" class="form-label">Tổ chức <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="organization" class="form-control" placeholder="Nhập tổ chức">
                        </div>

                        {{-- Thời gian --}}
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Tháng/năm</label>
                                <input type="month" id="start_date" name="start_date" class="form-control"
                                    value="{{ old('start_date') }}">
                            </div>
                        </div>

                        {{-- Link chứng chỉ --}}
                        <div class="mb-3">
                            <input type="url" name="certificate_link" class="form-control"
                                placeholder="Link chứng chỉ (nếu có)">
                        </div>

                        {{-- Mô tả chi tiết --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="projectDescription" class="form-label fw-semibold mb-0">Mô tả chi tiết</label>
                            </div>
                            <textarea id="projectDescription" name="project_description" class="form-control" placeholder="..."
                                {{ old('project_description') }}></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Giải thưởng --}}
    <div class="modal fade" id="awardModal" tabindex="-1" aria-labelledby="awardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.award.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="awardModalLabel">Giải thưởng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên giải thưởng --}}
                        <div class="mb-3">
                            <label for="awardName" class="form-label">Tên giải thưởng <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="award_name" class="form-control"
                                placeholder="Nhập tên giải thưởng">
                        </div>

                        {{-- Tổ chức --}}
                        <div class="mb-3">
                            <label for="organization" class="form-label">Tổ chức <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="organization" class="form-control"
                                placeholder="Nhập tên tổ chức">
                        </div>

                        {{-- Thời gian --}}
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Tháng/năm</label>
                                <input type="month" id="start_date" name="start_date" class="form-control"
                                    value="{{ old('start_date') }}">
                            </div>
                        </div>

                        {{-- Mô tả chi tiết --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="projectDescription" class="form-label fw-semibold mb-0">Mô tả chi tiết</label>
                            </div>
                            <textarea id="projectDescription" name="project_description" class="form-control" placeholder="...">{{ old('project_description') }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const skills = [];
        const skillInput = document.getElementById('skillInput');
        const addSkillBtn = document.getElementById('addSkillBtn');
        const skillList = document.getElementById('skillList');
        const skillsJson = document.getElementById('skillsJson');
        const saveBtn = document.getElementById('saveBtn');
        const emptySkillList = document.getElementById('emptySkillList');

        function renderSkills() {
            skillList.innerHTML = '';
            skills.forEach((skill, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.textContent = skill;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-outline-danger';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = () => {
                    skills.splice(index, 1);
                    renderSkills();
                };

                li.appendChild(removeBtn);
                skillList.appendChild(li);
            });

            // Cập nhật JSON vào hidden input
            skillsJson.value = JSON.stringify(skills);

            // Ẩn hiện danh sách
            if (skills.length > 0) {
                skillList.classList.remove('d-none');
                emptySkillList.querySelector('div').style.display = 'none';
                saveBtn.disabled = false;
            } else {
                skillList.classList.add('d-none');
                emptySkillList.querySelector('div').style.display = 'block';
                saveBtn.disabled = true;
            }
        }

        addSkillBtn.addEventListener('click', () => {
            const value = skillInput.value.trim();
            if (value && !skills.includes(value)) {
                skills.push(value);
                skillInput.value = '';
                renderSkills();
            }
        });
    });
</script> --}}