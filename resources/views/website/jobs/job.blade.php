
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

                        <div class="page-header-content">
                            <h2 class="title">Việc làm</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Việc làm</li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu danh sách việc làm ==-->
        <section class="recent-job-area recent-job-inner-area">
            <div class="container">
                <div class="row">
                    @foreach($jobs as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="recent-job-item recent-job-style2-item">
                            <div class="company-info">
                                <div class="logo">
                                    <a href="#">
                                        <img src="{{ $job->company->logo_url ?? '../client/assets/img/companies/w1.webp' }}"
                                             width="75" height="75" alt="Logo công ty">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="name">
                                        <a href="#">{{ $job->company->name }}</a>
                                    </h4>
                                    <p class="address">{{ $job->location }}</p>
                                </div>
                            </div>
                            <div class="main-content">
                                <h3 class="title">
                                    <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                </h3>
                                <h5 class="work-type">
                                    @switch($job->job_type)
                                        @case('full-time')
                                            Toàn thời gian
                                            @break
                                        @case('part-time')
                                            Bán thời gian
                                            @break
                                        @case('remote')
                                            Làm từ xa
                                            @break
                                        @default
                                            {{ $job->job_type }}
                                    @endswitch
                                </h5>
                                <p class="desc">{{ Str::limit($job->description, 100) }}</p>
                            </div>
                            <div class="recent-job-info">
                                <div class="salary">
                                    <h4>{{ number_format($job->salary_min) }}đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <a class="btn-theme btn-sm" href="{{ route('jobs.show', $job->slug) }}">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-area">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc danh sách việc làm ==-->
    </main>
@endsection

