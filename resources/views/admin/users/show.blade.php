<div class="container">
    {{-- 👤 Thông tin cá nhân --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">👤 Thông tin cá nhân</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Email:</strong> {{ $user->email }}</div>
            <div class="col-md-6"><strong>Họ tên:</strong> {{ $user->name ?? '—' }}</div>
            <div class="col-md-6"><strong>Số điện thoại:</strong> {{ $user->phone_number ?? '—' }}</div>
            <div class="col-md-6"><strong>Vai trò:</strong> {!! $user->role_badge !!}</div>
        </div>
    </div>

    {{-- ⚙️ Trạng thái tài khoản --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">⚙️ Trạng thái tài khoản</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Trạng thái:</strong> {!! $user->status_badge !!}</div>
            <div class="col-md-6">
                <strong>Bị block?</strong>
                {!! $user->is_blocked
                    ? '<span class="badge bg-danger">Có</span>'
                    : '<span class="badge bg-success">Không</span>' !!}
            </div>
        </div>
    </div>

    {{-- 🔗 Mạng giới thiệu --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">🔗 Mạng giới thiệu</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Mã giới thiệu:</strong> {{ $user->referral_code ?? '—' }}</div>
            <div class="col-md-6"><strong>Người giới thiệu:</strong> {{ $user->referred_by ?? '—' }}</div>
        </div>
    </div>

    {{-- 📅 Hệ thống & nhật ký --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">📅 Hệ thống & nhật ký</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <strong>Email xác thực lúc:</strong>
                {{ optional($user->email_verified_at)->format('d/m/Y H:i') ?? '—' }}
            </div>
            <div class="col-md-6">
                <strong>Đăng nhập gần nhất:</strong>
                {{ optional($user->last_login_at)->format('d/m/Y H:i') ?? '—' }}
            </div>
            <div class="col-md-6"><strong>IP gần nhất:</strong> {{ $user->ip_address ?? '—' }}</div>
            <div class="col-md-6"><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
            @if ($user->deleted_at)
                <div class="col-md-6 text-danger">
                    <strong>Đã xoá lúc:</strong> {{ $user->deleted_at->format('d/m/Y H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
