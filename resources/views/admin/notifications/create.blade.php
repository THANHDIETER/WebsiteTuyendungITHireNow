@extends('admin.layouts.default')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <h4 class="mb-0"><i class="bi bi-megaphone-fill me-2"></i> Gửi Thông Báo Hệ Thống</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.notifications.store') }}" method="POST">
                            @csrf

                            <!-- Loại thông báo -->
                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">
                                    <i class="bi bi-tag-fill me-1 text-primary"></i> Loại thông báo
                                </label>
                                <input type="text" class="form-control" id="type" name="type"
                                    placeholder="VD: new_job, system, alert..." required>
                            </div>

                            <!-- Người nhận -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-1 text-primary"></i> Người nhận
                                </label>
                                <select class="form-select" name="user_id" id="user_id" required>
                                    <option value="all">🔔 Gửi đến tất cả người dùng</option>
                                    <optgroup label="--- Người dùng cụ thể ---">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <!-- Nội dung -->
                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text-fill me-1 text-primary"></i> Nội dung thông báo
                                </label>
                                <textarea class="form-control" name="message" id="message" rows="4" placeholder="Nhập nội dung bạn muốn gửi..."
                                    required></textarea>
                            </div>

                            <!-- Link -->
                            <div class="mb-3">
                                <label for="link_url" class="form-label fw-semibold">
                                    <i class="bi bi-link-45deg me-1 text-primary"></i> Liên kết (tuỳ chọn)
                                </label>
                                <input type="url" class="form-control" name="link_url" id="link_url"
                                    placeholder="VD: https://example.com/page hoặc /jobs/123">
                            </div>

                            <!-- Nút gửi -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-send-fill me-1"></i> Gửi Thông Báo
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-muted text-end small fst-italic">
                        Hệ thống quản trị <strong>IT Hire Now</strong>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
