<section class="recent-job-area bg-light">
    <div class="container" data-aos="fade-up" style="margin-top: -100px;">
        {{-- Tiêu đề --}}
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3 section-title">
                    🌟 Việc làm mới nhất
                </h2>
                <p class="text-muted fs-5">
                    Cơ hội nghề nghiệp hấp dẫn được cập nhật liên tục
                </p>
            </div>
        </div>


        {{-- Danh sách job --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 ">
            @forelse($latestJobs as $job)
                <div class="col mt-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 p-2 position-relative">
                        <div class="d-flex flex-column h-100 gap-2">
                            {{-- Logo công ty --}}
                            <div class="text-center mb-2">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="d-inline-block"
                                    style="width: 60px; height: 60px;">
                                    <img src="{{ asset('storage/' . $job->company->logo_url ?? '') }}"
                                        alt="{{ $job->company?->name ?? 'Company Logo' }}" loading="lazy"
                                        class="img-fluid rounded-circle border p-1 bg-white shadow-sm"
                                        style="width:100%; height:100%; object-fit:contain;">
                                </a>
                            </div>

                            {{-- Tooltip mô tả --}}
                            @php
                                $titleTooltip = '<strong>' . e($job->title) . '</strong><br>' . \Illuminate\Support\Str::limit($job->description, 200);
                            @endphp

                            <h6 class="job-title fw-semibold mb-1 small">
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    class="d-inline-flex align-items-center gap-1 text-decoration-none text-dark"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                    title="{!! $titleTooltip !!}">
                                    <i class="bi bi-briefcase-fill text-primary small"></i>
                                    <span class="d-inline-block text-wrap ms-1" style="max-width: 100%;">
                                        {{ $job->title }}
                                    </span>
                                </a>
                            </h6>

                            {{-- Tên công ty --}}
                            <div class="text-muted small d-flex align-items-center gap-1">
                                <i class="bi bi-buildings me-1"></i>
                                {{ $job->company->name ?? 'Công ty không xác định' }}
                            </div>

                            {{-- Mức lương --}}
                            <div class="fw-semibold text-primary small d-flex align-items-center gap-1">
                                <i class="bi bi-cash-stack me-1"></i>
                                @if ($job->salary_negotiable)
                                    Thỏa thuận
                                @else
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    {{ $job->currency }}
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center small">
                            {{-- Địa chỉ --}}
                            <div class="text-muted small d-flex align-items-center gap-1">
                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                {{ $job->location->name ?? 'Không rõ địa chỉ' }}
                            </div>

                            {{-- Nút lưu job --}}
                            @php
                                $isFavorited = auth()->check() && auth()->user()->favoriteJobs->contains($job->id);
                            @endphp
                            @auth
                                @if (auth()->user()->role === 'job_seeker')
                                    <div class="mt-auto text-end">
                                        <!-- <hr class="my-2"> -->
                                        <button type="button"
                                            class="btn btn-sm rounded-circle save-job-btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-secondary' }}"
                                            data-job-id="{{ $job->id }}" title="Lưu việc làm">
                                            <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </div>
                                @endif
                            @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Không có việc làm nào được hiển thị.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- JS bật tooltip --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

{{-- CSS làm đẹp tooltip & card --}}
<style>
    .tooltip-inner {
        max-width: 260px;
        padding: 8px 10px;
        background: #fff;
        color: #333;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: left;
        font-size: 0.8rem;
    }

    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #fff !important;
    }

    .recent-job-area .card {
        transition: all 0.25s ease;
    }

    .recent-job-area .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .section-title {
        font-size: 2rem;
        background: linear-gradient(90deg, #0d6efd, #6610f2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
        position: relative;
    }

    .section-title::after {
        content: "";
        display: block;
        width: 60px;
        height: 4px;
        margin: 8px auto 0;
        border-radius: 2px;
        background: linear-gradient(90deg, #0d6efd, #6610f2);
    }
</style>