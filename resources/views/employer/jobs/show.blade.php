@extends('employer.layouts.default')

@section('content')
<main class="main-content">
    <div class="container py-5">
        {{-- THÔNG BÁO --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $job->company->logo_url ? asset($job->company->logo_url) : asset('assets/img/default-logo.png') }}"
                                alt="{{ $job->company->name }}" class="rounded border me-3" style="width: 72px; height: 72px; object-fit: cover;">
                            <div>
                                <h3 class="mb-0 fw-bold">{{ $job->title }}</h3>
                                <div class="d-flex gap-2 mt-1">
                                    <span class="badge bg-info text-dark">{{ ucfirst($job->job_type) }}</span>
                                    <span class="badge bg-success">{{ $job->company->name }}</span>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-geo-alt"></i> {{ $job->location ?? 'Chưa cập nhật' }}
                                    </span>
                                    @if($job->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    @elseif($job->status == 'published')
                                        <span class="badge bg-success">Đã đăng</span>
                                    @elseif($job->status == 'closed')
                                        <span class="badge bg-secondary">Đã đóng</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($job->status) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- Thông tin chính --}}
                        <div class="mb-3">
                            <strong>Ngành nghề:</strong> {{ $job->category->name ?? 'Chưa có ngành nghề' }}<br>
                            <strong>Cấp bậc:</strong> {{ $job->level ?? 'Chưa rõ' }}<br>
                            <strong>Kinh nghiệm:</strong> {{ $job->experience ?? 'Chưa rõ' }}<br>
                            <strong>Hình thức:</strong> {{ ucfirst($job->job_type) }}<br>
                            <strong>Địa chỉ làm việc:</strong> {{ $job->address ?? $job->location ?? 'Chưa cập nhật' }}<br>
                            <strong>Lương:</strong>
                            <span class="fw-bold text-success">
                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency ?? 'VND' }}
                            </span> /tháng<br>
                            <strong>Hạn nộp:</strong> {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') : 'Không giới hạn' }}<br>
                            <strong>Lượt xem:</strong> {{ $job->views ?? 0 }}
                        </div>
                        <hr>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Mô tả công việc</h5>
                            <div>{!! nl2br(e($job->description)) !!}</div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Yêu cầu</h5>
                            <div>
                                @if(is_array($job->requirements))
                                    <ul>
                                        @foreach($job->requirements as $req)
                                            <li>{{ $req }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {!! nl2br(e($job->requirements)) ?: 'Không có yêu cầu cụ thể.' !!}
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Quyền lợi</h5>
                            <div>
                                @if(is_array($job->benefits))
                                    <ul>
                                        @foreach($job->benefits as $b)
                                            <li>{{ $b }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {!! nl2br(e($job->benefits)) ?: 'Không có thông tin.' !!}
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Chính sách làm việc</h5>
                            <div>{{ $job->remote_policy ?? 'Không rõ' }}</div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Ngôn ngữ sử dụng</h5>
                            <div>{{ $job->language ?? 'Không rõ' }}</div>
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">Meta SEO</h5>
                            <div>
                                <strong>Meta Title:</strong> {{ $job->meta_title ?? '-' }}<br>
                                <strong>Meta Description:</strong> {{ $job->meta_description ?? '-' }}
                            </div>
                        </div>
                        @if($job->apply_url)
                        <div class="mb-3">
                            <a href="{{ $job->apply_url }}" target="_blank" class="btn btn-primary">
                                Ứng tuyển ngay <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                        @endif
                        <div class="text-end">
                            <a href="{{ route('employer.jobs.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
