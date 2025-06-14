@extends('employer.layouts.default')

@section('title', 'Gói đã mua')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách gói dịch vụ đã mua</h2>

    @if ($subscriptions->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Gói</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Giới hạn tin</th>
                    <th>Đã dùng</th>
                    <th>CV View</th>
                    <th>Gói hỗ trợ</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $sub)
                    <tr>
                        <td>{{ $sub->employerPackage->name ?? '-' }}</td>
                        <td>{{ $sub->start_date }}</td>
                        <td>{{ $sub->end_date }}</td>
                        <td>{{ $sub->post_limit }}</td>
                        <td>{{ $sub->post_limit - $sub->remaining_posts }}</td>
                        <td>{{ $sub->cv_views_used }}/{{ $sub->cv_view_limit }}</td>
                        <td>{{ ucfirst($sub->support_level) }}</td>
                        <td>{{ number_format($sub->price, 0, ',', '.') }}đ</td>
                        <td>
                            @if ($sub->is_active)
                                <span class="badge bg-success">Đang hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Không hoạt động</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('employer.subscriptions.show', $sub->id) }}" class="btn btn-sm btn-info">Chi tiết</a>

                            @if ($sub->is_active)
                                <a href="{{ route('employer.subscriptions.renew', $sub->id) }}" class="btn btn-sm btn-warning">Gia hạn</a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa mua gói dịch vụ nào.</p>
    @endif
</div>
@endsection
