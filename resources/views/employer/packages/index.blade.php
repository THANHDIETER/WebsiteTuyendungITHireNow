@extends('employer.layouts.default')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h2>Các gói dịch vụ đăng tin</h2>
        <div class="row">
            @foreach($packages as $pkg)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h4 class="card-title">{{ $pkg->name }}</h4>
                        <div class="mb-2 text-success h5">{{ number_format($pkg->price) }} VNĐ</div>
                        <div class="mb-2">Thời hạn: <strong>{{ $pkg->duration_days }} ngày</strong></div>
                        <div class="mb-2">Số lượt đăng: <strong>{{ $pkg->post_limit }}</strong></div>
                        <p>{{ $pkg->description }}</p>
                        <a href="{{ route('employer.packages.purchase', $pkg->id) }}" class="btn btn-primary w-100">Mua ngay</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
