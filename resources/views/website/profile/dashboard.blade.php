@extends('website.layouts.master1')

@section('content')
   <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    <div class="container py-4">

        <div class="row">
            {{-- Sidebar trái --}}
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

            {{-- Nội dung bên phải --}}
            <div class="col-md-9">
                {{-- Thẻ thông tin người dùng --}}
                <div class="bg-white shadow-sm rounded p-4 mb-4 d-flex align-items-center">
                    <div class="d-flex align-items-center gap-3 w-100">
                        {{-- Avatar hoặc icon --}}
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                            style="width:60px; height:60px;">
                            <i class="fa-solid fa-user fa-xl text-muted"></i>
                        </div>

                        {{-- Thông tin + nút --}}
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</h5>
                            <p class="mb-1 text-muted">{{ Auth::user()->email }}</p>
                            <a href="{{ route('profile.show') }}"
                                class="text-primary text-decoration-none mt-2 d-inline-block">
                                Cập nhật hồ sơ của bạn <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection