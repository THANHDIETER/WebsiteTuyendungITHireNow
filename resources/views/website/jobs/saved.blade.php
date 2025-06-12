@extends('website.layouts.master')

@section('content')
<main class="main-content">
    <div class="page-header-area sec-overlay sec-overlay-black"
         data-bg-img="../client/assets/img/photos/bg2.webp">
        <div class="container">
            <!-- Tiêu đề và breadcrumb -->
            <div class="page-header-content text-center">
                <h2 class="title">Việc đã lưu</h2>
                <nav class="breadcrumb-area">
                    <ul class="breadcrumb justify-content-center">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-sep">//</li>
                        <li>Việc đã lưu</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <section class="recent-job-area recent-job-inner-area">
        <div class="container">
            <div class="row">
                @forelse($jobs as $job)
                    {{-- copy y hệt khối hiển thị job như ở index --}}
                    <div class="col-md-6 col-lg-4">
                        {{-- ... giống như trên, có nút Unsave --}}
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p>Bạn chưa lưu việc nào.</p>
                        <a href="{{ route('jobs.index') }}" class="btn-theme">Xem tất cả việc làm</a>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
