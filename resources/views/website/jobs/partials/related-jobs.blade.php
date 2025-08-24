<section class="related-jobs-area py-5" style="background: #f4f7ff;">
    <div class="container position-relative">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold text-primary position-relative d-inline-block">
                    Công việc liên quan
                    <span class="d-block mx-auto mt-2"
                        style="height:3px;width:80px;background:#0d6efd;border-radius:2px;"></span>
                </h3>
            </div>
        </div>

        @if ($relatedJobs->count() > 0)

            {{-- ✅ PC: Carousel --}}
            <div id="relatedJobsCarousel" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($relatedJobs->chunk(3) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach ($chunk as $relatedJob)
                                    <div class="col-md-4">
                                        <div class="card job-card shadow-sm border-0 rounded-4 h-100">
                                            <div class="card-body p-4">
                                                {{-- Company & thumbnail --}}
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ $relatedJob->thumbnail ? asset('storage/' . $relatedJob->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                                        alt="{{ $relatedJob->title }}" class="rounded-circle border shadow-sm me-3"
                                                        width="55" height="55">
                                                    <div>
                                                        <h5 class="fw-bold mb-0">
                                                            <a href="{{ route('jobs.show', $relatedJob->slug) }}"
                                                                class="text-decoration-none text-dark hover-text-primary">
                                                                {{ Str::limit($relatedJob->title, 40) }}
                                                            </a>
                                                        </h5>
                                                        <small class="text-muted">
                                                            <i class="icofont-building-alt me-1 text-primary"></i>
                                                            {{ $relatedJob->company->name }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <ul class="list-unstyled small mb-0">
                                                    <li class="mb-1">
                                                        <i class="icofont-location-pin me-1 text-danger"></i>
                                                        <strong>Địa điểm:</strong> {{ $relatedJob->location->name ?? 'N/A' }}
                                                    </li>
                                                    <li class="mb-1">
                                                        <i class="icofont-money-bag me-1 text-success"></i>
                                                        <strong>Lương:</strong> {{ $relatedJob->salary_display }}
                                                    </li>
                                                    <li class="mb-1">
                                                        <i class="icofont-clock-time me-1 text-warning"></i>
                                                        <strong>Hình thức:</strong>
                                                        {{ ucfirst(optional($relatedJob->jobType)->name) }}
                                                    </li>
                                                    <li>
                                                        <i class="icofont-calendar me-1 text-info"></i>
                                                        <strong>Hạn ứng tuyển:</strong>
                                                        {{ optional($relatedJob->deadline)->format('d/m/Y') }}
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Nút điều hướng nằm ngoài card --}}
                @if ($relatedJobs->count() > 3)
                    <button class="carousel-control-prev custom-carousel-btn" type="button"
                        data-bs-target="#relatedJobsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-primary rounded-circle p-3 shadow-sm"
                            aria-hidden="true"></span>
                        <span class="visually-hidden">Trước</span>
                    </button>
                    <button class="carousel-control-next custom-carousel-btn" type="button"
                        data-bs-target="#relatedJobsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-primary rounded-circle p-3 shadow-sm"
                            aria-hidden="true"></span>
                        <span class="visually-hidden">Sau</span>
                    </button>
                @endif
            </div>

            {{-- ✅ Mobile: Scroll ngang --}}
            <div class="d-md-none">
                <div class="d-flex flex-nowrap overflow-auto pb-2">
                    @foreach ($relatedJobs as $relatedJob)
                        <div class="card job-card shadow-sm border-0 rounded-4 me-3 flex-shrink-0" style="width: 85%;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $relatedJob->thumbnail ? asset('storage/' . $relatedJob->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                        alt="{{ $relatedJob->title }}" class="rounded-circle border shadow-sm me-2" width="45"
                                        height="45">
                                    <div>
                                        <h6 class="fw-bold mb-0">
                                            <a href="{{ route('jobs.show', $relatedJob->slug) }}"
                                                class="text-decoration-none text-dark hover-text-primary">
                                                {{ Str::limit($relatedJob->title, 30) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $relatedJob->company->name }}</small>
                                    </div>
                                </div>

                                <ul class="list-unstyled small mb-0">
                                    <li><i class="icofont-location-pin me-1 text-danger"></i>
                                        {{ $relatedJob->location->name ?? 'N/A' }}</li>
                                    <li><i class="icofont-money-bag me-1 text-success"></i> {{ $relatedJob->salary_display }}
                                    </li>
                                    <li><i class="icofont-calendar me-1 text-info"></i>
                                        {{ optional($relatedJob->deadline)->format('d/m/Y') }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @else
            <div class="alert alert-info text-center rounded-4 shadow-sm">
                Không có công việc liên quan nào.
            </div>
        @endif
    </div>
</section>

<style>
    .job-card {
        transition: all 0.3s ease;
        background: #fff;
    }

    .job-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    }

    .hover-text-primary:hover {
        color: #0d6efd !important;
    }

    /* Nút prev/next đưa ra ngoài */
    .custom-carousel-btn {
        position: absolute;
        top: 45%;
        transform: translateY(-50%);
        z-index: 5;
    }

    .carousel-control-prev.custom-carousel-btn {
        left: -120px;
        /* đẩy ra ngoài */
    }

    .carousel-control-next.custom-carousel-btn {
        right: -120px;
    }

    /* Ẩn scrollbar xấu trên mobile */
    .d-flex.flex-nowrap::-webkit-scrollbar {
        display: none;
    }
</style>