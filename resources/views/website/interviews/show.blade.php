@extends('website.layouts.master')

@section('content')
<main class="main-content">

    <!--== Section Header ==-->
    <section class="page-header bg-light py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success text-center fw-bold">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger text-center fw-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="section-title text-center">
                <h2 class="title">Phản hồi thư mời phỏng vấn</h2>
                <p class="desc">Hãy xác nhận bạn có tham gia buổi phỏng vấn không</p>
            </div>
        </div>
    </section>

    <!--== Section Form ==-->
    <section class="job-apply-area py-5">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <form method="POST" action="{{ route('job_seeker.interviews.respond', $interview->id) }}">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Bạn có đồng ý tham gia buổi phỏng vấn không?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="response" id="accept" value="accepted" required>
                                    <label class="form-check-label" for="accept">
                                        ✅ Tôi đồng ý tham gia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="response" id="decline" value="declined">
                                    <label class="form-check-label" for="decline">
                                        ❌ Tôi xin từ chối
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="note" class="form-label fw-semibold">Ghi chú <small class="text-muted">(Không bắt buộc)</small></label>
                                <textarea name="note" id="note" class="form-control rounded-3" rows="4" placeholder="Bạn muốn gửi lời nhắn gì thêm không?"></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill">
                                    Gửi phản hồi
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-4">
                        {{-- <a href="{{ route('job_seeker.dashboard') }}" class="text-decoration-underline">← Quay lại trang quản lý</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
