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
    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h6 class="fw-bold text-center mb-3">👋 Xin chào, {{ $profile->full_name ?? 'Chưa cập nhật' }}</h6>
                    <hr>
                    <ul class="nav flex-column gap-2">
                        <li>
                            <a href="{{ route('profile.dashboard') }}"
                                class="nav-link {{ request()->routeIs('profile.dashboard') ? 'active text-white bg-primary' : 'text-dark' }} rounded-3">
                                <i class="fa-solid fa-house me-2"></i> Tổng quan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.show') }}"
                                class="nav-link {{ request()->routeIs('profile.show') ? 'active text-white bg-primary' : 'text-dark' }} rounded-3">
                                <i class="fa-solid fa-file-lines me-2"></i> Hồ sơ HireNow
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.my-jobs') }}"
                                class="nav-link {{ request()->routeIs('profile.my-jobs') ? 'active text-white bg-primary' : 'text-dark' }} rounded-3">
                                <i class="fa-solid fa-briefcase me-2"></i> Việc làm của tôi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.settings') }}"
                                class="nav-link {{ request()->routeIs('profile.settings') ? 'active text-white bg-primary' : 'text-dark' }} rounded-3">
                                <i class="fa-solid fa-gear me-2"></i> Cài đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Main content --}}
            <div class="col-md-9">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h5 class="fw-bold text-primary mb-4">
                        <i class="fa-solid fa-briefcase me-2"></i> Việc làm đã ứng tuyển
                    </h5>

                    @forelse ($appliedJobs as $job)
                        <div class="job-card d-flex align-items-center gap-4 mb-4 p-3 bg-light rounded-3 shadow-sm">
                            {{-- Logo --}}
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $job->job_thumbnail) }}" alt="{{ $job->job_title }}"
                                    width="80" height="80" class="rounded border object-fit-cover">
                            </div>

                            {{-- Info --}}
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $job->job_title }}</h6>
                                <p class="mb-1 text-muted">
                                    <i class="fa-solid fa-building me-1"></i> {{ $job->company_name }}
                                </p>
                                <p class="mb-1 text-muted">
                                    <i class="fa-solid fa-location-dot me-1"></i> {{ $job->location_name }}
                                </p>
                                <small class="text-muted">
                                    <i class="fa-regular fa-clock me-1"></i> Ứng tuyển lúc:
                                    {{ \Carbon\Carbon::parse($job->applied_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>

                            {{-- Action --}}
                            <div class="text-end">
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-circle-info fa-2x mb-3"></i>
                            <p>Bạn chưa ứng tuyển công việc nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
