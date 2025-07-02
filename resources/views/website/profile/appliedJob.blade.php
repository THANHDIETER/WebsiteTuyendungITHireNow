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

    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="appliedJob-details-wrap p-4 bg-white rounded shadow-sm">
                    {{-- Ảnh và thông tin công ty --}}
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ !empty($appliedJob->company?->logo_url) ? asset('storage/' . $appliedJob->company->logo_url) : asset('images/default-logo.png') }}"
                            alt="Logo công ty" width="80" height="80" class="rounded me-3"
                            style="object-fit: cover;">
                        <div>
                            <h3 class="mb-1">{{ $appliedJob->title }}</h3>
                            <p class="mb-0 text-muted">{{ $appliedJob->company?->name ?? 'Không rõ công ty' }}</p>
                        </div>
                    </div>

                    {{-- Thông tin cơ bản --}}
                    <ul class="list-unstyled mb-4">
                        <li><i class="fa-solid fa-location-dot me-2 text-primary"></i>
                            {{ $appliedJob->location ?? 'Không rõ địa điểm' }}</li>
                        <li><i class="fa-solid fa-calendar me-2 text-primary"></i> Đăng ngày:
                            {{ $appliedJob->created_at->format('d/m/Y') }}</li>
                        <li><i class="fa-solid fa-dollar-sign me-2 text-primary"></i>
                            Lương:
                            {{ number_format($appliedJob->salary_min ?? 0) }} -
                            {{ number_format($appliedJob->salary_max ?? 0) }} VNĐ/tháng
                        </li>
                    </ul>

                    {{-- Mô tả công việc --}}
                    <h5 class="fw-semibold mt-4">Mô tả công việc</h5>
                    <div class="mb-4">
                        {!! nl2br(e($appliedJob->description ?? 'Không rõ mô tả')) !!}
                    </div>

                    {{-- Yêu cầu --}}
                    <h5 class="fw-semibold mt-4">Yêu cầu công việc</h5>
                    <div class="mb-4">
                        {!! nl2br(e($appliedJob->requirements ?? 'Không rõ yêu cầu')) !!}
                    </div>

                    {{-- Kỹ năng --}}
                    @if ($appliedJob->skills && $appliedJob->skills->count())
                        <h5 class="fw-semibold mt-4">Kỹ năng yêu cầu</h5>
                        <ul class="list-inline mb-4">
                            @foreach ($appliedJob->skills as $skill)
                                <li class="list-inline-item badge bg-primary text-white">{{ $skill->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="d-flex justify-content-start gap-2 mt-4">
                    <form action="{{ route('jobs.show', $appliedJob->slug) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Ứng tuyển ngay
                        </button>
                    </form>

                    <a href="{{ route('profile.my-jobs') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>

            {{-- Cột bên phải: Thông tin công ty --}}
            <div class="col-md-4">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="fw-bold mb-3">Thông tin công ty</h5>
                    <p><strong>Tên:</strong> {{ $appliedJob->company?->name ?? 'Không có' }}</p>
                    <p><strong>SĐT:</strong> {{ $appliedJob->company?->phone ?? 'Không có' }}</p>
                    <p><strong>Email:</strong> {{ $appliedJob->company?->email ?? 'Không có' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $appliedJob->company?->address ?? 'Không có' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
