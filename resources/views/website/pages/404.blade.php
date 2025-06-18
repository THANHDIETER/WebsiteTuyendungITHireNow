@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="job-search-wrap">
                                <div class="job-search-form">
                                    <form action="index.html#">
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
                                                        <option value="1" selected>Chọn Thành Phố</option>
                                                        <option value="2">Hà Nội</option>
                                                        <option value="3">Hồ Chí Minh</option>
                                                        <option value="4">Đà Nẵng</option>
                                                        <option value="5">Huế</option>
                                                        <option value="6">Hà Nam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="1" selected>Loại Công Việc</option>
                                                        <option value="2">Web Designer</option>
                                                        <option value="3">Web Developer</option>
                                                        <option value="4">Graphic Designer</option>
                                                        <option value="5">App Developer</option>
                                                        <option value="6">UI &amp; UX Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn-form-search"><i
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
            <!--== Kết thúc header trang ==-->
        </div>
        <!--== Bắt đầu phần thông báo lỗi 404 ==-->
        <section class="page-not-found-area py-5 bg-light">
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
