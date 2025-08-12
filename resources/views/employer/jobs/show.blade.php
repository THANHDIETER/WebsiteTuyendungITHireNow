@extends('employer.layouts.default')

@section('title', $job->meta_title ?? $job->title)
@section('meta_description', strip_tags(html_entity_decode($job->meta_description ?? Str::limit($job->description,
    150))))
@section('meta_keywords', $job->keyword ?? '')

@section('content')
    <main class="main-content">
        <div class="container py-5">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-end mb-4 gap-2">
                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                </a>
                @if ($job->status !== 'closed')
                    <form action="{{ route('employer.jobs.close', $job->id) }}" method="POST"
                        onsubmit="return confirm('Ngừng tuyển dụng tin này?');">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i> Ngừng tuyển dụng
                        </button>
                    </form>
                @endif
            </div>

            {{-- Job Header --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4">
                        <img src="{{ $job->company->logo_url ? asset($job->company->logo_url) : asset('assets/img/default-logo.png') }}"
                            alt="{{ $job->company->name }}" class="rounded border"
                            style="width:80px; height:80px; object-fit:cover;">
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">{{ $job->title }}</h3>
                        <div class="small text-muted">
                            <i class="bi bi-building me-1"></i> {{ $job->company->name }} |
                            <i class="bi bi-geo-alt me-1"></i> {{ $job->address ?? 'Không rõ địa chỉ' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Job Summary --}}
            <div class="row mb-4 g-3">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i> Thông tin cơ
                                bản</h5>
                            <p><strong>Ngành nghề:</strong>
                                {{ $job->category?->name ?? 'Không xác định' }}
                            </p>
                            <p><strong>Cấp bậc:</strong> {{ $job->level?->name ?? '-' }}</p>
                            <p><strong>Kinh nghiệm:</strong> {{ $job->experience?->name ?? '-' }}</p>
                            <p><strong>Hình thức:</strong> {{ $job->jobType?->name ?? '-' }}</p>
                            <p><strong>Hạn nộp hồ sơ:</strong>
                                {{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Không giới hạn' }}</p>
                            <p><strong>Lượt xem:</strong> {{ $job->views }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3"><i class="bi bi-cash-coin me-2 text-success"></i> Thông tin lương
                            </h5>
                            <p><strong>Lương:</strong>
                                @if ($job->salary_negotiable)
                                    Lương thương lượng
                                @elseif ($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    {{ $job->currency }}
                                @elseif ($job->salary_min)
                                    Từ {{ number_format($job->salary_min) }} {{ $job->currency }}
                                @elseif ($job->salary_max)
                                    Up to {{ number_format($job->salary_max) }} {{ $job->currency }}
                                @else
                                    Thỏa thuận
                                @endif
                            </p>
                            <p><strong>Loại tiền tệ:</strong> {{ $job->currency ?? 'VND' }}</p>
                            <p><strong>Chính sách làm việc:</strong> {{ $job->remotePolicy?->name ?? '-' }}</p>
                            <p><strong>Ngôn ngữ sử dụng:</strong> {{ $job->language?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-file-earmark-text me-2 text-info"></i> Mô tả công việc</h5>
                    <div>{!! html_entity_decode($job->description ?: '<em>Không có mô tả.</em>') !!}</div>
                </div>
            </div>

            {{-- Requirements --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-check-all me-2 text-warning"></i> Yêu cầu</h5>
                    <div>{!! html_entity_decode($job->requirements ?: '<em>Không có yêu cầu.</em>') !!}</div>
                </div>
            </div>

            {{-- Benefits --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-gift me-2 text-success"></i> Quyền lợi</h5>
                    @php
                        $benefitsArray = $job->benefits ? json_decode($job->benefits, true) : null;
                    @endphp

                    <div>
                        @if (is_array($benefitsArray))
                            <ul>
                                @foreach ($benefitsArray as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Không rõ quyền lợi.</em>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Skills --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-tools me-2 text-secondary"></i> Kỹ năng yêu cầu</h5>
                    @if ($job->skills && $job->skills->count())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($job->skills as $skill)
                                <span class="badge bg-primary px-3 py-2">{{ $skill->skill_name }}</span>
                            @endforeach
                        </div>
                    @else
                        <em>Không có kỹ năng yêu cầu</em>
                    @endif
                </div>
            </div>

            {{-- SEO Section --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3 text-muted"><i class="bi bi-search me-2"></i> Thông tin SEO</h5>
                    <p><strong>Meta Title:</strong> {{ $job->meta_title ?? '-' }}</p>
                    <p><strong>Meta Description:</strong> {!! html_entity_decode($job->meta_description ?? '-') !!}</p>
                    <p><strong>Keyword:</strong> {{ $job->keyword ?? '-' }}</p>
                    <p><strong>Hiển thị tìm kiếm:</strong>
                        {!! $job->search_index ? '<span class="text-success">Có</span>' : '<span class="text-danger">Không</span>' !!}
                    </p>
                </div>
            </div>

        </div>
    </main>
@endsection
