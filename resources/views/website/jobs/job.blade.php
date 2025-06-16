

@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Bắt đầu header trang ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <!-- ... header content ... -->
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
                            <!-- Company Info and Main Content here -->

                            <!-- Updated action buttons with Save/Unsave -->
                            <div class="recent-job-info d-flex justify-content-between align-items-center">
                                <div class="salary">
                                    <h4>{{ number_format($job->salary_min) }}đ</h4>
                                    <p>/tháng</p>
                                </div>
                                <div class="d-flex">
                                    <!-- Nút Ứng tuyển -->
                                    <a class="btn-theme btn-sm mr-2" href="{{ route('jobs.show', $job->slug) }}">Ứng tuyển ngay</a>

                                    <!-- Nút Lưu việc -->
                                    @auth
                                    <form action="{{ route('jobs.toggleSave', $job) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ auth()->user()->savedJobs->contains($job->id) ? 'btn-danger' : 'btn-outline-primary' }}">
                                            {{ auth()->user()->savedJobs->contains($job->id) ? 'Bỏ lưu' : 'Lưu việc' }}
                                        </button>
                                    </form>
                                    @endauth
                                </div>
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
