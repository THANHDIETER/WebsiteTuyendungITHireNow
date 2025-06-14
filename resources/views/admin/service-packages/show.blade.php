
<div class="container py-4 max-w-2xl">
    <h1 class="h4 mb-4">Chi tiết Gói Dịch Vụ {{ $service_package->id }}</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 200px">Tên gói</th>
                        <td>{{ $service_package->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Giá</th>
                        <td>{{ number_format($service_package->price) }} VND</td>
                    </tr>
                    <tr>
                        <th scope="row">Số ngày sử dụng</th>
                        <td>{{ $service_package->duration_days }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Số bài đăng</th>
                        <td>{{ $service_package->post_limit }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Mô tả</th>
                        <td>{{ $service_package->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Trạng thái</th>
                        <td>
                            <span class="badge {{ $service_package->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $service_package->is_active ? 'Hoạt động' : 'Ẩn' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Ngày tạo</th>
                        <td>{{ $service_package->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Cập nhật lần cuối</th>
                        <td>{{ $service_package->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
