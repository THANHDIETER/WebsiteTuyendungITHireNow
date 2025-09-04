@extends('website.layouts.master')
@push('styles')
<style>
    :root {
        --header-h: 64px;
    }

    body.has-fixed-header main.main-content {
        padding-top: calc(var(--header-h) + 8px);
    }

    .page-header-area {
        margin: 0 !important;
    }

    .main-content {
        margin-top: 0 !important;
    }

    .job-content p {
        margin-bottom: .75rem;
    }

    .job-content ul {
        padding-left: 1.25rem;
        margin-bottom: .75rem;
    }

    .job-content li+li {
        margin-top: .25rem;
    }

    @media (max-width: 575.98px) {
        .border.rounded-3 {
            border-radius: 1rem !important;
        }
    }
</style>
@endpush
@section('content')
@include('website.layouts.particals.img-header')
<section class="">
    <div class="container" style="margin-top: -20px;">
        <div class="row g-3 g-lg-4">
            <div class="col-12">
                <div class="border rounded-3 p-3 p-md-4 shadow-sm bg-white">
                    <div class="row align-items-center g-3 g-md-4">
                        {{-- Company logo --}}
                        <div class="col-12 col-sm-auto text-center mt-4 mb-4">
                            @php $company = optional($job->company); @endphp
                            <img src="{{ asset('storage/' . $company->logo_url) }}" alt="{{ $company->name ?? ''}}"
                                class="img-fluid rounded border bg-light"
                                style="width: 110px; height: 110px; object-fit: contain;" loading="lazy">
                        </div>

                        {{-- Title + meta --}}
                        <div class="col-12 col-sm">
                            <h1 class="h5 h4-md mb-1 text-wrap">{{ $job->title }}</h1>
                            <p class="h6 text-muted mb-2">
                                <i class="bi bi-buildings me-1 text-primary"></i>
                                {{ $company->name ?? ''}}
                            </p>
                            <ul class="list-unstyled d-flex flex-wrap gap-3 small mb-0">
                                <li class="d-inline-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                    <span>{{ $job->location->name ?? 'N/A' }}</span>
                                </li>
                                <li class="d-inline-flex align-items-center">
                                    <i class="bi bi-telephone-fill me-1 text-success"></i>
                                    <span>{{ $company->phone ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Salary + type + CTA --}}
                        <div class="col-12 col-sm-auto text-sm-end">
                            @php
                            $hasMin = !is_null($job->salary_min);
                            $hasMax = !is_null($job->salary_max);
                            $currency = $job->currency ?: 'VND';
                            @endphp

                            <div class="d-flex flex-column align-items-stretch align-items-sm-end">
                                {{-- Salary --}}
                                @if ($hasMin && $hasMax)
                                <div class="fw-bold mb-1 text-primary">
                                    <i class="bi bi-cash-stack me-1"></i>
                                    {{ number_format($job->salary_min, 0, '.', ',') }} -
                                    {{ number_format($job->salary_max, 0, '.', ',') }}
                                    <span class="text-uppercase">{{ $currency }}</span>
                                    <small class="text-muted">/tháng</small>
                                </div>
                                @elseif ($hasMin)
                                <div class="fw-bold mb-1 text-primary">
                                    <i class="bi bi-cash me-1"></i>
                                    Từ {{ number_format($job->salary_min, 0, '.', ',') }}
                                    <span class="text-uppercase">{{ $currency }}</span>
                                </div>
                                @elseif ($hasMax)
                                <div class="fw-bold mb-1 text-primary">
                                    <i class="bi bi-cash me-1"></i>
                                    Lên đến {{ number_format($job->salary_max, 0, '.', ',') }}
                                    <span class="text-uppercase">{{ $currency }}</span>
                                </div>
                                @else
                                <div class="text-muted mb-1">
                                    <i class="bi bi-wallet2 me-1"></i> Lương thỏa thuận
                                </div>
                                @endif

                                {{-- Job type --}}
                                @if ($job->jobType)
                                <div class="text-muted small mb-2 d-flex align-items-center justify-content-sm-end">
                                    <i class="bi bi-briefcase-fill me-1"></i>
                                    <span>{{ $job->jobType->name }}</span>
                                </div>
                                @endif

                                {{-- CTA --}}
                                @auth
                                @if (auth()->user()->role === 'job_seeker')
                                <div class="d-none d-sm-block">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#applyModal">
                                        <i class="bi bi-send-check me-1"></i> Ứng tuyển ngay
                                    </button>
                                </div>
                                @endif
                                @endauth

                                @guest
                                <div class="d-none d-sm-block">
                                    <a href="{{ route('showLoginForm') }}" class="btn btn-warning">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập để ứng tuyển
                                    </a>
                                </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======= Body ======= --}}
        <div class="row g-3 g-lg-4 mt-md-3">
            <div class="col-lg-7 col-xl-8 order-2 order-lg-1">
                <div class="job-details-content" >
                    <section class="mb-4">
                        <h2 class="h5 mb-3"><i class="bi bi-card-text me-2 text-primary"></i>Mô tả công việc</h2>
                        <div class="job-content lh-lg">{!! $job->description !!}</div>
                    </section>
                    <section class="mb-4">
                        <h2 class="h5 mb-3"><i class="bi bi-list-check me-2 text-success"></i>Yêu cầu</h2>
                        <div class="job-content lh-lg">{!! $job->requirements !!}</div>
                    </section>
                    <section class="mb-4">
                        <h2 class="h5 mb-3"><i class="bi bi-gift-fill me-2 text-danger"></i>Phúc lợi</h2>
                        <div class="job-content lh-lg">{!! $job->benefits !!}</div>
                    </section>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-5 col-xl-4 order-1 order-lg-2">
                <aside>
                    <div class="border rounded-3 shadow-sm bg-white">
                        <div class="border-bottom px-3 px-md-4 py-3">
                            <h3 class="h6 mb-0"><i class="bi bi-info-circle me-1 text-primary"></i>Thông tin</h3>
                        </div>
                        <div class="p-3 p-md-4">
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-briefcase-fill me-1"></i> Loại
                                                công việc</td>
                                            <td class="text-end">{{ optional($job->jobType)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-cash-stack me-1"></i> Mức lương
                                            </td>
                                            <td class="text-end">
                                                @if ($hasMin && $hasMax)
                                                {{ number_format($job->salary_min) }} -
                                                {{ number_format($job->salary_max) }} {{ $currency }}
                                                @elseif ($hasMin)
                                                Từ {{ number_format($job->salary_min) }} {{ $currency }}
                                                @elseif ($hasMax)
                                                Lên đến {{ number_format($job->salary_max) }} {{ $currency }}
                                                @else
                                                Thỏa thuận
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-geo-alt-fill me-1"></i> Địa chỉ
                                            </td>
                                            <td class="text-end">{{ $job->address ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-laptop me-1"></i> Chính sách
                                                làm việc từ xa</td>
                                            <td class="text-end">{{ optional($job->remotePolicy)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-bar-chart-steps me-1"></i> Cấp
                                                bậc</td>
                                            <td class="text-end">{{ optional($job->level)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-person-workspace me-1"></i>
                                                Kinh nghiệm</td>
                                            <td class="text-end">{{ optional($job->experience)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-translate me-1"></i> Ngôn ngữ
                                            </td>
                                            <td class="text-end">{{ optional($job->language)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-calendar-date me-1"></i> Ngày
                                                đăng</td>
                                            <td class="text-end">
                                                {{ $job->created_at ? $job->created_at->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small"><i class="bi bi-calendar-event me-1"></i> Hạn
                                                nộp hồ sơ</td>
                                            <td class="text-end">
                                                {{ $job->deadline ? $job->deadline->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>


{{-- Related jobs --}}
@include('website.jobs.partials.job_details.related-jobs')
</main>

{{-- Sticky mobile apply bar --}}
<div class="position-sticky bottom-0 start-0 end-0 d-sm-none p-3 bg-body border-top shadow-sm" style="z-index:1030;">
    <div class="container">
        <button type="button" class="btn btn-success w-100 py-2" data-bs-toggle="modal" data-bs-target="#applyModal"
            aria-label="Ứng tuyển ngay">Ứng tuyển ngay</button>
    </div>
</div>

{{-- Apply modal --}}
@include('website.jobs.partials.job_details.apply-modal', ['job' => $job])
@endsection

@push('scripts')
<script>
    // Auto-fix top spacing if header is fixed
    (function() {
        const header = document.querySelector('#siteHeader, .navbar.fixed-top, header.fixed-top');
        const main = document.getElementById('jobDetailsMain');
        if (!main) return;
        let h = 0;
        if (header) {
            const rect = header.getBoundingClientRect();
            h = Math.max(rect.height, header.offsetHeight || 0);
            document.documentElement.style.setProperty('--header-h', h + 'px');
            document.body.classList.add('has-fixed-header');
        } else {
            document.body.classList.remove('has-fixed-header');
        }
        // Recompute on resize for responsive headers
        window.addEventListener('resize', () => {
            if (!header) return;
            const rect2 = header.getBoundingClientRect();
            const nh = Math.max(rect2.height, header.offsetHeight || 0);
            if (Math.abs(nh - h) > 1) {
                h = nh;
                document.documentElement.style.setProperty('--header-h', h + 'px');
            }
        });
    })();
</script>
@endpush