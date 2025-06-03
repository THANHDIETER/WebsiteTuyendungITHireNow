@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">404_Error</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Pages</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Faq Area Wrapper ==-->
        <section class="page-not-found-area">
            <div class="container pt--0 pb--0">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="page-not-found-wrap">
                            <div class="page-not-found-thumb">
                                <img src="../client/assets/img/photos/404.webp" alt="Image">
                            </div>
                            <div class="page-not-found-content">
                                <h2 class="title">Sorry, this page is not found.</h2>
                                <a class="btn-theme" href="index.html"><i class="icofont-long-arrow-left"></i> Back to
                                    home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Faq Area Wrapper ==-->
    </main>
@endsection
