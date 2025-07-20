@extends('website.layouts.master')

@section('content')
<div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
        data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
        style="max-height: 80px; height: 80px; padding: 0 !important;">
        &nbsp;
    </div>
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <section class="page-not-found-area bg-light">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-lg p-4 text-center rounded-4 bg-white">
                            <div class="mb-4">
                                <img src="../client/assets/img/photos/404.webp" alt="Hình ảnh lỗi 404"
                                    class="img-fluid mx-auto" style="max-width: 220px;">
                            </div>
                            <h1 class="display-3 fw-bold text-primary mb-2">404</h1>
                            <p class="lead mb-2 text-dark">
                                <strong>Oops! Không tìm thấy trang này.</strong>
                            </p>
                            <p class="mb-4 text-secondary">
                                Xin lỗi, trang bạn tìm kiếm không tồn tại hoặc đã bị xóa.<br>
                                <span class="text-muted small">Sorry, this page is not found or no longer exists.</span>
                            </p>
                            <a class="btn btn-primary btn-lg rounded-pill px-5" href="{{ route('home') }}">
                                <i class="bi bi-arrow-left-short fs-4"></i> Về trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc phần thông báo lỗi 404 ==-->
    </main>
@endsection
