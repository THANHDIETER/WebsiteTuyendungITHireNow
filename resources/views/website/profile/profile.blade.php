@extends('website.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-white shadow-sm rounded p-4">
                    <h6 class="fw-semibold text-center mb-3">👋 Xin chào,{{ $profile->full_name ?? 'Chưa cập nhật' }}</h6>
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
                        <i class="fa-solid fa-pencil-alt text-danger"></i>
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
                                    {{ strtoupper(substr(Auth::user()->full_name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $profile->full_name ?? 'Chưa cập nhật' }}</h5>
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
                                    <span>{{ $profile->phone ?? 'Chưa cập nhật' }}</span>
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
                                <i class="fa-solid fa-plus text-danger"></i>
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
                                <i class="fa-solid fa-plus text-danger"></i>
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
                                <i class="fa-solid fa-plus text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Kỹ năng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Thể hiện kỹ năng và trình độ của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#skillModal">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Ngoại ngữ</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp kỹ năng và trình độ ngôn ngữ của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#languageModal">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Dự án nổi bật</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Trưng bày dự án nổi bật của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#projectModal">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Chứng chỉ</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp bằng chứng về chuyên môn và kỹ năng cụ thể của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#certificateModal">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giải thưởng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Làm nổi bật các giải thưởng hoặc sự công nhận của bạn</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#awardModal">
                                <i class="fa-solid fa-plus text-danger"></i>
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
                <form method="POST" action="" enctype="multipart/form-data">
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
                                    <input type="text" name="full_name" class="form-control"
                                        value="{{ old('full_name', $profile->full_name ?? '') }}">
                                    @error('full_name')
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
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $profile->phone ?? '') }}">
                                    @error('phone')
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

    <!-- Modal: Giới thiệu bản thân -->
    <div class="modal fade" id="aboutMeModal" tabindex="-1" aria-labelledby="aboutMeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="">
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
                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="educationModalLabel">Học vấn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="school" class="form-label">Trường <span class="text-danger">*</span></label>
                            <input type="text" id="school" name="school" class="form-control" placeholder="">
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="degree" class="form-label">Trình độ <span
                                        class="text-danger">*</span></label>
                                <select id="degree" name="degree" class="form-select">
                                    <option value="">Chọn</option>
                                    <option value="dai-hoc">Đại học</option>
                                    <option value="cao-dang">Cao đẳng</option>
                                    <option value="thac-si">Thạc sĩ</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col">
                                <label for="field" class="form-label">Ngành học <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="field" name="field" class="form-control"
                                    placeholder="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="startMonth" class="form-label">Từ <span class="text-danger">*</span></label>
                                <select id="startMonth" name="start_month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label for="startYear" class="form-label">Năm</label>
                                <select id="startYear" name="start_year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = date('Y'); $i >= 1900; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="endMonth" class="form-label">Đến <span class="text-danger">*</span></label>
                                <select id="endMonth" name="end_month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label for="endYear" class="form-label">Năm</label>
                                <select id="endYear" name="end_year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = date('Y'); $i >= 1900; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="details" class="form-label">Thông tin chi tiết khác</label>
                            <textarea id="details" name="details" class="form-control" placeholder="...">{{ old('details') }}</textarea>
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
                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="workExperienceModalLabel">Kinh nghiệm làm việc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="position" class="form-label">Chức danh <span class="text-danger">*</span></label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="companyName" class="form-label">Tên công ty <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="companyName" name="company_name" class="form-control"
                                placeholder="">
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="startMonth" class="form-label">Từ <span class="text-danger">*</span></label>
                                <select id="startMonth" name="start_month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label for="startYear" class="form-label">Năm</label>
                                <select id="startYear" name="start_year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = date('Y'); $i >= 1900; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="endMonth" class="form-label">Đến <span class="text-danger">*</span></label>
                                <select id="endMonth" name="end_month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label for="endYear" class="form-label">Năm</label>
                                <select id="endYear" name="end_year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = date('Y'); $i >= 1900; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
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
                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="skillModalLabel">Kỹ năng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Tên nhóm -->
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Tên nhóm <span class="text-danger">*</span></label>
                            <select name="group_name" id="groupName" class="form-select">
                                <option value="" disabled selected>-- Chọn kỹ năng --</option>
                                <option value="soft_skills">Kỹ năng mềm</option>
                                <option value="hard_skills">Kỹ năng chuyên môn</option>
                            </select>
                        </div>

                        <!-- Danh sách kỹ năng -->
                        <label class="form-label fw-bold">Danh sách kỹ năng (0/20)</label>
                        <div class="input-group mb-3">
                            <input type="text" id="skillInput" name="skill_input" class="form-control"
                                placeholder="Nhập kỹ năng">
                            <button type="button" class="btn btn-danger" id="addSkillBtn">+</button>
                        </div>

                        <!-- Hiển thị danh sách hoặc trống -->
                        <div class="text-center text-muted py-5" id="emptySkillList">
                            <img src="https://itviec.com/assets/everything-empty-62c813bcb84be8a092033e40550b6fdc9f6bda05947d60c619b2a74906144f8b.svg"
                                alt="empty" width="40" class="mb-2">
                            <div>Chưa có kỹ năng nào</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger" id="saveBtn" disabled>Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Ngoại ngữ --}}
    <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="languageModalLabel">Ngoại ngữ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Tiêu đề danh sách -->
                        <label class="form-label fw-bold mb-2">Danh sách ngôn ngữ (0/5)</label>

                        <!-- Dòng nhập ngôn ngữ -->
                        <div class="d-flex gap-2 mb-3">
                            <select name="language" id="languageSelect" class="form-select">
                                <option value="" disabled selected>Tìm ngôn ngữ</option>
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

                            <button type="button" class="btn btn-danger px-3">
                                +
                            </button>
                        </div>

                        <!-- Danh sách ngôn ngữ đã thêm (hiện tại trống) -->
                        <div class="text-center text-muted py-5">
                            <img src="https://itviec.com/assets/everything-empty-62c813bcb84be8a092033e40550b6fdc9f6bda05947d60c619b2a74906144f8b.svg"
                                alt="empty" width="40" class="mb-2">
                            <div>Chưa có ngôn ngữ nào</div>
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

                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="projectModalLabel">Dự án nổi bật</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên dự án --}}
                        <div class="mb-3">
                            <input type="text" name="project_name" class="form-control" placeholder="Tên dự án *">
                        </div>

                        {{-- Ngày bắt đầu / kết thúc --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Ngày bắt đầu <span
                                        class="text-danger">*</span></label>
                                <div class="row g-2">
                                    <div class="col">
                                        <select name="start_month" class="form-select">
                                            <option value="">Tháng</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="start_year" class="form-select">
                                            <option value="">Năm</option>
                                            @for ($i = now()->year; $i >= 1950; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label fw-semibold">Ngày kết thúc <span
                                        class="text-danger">*</span></label>
                                <div class="row g-2">
                                    <div class="col">
                                        <select name="end_month" class="form-select">
                                            <option value="">Tháng</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="end_year" class="form-select">
                                            <option value="">Năm</option>
                                            @for ($i = now()->year; $i >= 1950; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Mô tả --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="projectModal" class="form-label fw-semibold mb-0">Mô tả dự án</label>
                            </div>
                            <textarea id="projectModal" name="projectModal" class="form-control" placeholder="...">{{ old('projectModal') }}</textarea>
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

                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="certificateModalLabel">Chứng chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên chứng chỉ --}}
                        <div class="mb-3">
                            <input type="text" name="certificate_name" class="form-control"
                                placeholder="Tên chứng chỉ *">
                        </div>

                        {{-- Tổ chức --}}
                        <div class="mb-3">
                            <input type="text" name="organization" class="form-control" placeholder="Tổ chức *">
                        </div>

                        {{-- Thời gian --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Tháng <span class="text-danger">*</span></label>
                                <select name="month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Năm <span class="text-danger">*</span></label>
                                <select name="year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = now()->year; $i >= 1950; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
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

                <form method="POST" action="">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="awardModalLabel">Giải thưởng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tên giải thưởng --}}
                        <div class="mb-3">
                            <input type="text" name="award_name" class="form-control"
                                placeholder="Tên giải thưởng*">
                        </div>

                        {{-- Tổ chức --}}
                        <div class="mb-3">
                            <input type="text" name="organization" class="form-control" placeholder="Tổ chức *">
                        </div>

                        {{-- Thời gian --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Tháng <span class="text-danger">*</span></label>
                                <select name="month" class="form-select">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Năm <span class="text-danger">*</span></label>
                                <select name="year" class="form-select">
                                    <option value="">Năm</option>
                                    @for ($i = now()->year; $i >= 1950; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        {{-- Mô tả chi tiết --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="projectDescription" class="form-label fw-semibold mb-0">Mô tả chi tiết</label>
                            </div>
                            <textarea id="projectDescription" name="project_description" class="form-control" placeholder="..."
                                >{{ old('project_description') }}</textarea>
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
