@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-5">
            <h2 class="mb-4">Các gói dịch vụ đăng tin</h2>

            @if ($packages->isEmpty())
                <div class="alert alert-info">
                    Hiện chưa có gói dịch vụ nào. Vui lòng liên hệ admin để được hỗ trợ.
                </div>
            @else
                <div class="row">
                    @foreach ($packages as $pkg)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title">{{ $pkg->name }}</h4>
                                    <div class="mt-2 mb-3 h5 text-success">
                                        {{ number_format($pkg->price) }} VNĐ
                                    </div>
                                    <ul class="list-unstyled mb-3">
                                        <li><strong>Thời hạn:</strong> {{ $pkg->duration_days }} ngày</li>
                                    </ul>
                                    <ul class="list-unstyled mb-3">
                                        <li><strong>Số lượt đăng:</strong> {{ $pkg->post_limit }}</li>
                                    </ul>
                                    @if ($pkg->description)
                                        <p class="flex-grow-1">{{ $pkg->description }}</p>
                                    @endif

                                    @if ($currentSubscription && $currentSubscription->id === $pkg->id)
                                        <button class="btn btn-success mt-auto w-100" disabled>Đang sử dụng</button>
                                    @else
                                        <!-- CHỖ NÀY: phải gọi đúng tên route 'employer.packages.purchase' -->
                                        <a href="{{ route('employer.packages.purchase', $pkg->id) }}"
                                            class="btn btn-primary mt-auto w-100">
                                            Mua ngay
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@endsection
