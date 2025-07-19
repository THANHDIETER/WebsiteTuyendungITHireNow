@extends('website.layouts.master')

@section('content')
  <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>

    {{-- Nội dung chính --}}
    <div class="container py-4">
        <div class="row">
            {{-- Sidebar trái --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white shadow-sm rounded p-4">
                    <h6 class="fw-semibold text-center mb-3">👋 Xin chào, {{ $profile->name ?? Auth::user()->name }}</h6>
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

                    @forelse ($appliedJobs as $application)
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="row g-0 align-items-center">
                                {{-- Hình --}}
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . ($application->job->thumbnail ?? 'default.jpg')) }}"
                                         alt="{{ $application->job->title }}"
                                         class="img-fluid rounded-start"
                                         style="height: 100%; object-fit: cover;">
                                </div>
                                {{-- Nội dung --}}
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-dark">{{ $application->job->title }}</h6>
                                        <p class="mb-1 text-muted">
                                            <i class="fa-solid fa-building me-1"></i>
                                            {{ $application->job->company->name ?? 'Không rõ' }}
                                        </p>
                                        <p class="mb-1 text-muted">
                                            <i class="fa-solid fa-location-dot me-1"></i>
                                            {{ $application->job->location->name ?? 'Không rõ' }}
                                        </p>
                                        <p class="mb-2 text-muted small">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            Ứng tuyển lúc: {{ $application->created_at->format('d/m/Y H:i') }}
                                        </p>

                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('profile.view-job', $application->job->slug) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Xem chi tiết
                                            </a>
                                            @if ($application->job->company && $application->job->company->user)
                                                <a href="{{ route('chat.start', $application->job->company->user->id) }}"
                                                   class="btn btn-sm btn-success">
                                                    Nhắn tin
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-circle-info fa-2x mb-3"></i>
                            <p>Bạn chưa ứng tuyển công việc nào.</p>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $appliedJobs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
