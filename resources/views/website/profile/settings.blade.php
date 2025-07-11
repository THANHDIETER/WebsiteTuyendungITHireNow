@extends('website.layouts.master')

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="../client/assets/img/banner/15.png" style="height: 300px;">
        <div class="col-12 col-lg-8">
            <div class="slider-content">
                <h1 class="title text-white">👋 Xin chào: {{ $profile->full_name ?? 'Người dùng' }}</h1>
            </div>
        </div>
    </div>
    <div class="container py-5">
        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white shadow rounded-4 p-4">
                    <h6 class="fw-semibold text-center mb-3">
                        👋 Xin chào, {{ $profile->name ?? Auth::user()->name }}
                    </h6>
                    <hr>
                    <ul class="nav flex-column nav-pills gap-2">
                        @php
                            $items = [
                                ['route' => 'profile.dashboard', 'icon' => 'fa-house', 'label' => 'Tổng quan'],
                                ['route' => 'profile.show', 'icon' => 'fa-file-lines', 'label' => 'Hồ sơ HireNow'],
                                ['route' => 'profile.my-jobs', 'icon' => 'fa-briefcase', 'label' => 'Việc làm của tôi'],
                                ['route' => 'profile.settings', 'icon' => 'fa-gear', 'label' => 'Cài đặt'],
                            ];
                        @endphp
                        @foreach ($items as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs($item['route']) ? 'active text-white bg-primary' : 'text-dark' }} rounded-3">
                                    <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Main content --}}
            <div class="col-md-9">
                {{-- Thông tin tài khoản --}}
                <div class="bg-white shadow rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">🔐 Thông tin tài khoản</h5>

                    <div class="mb-4">
                        <div class="mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</div>
                        <div class="text-muted small">
                            <i class="fa-solid fa-circle-info me-1"></i> Email không thể thay đổi sau khi đăng ký.
                        </div>
                    </div>

                    <div>
                        <div class="mb-2"><strong>Họ và tên:</strong> {{ $profile->name ?? Auth::user()->name }}</div>
                        <div class="text-muted small">
                            <i class="fa-solid fa-circle-info me-1"></i> Tên sẽ được đồng bộ từ hồ sơ của bạn.
                        </div>
                    </div>
                </div>

                {{-- Thay đổi mật khẩu --}}
                <div class="bg-white shadow rounded-4 p-4">
                    <h5 class="fw-bold mb-3">🔒 Bảo mật</h5>
                    <button class="btn btn-outline-danger px-4" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-2"></i> Đổi mật khẩu
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal đổi mật khẩu --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Đổi mật khẩu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
