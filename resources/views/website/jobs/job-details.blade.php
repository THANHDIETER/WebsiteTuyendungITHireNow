@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title">Chi tiết công việc</h2>
                            <nav class="breadcrumb-area">
                                <ul class="breadcrumb justify-content-center">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li><a href="{{ route('jobs.index') }}">Việc làm</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li>Chi tiết</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== Kết thúc header trang ==-->

        <!--== Bắt đầu chi tiết công việc ==-->
        <section class="job-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="job-details-wrap">
                            <div class="job-details-info">
                                <div class="thumb">
                                    <img src="{{ $job->company->logo_url ?? '../client/assets/img/companies/10.webp' }}"
                                         width="130" height="130" alt="Logo công ty">
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ $job->title }}</h4>
                                    <h5 class="sub-title">{{ $job->company->name }}</h5>
                                    <ul class="info-list">
                                        <li><i class="icofont-location-pin"></i> {{ $job->location }}</li>
                                        <li><i class="icofont-phone"></i> {{ $job->company->phone ?? 'N/A' }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-details-price">
                                <h4 class="title">{{ number_format($job->salary_min) }}đ <span>/tháng</span></h4>
                                <a href="#" class="btn-theme">Ứng tuyển ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="job-details-content">
                            <div class="content">
                                <h4 class="title">Mô tả công việc</h4>
                                <p class="desc">{{ $job->description }}</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Yêu cầu</h4>
                                <p class="desc">{{ $job->requirements }}</p>
                            </div>
                            <div class="content">
                                <h4 class="title">Phúc lợi</h4>
                                @php
                                    $benefits = is_array($job->benefits) ? $job->benefits : json_decode($job->benefits, true);
                                @endphp
                                @if (!empty($benefits))
                                    <ul class="job-details-list">
                                        @foreach($benefits as $benefit)
                                            <li><i class="icofont-check"></i> {{ $benefit }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="desc">Không có thông tin phúc lợi.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="job-sidebar">
                            <div class="widget-item">
                                <div class="widget-title">
                                    <h3 class="title">Thông tin</h3>
                                </div>
                                <div class="summery-info">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="table-name">Loại công việc</td>
                                                <td class="dotted">:</td>
                                                <td>
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Mức lương</td>
                                                <td class="dotted">:</td>
                                                <td>{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Địa chỉ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Chính sách làm việc từ xa</td>
                                                <td class="dotted">:</td>
                                                <td>
                                                    @switch($job->remote_policy)
                                                        @case('on-site')
                                                            Làm tại văn phòng
                                                            @break
                                                        @case('hybrid')
                                                            Hybrid
                                                            @break
                                                        @case('remote')
                                                            Làm từ xa
                                                            @break
                                                        @default
                                                            {{ $job->remote_policy }}
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Cấp bậc</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->level }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Kinh nghiệm</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->experience }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngôn ngữ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->language }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Ngày đăng</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-name">Hạn nộp hồ sơ</td>
                                                <td class="dotted">:</td>
                                                <td>{{ $job->deadline->format('d/m/Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== Kết thúc chi tiết công việc ==-->
    </main>
@endsection
