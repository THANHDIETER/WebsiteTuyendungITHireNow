@extends('employer.layouts.default')

@section('content')
    <main class="main-content">
        <div class="container py-5">

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="bi bi-card-list me-2"></i> Danh sách công việc đã đăng
                </h2>
                <a href="{{ route('employer.jobs.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Đăng tin tuyển dụng
                </a>
            </div>

            <div class="row">
                @forelse ($jobs as $job)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border">

                            {{-- HEADER --}}
                            <div class="d-flex align-items-center p-3 border-bottom" style="min-height: 85px;">
                                <img src="{{ $job->company && $job->company->logo_url ? Storage::url($job->company->logo_url) : asset('assets/img/default-logo.png') }}"
                                    alt="{{ $job->company->name ?? 'Company' }}" class="rounded border me-3"
                                    style="width: 56px; height: 56px; object-fit: cover;">

                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-truncate">
                                        <a href="#" class="text-dark">{{ optional($job->company)->name }}</a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $job->address ?? 'Chưa cập nhật' }}
                                    </small>
                                </div>
                            </div>

                            {{-- BODY --}}
                            <div class="card-body pb-2">

                                {{-- THUMBNAIL nếu có --}}
                                @if ($job->thumbnail)
                                    <div class="mb-2 text-center">
                                        <img src="{{ asset('storage/' . $job->thumbnail) }}" alt="Thumbnail"
                                            class="img-fluid rounded border" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                @endif

                                <h4 class="fw-semibold mb-2 text-primary">
                                    <a href="{{ route('employer.jobs.show', $job->id) }}" class="text-decoration-none">
                                        {!! html_entity_decode($job->title) !!}
                                    </a>
                                    {{-- NẾU CÓ NỔI BẬT --}}

                                    @if ($job->is_featured)
                                        <span class="badge bg-danger ms-1">Nổi bật</span>
                                    @endif
                                </h4>

                                {{-- REQUIREMENTS --}}
                                <p class="mb-2 text-muted" style="min-height:40px;">
                                    {{ $job->requirements ? Str::limit(strip_tags(html_entity_decode($job->requirements)), 75) : 'Không có mô tả.' }}
                                </p>


                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @if ($job->level)
                                        <span class="badge bg-purple text-dark" style="background:#E5DBFF; color:#5f3dc4;">
                                            {{ $job->level->name }}
                                        </span>
                                    @endif
                                    {{-- EXPERIENCE --}}

                                    @if ($job->experience)
                                        <span class="badge bg-warning text-dark">
                                            {{ $job->experience->name }}
                                        </span>
                                    @endif

                                    @if ($job->categories && $job->categories->count())
                                        @foreach ($job->categories as $category)
                                            <span class="badge bg-light text-dark border">{{ $category->name }}</span>
                                        @endforeach
                                    @endif

                                </div>

                                {{-- STATUS --}}
                                <div class="mb-2">
                                    {!! $job->status_badge !!}
                                </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="card-footer d-flex justify-content-between align-items-center bg-light border-0">
                                <div>
                                    <strong class="text-success">
                                        {{ $job->salary_min ? number_format($job->salary_min) : 0 }}
                                        -
                                        {{ $job->salary_max ? number_format($job->salary_max) : 'Thương lượng' }}
                                        {{ $job->currency ?? 'VND' }}
                                    </strong>
                                    <div class="text-muted small">/tháng</div>
                                </div>
                                <a href="{{ route('employer.jobs.show', $job->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Hiện tại bạn chưa có tin tuyển dụng nào.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PHÂN TRANG --}}
            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </main>
@endsection
