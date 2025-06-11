@extends('employer.layouts.default')

@section('content')
<div class="container">
    
    <h2 class="mb-4">Chọn gói dịch vụ</h2>

    @if($currentSubscription)
        <div class="alert alert-info">
            Gói hiện tại: <strong>{{ $currentSubscription->package->name }}</strong> (đến ngày {{ \Carbon\Carbon::parse($currentSubscription->end_date)->format('d/m/Y') }})
        </div>
    @endif

    <div class="row">
        @foreach($packages as $package)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h4 class="card-title">{{ $package->name }}</h4>
                        <p class="text-muted">{{ $package->description }}</p>
                        <ul class="list-unstyled">
                            <li><strong>Giá:</strong> {{ number_format($package->price) }} VND</li>
                            <li><strong>Thời hạn:</strong> {{ $package->duration_days }} ngày</li>
                            <li><strong>Đăng tin:</strong> {{ $package->post_limit }} tin</li>
                            <li><strong>Xem CV:</strong> {{ $package->cv_view_limit }} lượt</li>
                            <li><strong>Hỗ trợ:</strong> {{ ucfirst($package->support_level) }}</li>
                        </ul>
                        <form action="{{ route('employer.packages.subscribe', $package->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Mua gói</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
