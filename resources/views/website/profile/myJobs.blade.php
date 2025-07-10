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
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h6 class="fw-bold text-center mb-3">
                        👋 Xin chào, {{ $profile->full_name ?? 'Chưa cập nhật' }}
                    </h6>
                    <hr>
                    <ul class="nav flex-column gap-2">
                        @php
                            $tabs = [
                                ['route' => 'profile.dashboard', 'icon' => 'house', 'label' => 'Tổng quan'],
                                ['route' => 'profile.show', 'icon' => 'file-lines', 'label' => 'Hồ sơ HireNow'],
                                ['route' => 'profile.my-jobs', 'icon' => 'briefcase', 'label' => 'Việc làm của tôi'],
                                ['route' => 'profile.settings', 'icon' => 'gear', 'label' => 'Cài đặt'],
                            ];
                        @endphp

                        @foreach ($tabs as $tab)
                            <li>
                                <a href="{{ route($tab['route']) }}"
                                    class="nav-link d-flex align-items-center gap-2 rounded-3 {{ request()->routeIs($tab['route']) ? 'active text-white bg-primary' : 'text-dark' }}">
                                    <i class="fa-solid fa-{{ $tab['icon'] }}"></i> {{ $tab['label'] }}
                                </a>
                            </li>
                        @endforeach
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
                        <div
                            class="bg-light rounded-4 border border-1 p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 shadow-sm">
                            {{-- Logo --}}
                            <div class="d-flex align-items-center mb-3 mb-md-0 gap-3 w-100 w-md-auto">
                                <img src="{{ asset('storage/' . $job->job_thumbnail) }}" alt="{{ $job->job_title }}"
                                    class="rounded border" width="80" height="80" style="object-fit: cover;">
                                <div>
                                    <h6 class="fw-semibold mb-1 text-dark">{{ $job->job_title }}</h6>
                                    <p class="mb-1 text-muted"><i class="fa-solid fa-building me-1"></i>
                                        {{ $job->company_name }}</p>
                                    <p class="mb-0 text-muted"><i class="fa-solid fa-location-dot me-1"></i>
                                        {{ $job->location_name }}</p>
                                </div>
                            </div>

                            {{-- Thời gian + Nút --}}
                            <div class="text-md-end w-100 w-md-auto">
                                <p class="text-muted small mb-2">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    Ứng tuyển: {{ \Carbon\Carbon::parse($job->applied_at)->format('d/m/Y H:i') }}
                                </p>
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    class="btn btn-outline-primary btn-sm rounded-pill">
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
