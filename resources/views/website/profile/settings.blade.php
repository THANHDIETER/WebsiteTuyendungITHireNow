@extends('website.layouts.master1')

@section('content')
 <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-white shadow-sm rounded p-4">
                    <h6 class="fw-semibold text-center mb-3">👋 Xin
                        chào,{{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</h6>
                    <hr>
                    
                    <ul class="nav nav-pills flex-column">
                        @auth
                                        @if (auth()->user()->role === 'job_seeker')
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
                          @endif
                                    @endauth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.settings') ? 'active' : 'text-dark' }}"
                                href="{{ route('profile.settings') }}">
                                <i class="fa-solid fa-gear me-2"></i> Cài đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9">
                <!-- Thông tin tài khoản -->
                <div class="bg-white shadow-sm rounded p-4 mb-4">
                    <h5 class="fw-bold mb-3">Thông tin tài khoản</h5>

                    <div class="mb-3">
                        <strong>E-mail: </strong><span>{{ Auth::user()->email }}</span>
                        <div class="text-muted small mt-1">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Bạn không thể thay đổi email tài khoản của mình.
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Họ và tên đầy đủ:
                        </strong><span>{{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</span>
                        <div class="text-muted small mt-1">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Tên tài khoản của bạn được đồng bộ với thông tin hồ sơ.
                        </div>
                    </div>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="bg-white shadow-sm rounded p-4">
                    <h5 class="fw-bold mb-3">Mật khẩu</h5>

                    <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-2"></i> Thay đổi mật khẩu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thay đổi mật khẩu -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.change-password') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Thay đổi mật khẩu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control" autocomplete="off">

                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control">
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                            @error('new_password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@if ($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation'))
    <script>
        var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        changePasswordModal.show();
    </script>
@endif