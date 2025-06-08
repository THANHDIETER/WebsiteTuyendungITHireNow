@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">404_Lỗi</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Trang khác</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu phần thông báo lỗi 404 ==-->
        <section class="page-not-found-area">
            <div class="container pt--0 pb--0">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="page-not-found-wrap">
                            <div class="page-not-found-thumb">
                                <img src="../client/assets/img/photos/404.webp" alt="Hình ảnh lỗi 404">
                            </div>
                            <div class="page-not-found-content">
                                <h2 class="title">Xin lỗi, trang bạn tìm kiếm không tồn tại.</h2>
                                <a class="btn-theme" href="{{ route('home') }}"><i class="icofont-long-arrow-left"></i> Quay về trang chủ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc phần thông báo lỗi 404 ==-->
    </main>
@endsection
