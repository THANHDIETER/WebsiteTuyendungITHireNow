@props([
    /** @var \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Support\Collection $jobs */
    'jobs' => collect(),
])

<section class="latest-jobs-area py-5">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">Việc làm mới nhất</h2>
                <p class="text-muted mb-0">Cập nhật liên tục những cơ hội vừa đăng</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @forelse($jobs as $job)
            <article class="job-card card border-0 shadow-sm mb-3">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex gap-3 align-items-start">
                        {{-- Logo công ty --}}
                        <a href="{{ route('companies.show', $job->company_id) }}" class="flex-shrink-0">
                            <img src="{{ $job->thumbnail ? ( \Illuminate\Support\Str::startsWith($job->thumbnail, ['http://','https://']) ? $job->thumbnail : asset('storage/'.ltrim($job->thumbnail,'/')) ) : asset('images/company-placeholder.png') }}"
                                 alt="Logo công ty" class="rounded-3 object-fit-cover" style="width:64px;height:64px;">
                        </a>

                        <div class="flex-grow-1 min-w-0">
                            {{-- Tiêu đề & công ty --}}
                            <h5 class="mb-1 text-truncate">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="text-decoration-none">
                                    {{ $job->title }}
                                </a>
                            </h5>
                            <div class="text-muted small mb-2">
                                <a href="{{ route('companies.show', $job->company_id) }}" class="text-muted text-decoration-none">
                                    {{ $job->company->name ?? 'Công ty' }}
                                </a>
                                <span class="mx-1">•</span>
                                <i class="bi bi-geo-alt"></i>
                                {{ $job->location->name ?? $job->address ?? 'Không rõ địa điểm' }}
                                @if($job->remote_policy_id)
                                    <span class="ms-1 badge bg-light text-dark border">
                                        {{ $job->remote_policy->name ?? 'Remote' }}
                                    </span>
                                @endif
                            </div>

                            {{-- Thẻ nhanh --}}
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @if($job->job_type_id)
                                    <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">
                                        <i class="bi bi-briefcase me-1"></i>{{ $job->jobType->name ?? 'Toàn thời gian' }}
                                    </span>
                                @endif
                                @if($job->level_id)
                                    <span class="badge rounded-pill bg-success-subtle text-success-emphasis">
                                        <i class="bi bi-stars me-1"></i>{{ $job->level->name ?? 'Junior' }}
                                    </span>
                                @endif
                                @if($job->experience_id)
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis">
                                        <i class="bi bi-rocket-takeoff me-1"></i>{{ $job->experience->name ?? '0-1 năm' }}
                                    </span>
                                @endif
                                @if($job->language_id)
                                    <span class="badge rounded-pill bg-info-subtle text-info-emphasis">
                                        <i class="bi bi-translate me-1"></i>{{ $job->language->name ?? '—' }}
                                    </span>
                                @endif
                                @if($job->is_featured)
                                    <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis">
                                        <i class="bi bi-fire me-1"></i>Nổi bật
                                    </span>
                                @endif
                            </div>

                            {{-- Mô tả ngắn --}}
                            @if(!empty($job->description))
                                <p class="text-muted mb-2 d-none d-md-block">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($job->description), 140) }}
                                </p>
                            @endif

                            {{-- Lương + Hạn nộp --}}
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div class="fw-semibold">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    @php
                                        $salary = null;
                                        if (($job->salary_display ?? null) === 'hidden') {
                                            $salary = 'Thoả thuận';
                                        } elseif ($job->salary_min || $job->salary_max) {
                                            $min = $job->salary_min ? number_format($job->salary_min) : null;
                                            $max = $job->salary_max ? number_format($job->salary_max) : null;
                                            $currency = $job->currency ?? 'VND';
                                            $salary = trim(($min ?: '') . ($max ? ' - ' . $max : '')) . ' ' . $currency;
                                        }
                                    @endphp
                                    {{ $salary ?? 'Không công khai' }}
                                </div>

                                @if($job->deadline)
                                    <div class="text-muted small">
                                        <i class="bi bi-hourglass-split me-1"></i>
                                        Hạn: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                                    </div>
                                @endif

                                <div class="ms-auto">
                                    <a href="{{ $job->apply_url ?? route('jobs.show', $job->slug) }}"
                                       class="btn btn-sm btn-primary">
                                        Ứng tuyển
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="alert alert-info">Chưa có việc làm mới.</div>
        @endforelse

        {{-- Phân trang nếu có --}}
        @if(method_exists($jobs, 'links'))
            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</section>

@once
@push('styles')
<style>
    .job-card{transition:transform .18s ease,box-shadow .18s ease;border-radius:1rem}
    .job-card:hover{transform:translateY(-3px);box-shadow:0 14px 28px rgba(16,24,40,.12)}
</style>
@endpush
@endonce
