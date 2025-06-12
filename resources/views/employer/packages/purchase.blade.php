@extends('employer.layouts.default')
@section('content')
<main class="main-content">
    <div class="container py-5">
        <h2>Xác nhận mua gói: {{ $package->name }}</h2>
        <div class="card p-4">
            <p>Giá: <strong>{{ number_format($package->price) }} VNĐ</strong></p>
            <p>Thời hạn: {{ $package->duration_days }} ngày</p>
            <p>Số lượt đăng: {{ $package->post_limit }}</p>
            <form action="{{ route('employer.packages.doBuy', $package->id) }}" method="post">
                @csrf
                <button class="btn btn-success">Xác nhận mua</button>
                <a href="{{ route('employer.packages.index') }}" class="btn btn-outline-secondary ms-2">Huỷ</a>
            </form>
        </div>
    </div>
</main>
@endsection
