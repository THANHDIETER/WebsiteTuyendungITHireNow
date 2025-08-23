@push('stype')
<style></style>
@endpush
<section class="recent-job-area bg-light">
    <div class="container" data-aos="fade-up" style="margin-top: -120px;">
        {{-- Tiêu đề --}}
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-gradient mb-2">🌟 Việc làm mới nhất</h2>
                <p class="text-muted">Cơ hội nghề nghiệp hấp dẫn được cập nhật liên tục</p>
            </div>
        </div>

        {{-- Danh sách job --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="row-gap: 2rem;">
            @forelse($latestJobs as $job)
            <div class="col">
                <div class="card h-100 border-0 shadow-lg shadow-sm rounded-4 p-3 position-relative">
                    <div class="d-flex flex-column h-100 gap-2">
                        <div class="text-center mb-3">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="d-inline-block"
                                style="width: 70px; height: 70px;">
                                <img src="{{ asset('storage/'.$job->company->logo_url ?? '') }}"
                                    alt="{{ $job->company?->name ?? 'Company Logo' }}"
                                    class="img-fluid rounded-circle border p-1 bg-white shadow-sm"
                                    style="width:100%; height:100%; object-fit:contain;">
                            </a>
                        </div>

                        @php
                        $titleTooltip = $job->title . ' - ' . strip_tags($job->description);
                        $titleTooltip = \Illuminate\Support\Str::limit($titleTooltip, 200);
                        @endphp

                        <h6 class="job-title fw-semibold mb-1">
                            <a href="{{ route('jobs.show', $job->slug) }}"
                                class="d-inline-flex align-items-center gap-1 text-decoration-none text-dark"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $titleTooltip }}">
                                <i class="bi bi-briefcase-fill text-primary small"></i>
                                <span class="d-inline-block text-wrap ms-2" style="max-width: 100%;">
                                    {{ $job->title }}
                                </span>

                            </a>
                        </h6>

                        {{-- Tên công ty --}}
                        <div class="text-muted small">
                            {{ $job->company->name ?? 'Công ty không xác định' }}
                        </div>

                        {{-- Mức lương --}}
                        <div class="fw-semibold text-primary small">
                            @if ($job->salary_negotiable)
                            Thỏa thuận
                            @else
                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                            {{ $job->currency }}
                            @endif
                        </div>

                        {{-- Địa chỉ --}}
                        <div class="text-muted small">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                            {{ $job->address ?? 'Không rõ địa chỉ' }}
                        </div>
                        @php
                        $isFavorited = auth()->check() && auth()->user()->favoriteJobs->contains($job->id);
                        @endphp
                         @auth
                            @if (auth()->user()->role === 'job_seeker')
                        <div class="mt-auto text-end">
                            <hr>
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
            @empty
            <div class="col-12 text-center text-muted">Không có việc làm nào được hiển thị.</div>
            @endforelse
        </div>
    </div>
</section>