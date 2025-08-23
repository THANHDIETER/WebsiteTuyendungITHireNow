<section class="related-jobs-area " style="background: linear-gradient(135deg, #f0f4ff, #e8f0fe);">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="title section-title border-bottom pb-2 d-inline-block">Công việc liên quan</h3>
            </div>
        </div>
        @if ($relatedJobs->count() > 0)
        <div id="relatedJobsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($relatedJobs->chunk(2) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $relatedJob)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow rounded-4 overflow-hidden bg-white">
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <img src="{{ $relatedJob->thumbnail ? asset('storage/' . $relatedJob->thumbnail) : asset('client/assets/img/default-thumbnail.jpg') }}"
                                            alt="{{ $relatedJob->title }}" width="100" height="100"
                                            class="img-fluid rounded-start object-fit-cover m-3">
                                    </div>
                                    <div class="col">
                                        <div class="card-body">
                                            <h5 class="card-title mb-1 text-dark fw-bold">
                                                {{ $relatedJob->title }}
                                            </h5>
                                            <p class="mb-1 text-muted small fw-semibold">
                                                {{ $relatedJob->company->name }}
                                            </p>
                                            <ul class="list-unstyled small text-muted mb-0">
                                                <li><i class="icofont-location-pin me-1"></i>{{ $relatedJob->location ??
                                                    'N/A' }}
                                                </li>
                                                <li><i class="icofont-money-bag me-1"></i>{{
                                                    number_format($relatedJob->salary_min) }}
                                                    - {{ number_format($relatedJob->salary_max) }}đ
                                                </li>
                                                <li><i class="icofont-clock-time me-1"></i>{{
                                                    ucfirst($relatedJob->job_type) }}
                                                </li>
                                                <li><i class="icofont-calendar me-1"></i>Hạn nộp:
                                                    {{ optional($relatedJob->deadline)->format('d/m/Y') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @if ($relatedJobs->count() > 2)
            <button class="carousel-control-prev" type="button" data-bs-target="#relatedJobsCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#relatedJobsCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
        @else
        <div class="alert alert-info text-center">
            Không có công việc liên quan nào.
        </div>
        @endif
    </div>
</section>