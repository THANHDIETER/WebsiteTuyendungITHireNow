@extends('website.layouts.master')

@section('title', 'Phản hồi phỏng vấn')

@section('content')
<main class="main-content py-4">
    <div class="container" style="max-width: 720px;" class="mx-auto px-3">

        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h4 class="fw-bold text-primary mb-1">
                    📩 Phản hồi thư mời phỏng vấn
                </h4>
                <p class="text-muted small">Vui lòng xác nhận bạn có tham gia buổi phỏng vấn không.</p>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="alert alert-success rounded-pill text-center small fw-semibold py-2 mb-3">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger rounded-pill text-center small fw-semibold py-2 mb-3">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <div class="card shadow-sm rounded-3 border-0 p-3" style="font-size: 0.9rem;">
            <form method="POST" action="{{ route('job_seeker.interviews.respond', $interview->id) }}">
                @csrf

                <!-- Response options -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Bạn có đồng ý tham gia buổi phỏng vấn không?</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="response" id="accept" value="accepted" required>
                        <label class="form-check-label" for="accept">✅ Tôi đồng ý tham gia</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" id="decline" value="declined">
                        <label class="form-check-label" for="decline">❌ Tôi xin từ chối</label>
                    </div>
                </div>

                <!-- Note -->
                <div class="mb-3">
                    <label for="note" class="form-label fw-semibold">Ghi chú <small class="text-muted">(Không bắt buộc)</small></label>
                    <textarea name="note" id="note" class="form-control rounded-2" rows="3" placeholder="Gửi lời nhắn nếu bạn muốn..."></textarea>
                </div>

                <!-- Submit button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill fw-semibold">
                        📬 Gửi phản hồi
                    </button>
                </div>
            </form>
        </div>

        <!-- Back link -->
        <div class="text-center mt-3">
            <a href="{{ route('job_seeker.notifications.index') }}" class="text-muted small text-decoration-none">
                ← Quay lại trang thông báo
            </a>
        </div>

    </div>
</main>

<style>
    .card:hover {
        background-color: #f9f9f9;
        transform: scale(1.002);
        transition: all 0.2s ease;
    }
</style>
@endsection
