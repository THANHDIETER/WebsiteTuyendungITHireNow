@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📢 Gửi Thông Báo Hệ Thống</h4>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.notifications.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label">Loại thông báo</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="Ví dụ: new_job" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Người nhận</label>
                            <select class="form-select" name="user_id" required>
                                <option value="all">Tất cả người dùng</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung</label>
                            <textarea class="form-control" name="message" id="message" rows="4" placeholder="Nhập nội dung thông báo..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label">Liên kết (tuỳ chọn)</label>
                            <input type="url" class="form-control" name="link_url" id="link_url" placeholder="VD: /jobs/123">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                🚀 Gửi Thông Báo
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-muted text-end">
                    Hệ thống quản trị IT Hire Now
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
