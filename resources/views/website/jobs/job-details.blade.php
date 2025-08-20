@extends('website.layouts.master')

@section('content')
    {{-- ======= Compact Banner (no extra top gap) ======= --}}
    <div class="page-header-area d-flex justify-content-center align-items-center text-center"
        style="height:72px;max-height:72px;padding:0!important;background:url('{{ asset('client/assets/img/banner/15.png') }}') center/cover no-repeat;"
        role="img" aria-label="Job details banner">
        <span class="visually-hidden">Job details</span>
    </div>

    {{-- ======= Flash messages ======= --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- ======= Job header card ======= --}}
    <section class="">
        <div class="container">
            <div class="row g-3 g-lg-4">
                <div class="col-12">
                    <div class="border rounded-3 p-3 p-md-4 shadow-sm bg-white">
                        <div class="row align-items-center g-3 g-md-4">
                            {{-- Company logo --}}
                            <div class="col-12 col-sm-auto text-center mt-4">
                                @php
                                    $company = optional($job->company);
                                    $logo = $company->logo_url ?: asset('client/assets/img/companies/default-logo.webp');
                                    $companyName = $company->name ?: 'Công ty';
                                @endphp
                                <img src="{{ $logo }}" alt="Logo {{ $companyName }}"
                                    class="img-fluid rounded border bg-light"
                                    style="width: 110px; height: 110px; object-fit: contain;" loading="lazy"
                                    decoding="async"
                                    onerror="this.onerror=null;this.src='{{ asset('client/assets/img/companies/default-logo.webp') }}';">
                            </div>

                            {{-- Title + meta --}}
                            <div class="col-12 col-sm">
                                <h1 class="h5 h4-md mb-1 text-wrap">{{ $job->title }}</h1>
                                <p class="h6 text-muted mb-2">{{ $companyName }}</p>
                                <ul class="list-unstyled d-flex flex-wrap gap-3 small mb-0">
                                    <li class="d-inline-flex align-items-center">
                                        <i class="icofont-location-pin me-1"></i>
                                        <span>{{ optional($job->location)->name ?? 'N/A' }}</span>
                                    </li>
                                    <li class="d-inline-flex align-items-center">
                                        <i class="icofont-phone me-1"></i>
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
                                    @if ($hasMin && $hasMax)
                                        <div class="fw-bold mb-1 text-primary">
                                            {{ number_format($job->salary_min, 0, '.', ',') }} -
                                            {{ number_format($job->salary_max, 0, '.', ',') }}
                                            <span class="text-uppercase">{{ $currency }}</span>
                                            <small class="text-muted">/tháng</small>
                                        </div>
                                    @elseif ($hasMin)
                                        <div class="fw-bold mb-1 text-primary">
                                            Từ {{ number_format($job->salary_min, 0, '.', ',') }} <span
                                                class="text-uppercase">{{ $currency }}</span>
                                        </div>
                                    @elseif ($hasMax)
                                        <div class="fw-bold mb-1 text-primary">
                                            Lên đến {{ number_format($job->salary_max, 0, '.', ',') }} <span
                                                class="text-uppercase">{{ $currency }}</span>
                                        </div>
                                    @else
                                        <div class="text-muted mb-1">Lương thỏa thuận</div>
                                    @endif

                                    @if ($job->jobType)
                                        <div class="text-muted small mb-2 d-flex align-items-center justify-content-sm-end">
                                            <i class="icofont-briefcase me-1"></i>
                                            <span>{{ $job->jobType->name }}</span>
                                        </div>
                                    @endif

                                    <div class="d-none d-sm-block">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#applyModal">
                                            Ứng tuyển ngay
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- row --}}
                    </div>
                </div>
            </div>

            {{-- ======= Body ======= --}}
            <div class="row g-3 g-lg-4 mt-1 mt-md-3">
                <div class="col-lg-7 col-xl-8 order-2 order-lg-1">
                    <div class="job-details-content">
                        <section class="mb-4">
                            <h2 class="h5 mb-3">Mô tả công việc</h2>
                            <div class="job-content lh-lg">{!! $job->description !!}</div>
                        </section>
                        <section class="mb-4">
                            <h2 class="h5 mb-3">Yêu cầu</h2>
                            <div class="job-content lh-lg">{!! $job->requirements !!}</div>
                        </section>
                        <section class="mb-4">
                            <h2 class="h5 mb-3">Phúc lợi</h2>
                            <div>
                                @php
                                    $benefits = [];
                                    if (!empty($job->benefits)) {
                                        if (is_array($job->benefits))
                                            $benefits = $job->benefits;
                                        else
                                            $benefits = preg_split('/\r\n|\n|\r|,/', $job->benefits);
                                    }
                                    $benefits = array_values(array_filter(array_map('trim', $benefits), fn($b) => $b !== ''));
                                @endphp
                                @if (!empty($benefits))
                                    <ul class="list-unstyled m-0">
                                        @foreach ($benefits as $benefit)
                                            <li class="d-flex align-items-start gap-2 py-1"><i
                                                    class="icofont-check text-success mt-1"></i><span>{{ $benefit }}</span></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">Không có thông tin phúc lợi.</p>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-5 col-xl-4 order-1 order-lg-2">
                    <aside>
                        <div class="border rounded-3 shadow-sm bg-white">
                            <div class="border-bottom px-3 px-md-4 py-3">
                                <h3 class="h6 mb-0">Thông tin</h3>
                            </div>
                            <div class="p-3 p-md-4">
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted small">Loại công việc</td>
                                                <td class="text-end">{{ optional($job->jobType)->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Mức lương</td>
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
                                                <td class="text-muted small">Địa chỉ</td>
                                                <td class="text-end">{{ $job->address ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Chính sách làm việc từ xa</td>
                                                <td class="text-end">{{ optional($job->remotePolicy)->name ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Cấp bậc</td>
                                                <td class="text-end">{{ optional($job->level)->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Kinh nghiệm</td>
                                                <td class="text-end">{{ optional($job->experience)->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Ngôn ngữ</td>
                                                <td class="text-end">{{ optional($job->language)->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Ngày đăng</td>
                                                <td class="text-end">
                                                    {{ $job->created_at ? $job->created_at->format('d/m/Y') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted small">Hạn nộp hồ sơ</td>
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
    @include('website.jobs.partials.related-jobs', ['relatedJobs' => $relatedJobs])
    </main>

    {{-- Sticky mobile apply bar --}}
    <div class="position-sticky bottom-0 start-0 end-0 d-sm-none p-3 bg-body border-top shadow-sm" style="z-index:1030;">
        <div class="container">
            <button type="button" class="btn btn-success w-100 py-2" data-bs-toggle="modal" data-bs-target="#applyModal"
                aria-label="Ứng tuyển ngay">Ứng tuyển ngay</button>
        </div>
    </div>

    {{-- Apply modal --}}
    @include('website.jobs.partials.apply-modal', ['job' => $job])
@endsection

@push('styles')
    <style>
        :root {
            --header-h: 64px;
        }

        /* If your site header is fixed, we compute real height via JS; this fallback ensures no overlap */
        body.has-fixed-header main.main-content {
            padding-top: calc(var(--header-h) + 8px);
        }

        /* Remove unexpected large gaps near top */
        .page-header-area {
            margin: 0 !important;
        }

        .main-content {
            margin-top: 0 !important;
        }

        /* Improve readability of rich HTML from CMS */
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

        /* Card rounding on small screens */
        @media (max-width: 575.98px) {
            .border.rounded-3 {
                border-radius: 1rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-fix top spacing if header is fixed
        (function () {
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