@extends('website.layouts.master')

@section('title', 'Thông báo')

@section('content')
    <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/banner/15.png">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="job-search-wrap">
                        <div class="job-search-form">
                            <form action="#">
                                <div class="row row-gutter-10">
                                    <!-- Form tìm kiếm (giữ nguyên hoặc có thể ẩn nếu không dùng) -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-primary">
            <i class="icofont-notification"></i> Tất cả Thông báo
        </h2>

        @forelse($notifications as $noti)
            <div
                class="card mb-3 shadow-sm border-0 position-relative @if (!$noti->read_at) bg-light border-start border-4 border-warning @endif">
                <div class="card-body d-flex justify-content-between align-items-start flex-wrap">
                    <div class="me-3 flex-grow-1">
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none text-dark">
                            <h5 class="mb-2">
                                <i class="icofont-bell me-2 text-warning"></i> {{ $noti->data['message'] }}
                            </h5>
                        </a>
                        <p class="mb-0 text-muted small">
                            {{ $noti->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div>
                        @if ($noti->read_at)
                            <span class="badge bg-secondary">Đã đọc</span>
                        @else
                            <span class="badge bg-warning text-dark">Chưa đọc</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="icofont-info-circle"></i> Bạn chưa có thông báo nào.
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
