<div class="container mt-5">
    <h3 class="mb-4 text-primary">👤 Chi tiết người dùng #{{ $user->id }}</h3>

    <div class="card shadow rounded">
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Họ tên:</div>
                <div class="col-md-8">{{ $user->name ?? '— (chưa có)' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Email:</div>
                <div class="col-md-8">{{ $user->email }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Số điện thoại:</div>
                <div class="col-md-8">{{ $user->phone_number ?? '— (chưa có)' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Vai trò:</div>
                <div class="col-md-8">{{ $user->role_label }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Trạng thái:</div>
                <div class="col-md-8">{{ $user->status_label }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Đã bị chặn?</div>
                <div class="col-md-8">
                    {!! $user->is_blocked
                        ? '<span class="text-danger fw-bold">Có</span>'
                        : '<span class="text-success">Không</span>' !!}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Ngày tạo:</div>
                <div class="col-md-8">{{ $user->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="row">
                <div class="col-md-4 fw-bold">IP gần nhất:</div>
                <div class="col-md-8">{{ $user->ip_address ?? '(Không xác định)' }}</div>
            </div>
        </div>
    </div>
</div>
