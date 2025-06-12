<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">👤 Thông tin cơ bản</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone_number" class="form-control"
                    value="{{ old('phone_number', $user->phone_number) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label d-flex justify-content-between">
                    <span>Vai trò</span>
                    <small class="text-muted">Hiện tại: <strong>{{ $user->role_label }}</strong></small>
                </label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="employer" {{ $user->role === 'employer' ? 'selected' : '' }}>Nhà tuyển dụng</option>
                    <option value="job_seeker" {{ $user->role === 'job_seeker' ? 'selected' : '' }}>Ứng viên</option>
                </select>
            </div>

        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">⚙️ Trạng thái tài khoản</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Chưa kích hoạt</option>
                    <option value="banned" {{ $user->status === 'banned' ? 'selected' : '' }}>Đã chặn</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Bị block?</label>
                <select name="is_blocked" class="form-select">
                    <option value="0" {{ !$user->is_blocked ? 'selected' : '' }}>Không</option>
                    <option value="1" {{ $user->is_blocked ? 'selected' : '' }}>Có</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">🔗 Mạng giới thiệu</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Referral code</label>
                <input type="text" name="referral_code" class="form-control"
                    value="{{ old('referral_code', $user->referral_code) }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Referred by</label>
                <input type="text" name="referred_by" class="form-control"
                    value="{{ old('referred_by', $user->referred_by) }}" readonly>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">📅 Thông tin hệ thống</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Email xác thực lúc</label>
                <input type="text" class="form-control"
                    value="{{ optional($user->email_verified_at)->format('d/m/Y H:i') }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Lần đăng nhập gần nhất</label>
                <input type="text" class="form-control"
                    value="{{ optional($user->last_login_at)->format('d/m/Y H:i') }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">IP gần nhất</label>
                <input type="text" class="form-control" value="{{ $user->ip_address }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ngày tạo tài khoản</label>
                <input type="text" class="form-control" value="{{ optional($user->created_at)->format('d/m/Y H:i') }}"
                    readonly>
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
    </div>
</form>