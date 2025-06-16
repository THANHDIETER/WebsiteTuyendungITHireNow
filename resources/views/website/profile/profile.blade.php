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
                        <h4 class="fw-bold mb-2">Về tôi</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Giới thiệu điểm mạnh và số năm kinh nghiệm của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Education Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giáo dục</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Chia sẻ nền tảng giáo dục của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Work Experience Section --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Kinh nghiệm làm việc</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Làm nổi bật thông tin chi tiết về lịch sử công việc của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Kỹ năng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Thể hiện kỹ năng và trình độ của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Ngoại ngữ</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp kỹ năng và trình độ ngôn ngữ của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Dự án nổi bật</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Trưng bày dự án nổi bật của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giấy chứng nhận</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Cung cấp bằng chứng về chuyên môn và kỹ năng cụ thể của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-2">Giải thưởng</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-100 me-3">
                                <h6 class="text-muted">Làm nổi bật các giải thưởng hoặc sự công nhận của bạn</h6>
                            </div>
                            <a href="#" class="btn btn-sm btn-light border position-absolute top-60 end-0 m-3">
                                <i class="fa-solid fa-plus text-danger"></i>
                            </a>
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
@endsection
