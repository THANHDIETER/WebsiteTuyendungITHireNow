@extends('website.layouts.master')

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="../client/assets/img/banner/15.png" style="height: 300px;">
        <div class="col-12 col-lg-8">
            <div class="slider-content">

                <h1 class="title text-white">👋 Xin chào:
                    {{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</h1>
            </div>
        </div>
    </div>

    <div class="container mt-4">

        <div class="row">
            {{-- Sidebar trái --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white shadow-sm rounded p-4">
                    <h6 class="fw-semibold text-center mb-3">👋 Xin chào,
                        {{ $profile && $profile->name ? $profile->name : Auth::user()->name }}</h6>
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
                <div class="bg-white shadow-sm rounded p-4">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-briefcase me-2"></i> Việc làm bạn đã ứng tuyển
                    </h5>

                    @forelse ($appliedJobs as $job)
                        {{-- Giao diện hiển thị việc làm đã ứng tuyển --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

                                {{-- Ảnh đại diện công việc --}}
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $job->job_thumbnail) }}" alt="{{ $job->job_title }}"
                                        class="rounded" width="200" height="200" style="object-fit: cover;">
                                </div>

                                {{-- Thông tin công việc --}}
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $job->job_title }}</h6>
                                    <p class="mb-1 text-muted"><i class="fa-solid fa-building me-1"></i>
                                        {{ $job->company_name }}</p>
                                    <p class="mb-1 text-muted"><i class="fa-solid fa-location-dot me-1"></i>
                                        {{ $job->location_name }}</p>
                                    <p class="mb-0 text-muted small">
                                        <i class="fa-regular fa-clock me-1"></i> Ứng tuyển lúc:
                                        {{ \Carbon\Carbon::parse($job->applied_at)->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                {{-- Nút chi tiết --}}
                                <div class="text-md-end w-100 w-md-auto">
                                    <a href="{{ route('profile.view-job', $job->slug) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Xem chi tiết
                                    </a>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-circle-info fa-2x mb-3"></i>
                            <p>Bạn chưa ứng tuyển công việc nào.</p>
                        </div>
                    @endforelse
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $appliedJobs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
