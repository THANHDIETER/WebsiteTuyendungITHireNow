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
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <input type="text" class="form-control"
                                                placeholder="Tiêu đề việc làm hoặc từ khóa">
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option selected>Chọn Thành Phố</option>
                                                <option>Hà Nội</option>
                                                <option>Hồ Chí Minh</option>
                                                <option>Đà Nẵng</option>
                                                <option>Huế</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option selected>Loại Công Việc</option>
                                                <option>Web Designer</option>
                                                <option>Web Developer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                        <div class="form-group">
                                            <button type="submit" class="btn-form-search"><i
                                                    class="icofont-search-1"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-4">
        <h2 class="mb-4 fw-bold">🔔 Tất cả Thông báo</h2>
        @forelse($notifications as $noti)
            <div class="card mb-3 shadow-sm @if (!$noti->read_at) border-warning @endif">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ $noti->data['link_url'] }}" class="text-decoration-none">
                            <h5 class="card-title mb-1">
                                {{ $noti->data['message'] }}
                            </h5>
                        </a>
                        <p class="card-text text-muted small mb-0">
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
            <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
