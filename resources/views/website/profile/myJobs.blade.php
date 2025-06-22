@extends('website.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            {{-- Sidebar trái --}}
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

            {{-- Nội dung bên phải --}}
            <div class="col-md-9">
                <div class="bg-white shadow-sm rounded p-4">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-briefcase me-2"></i> Việc làm bạn đã ứng tuyển
                    </h5>

                    @forelse ($appliedJobs as $job)
                        <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                            <div>
                                <h6 class="mb-1 text-dark fw-semibold">{{ $job->job_title }}</h6>
                                <p class="mb-1 text-muted">
                                    <i class="fa-solid fa-building me-1"></i>
                                    {{ $job->company->name ?? 'Không rõ công ty' }}
                                </p>
                                <p class="mb-0 text-muted">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    {{ $job->location ?? 'Địa điểm không rõ' }}
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('jobs.show', $job->job_id) }}" class="btn btn-sm btn-outline-primary">
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
