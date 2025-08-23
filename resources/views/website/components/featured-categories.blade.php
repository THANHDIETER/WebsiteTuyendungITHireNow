@props([
    /** @var \Illuminate\Support\Collection|\App\Models\Category[] $categories */
    'categories' => collect(),
])

<section class="job-category-area py-5 position-relative overflow-hidden">
    <div class="container" data-aos="fade-up">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-primary mb-2">Ngành nghề nổi bật</h2>
                <p class="text-muted mb-0">Khám phá các lĩnh vực đang được tuyển dụng nhiều nhất</p>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            @forelse($categories as $category)
                @php
                    $src = null;
                    if (!empty($category->icon_url)) {
                        $src = \Illuminate\Support\Str::startsWith($category->icon_url, ['http://','https://'])
                            ? $category->icon_url
                            : asset('storage/' . ltrim($category->icon_url, '/'));
                    }
                @endphp

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="category-card p-4 bg-white rounded-4 shadow-sm h-100 position-relative text-center">
                        <div class="mb-3 d-flex justify-content-center">
                            @if($src)
                                <img src="{{ $src }}" alt="{{ $category->name }}"
                                     class="rounded-circle object-fit-cover" style="width:64px;height:64px;">
                            @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                      style="width:64px;height:64px;background:rgba(33,150,243,.08);">
                                    <i class="bi bi-briefcase-fill fs-3 text-primary"></i>
                                </span>
                            @endif
                        </div>

                        <h6 class="fw-semibold mb-1 text-truncate">
                            <a href="{{ route('jobs.index', ['category' => $category->id]) }}"
                               class="stretched-link text-decoration-none text-dark">
                                {{ $category->name }}
                            </a>
                        </h6>
                        <div class="text-muted small">({{ number_format($category->jobs_count) }} việc làm)</div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center mb-0">Chưa có ngành nghề nào được thêm.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@once
@push('styles')
<style>
    .category-card{transition:transform .18s ease,box-shadow .18s ease}
    .category-card:hover{transform:translateY(-4px);box-shadow:0 12px 24px rgba(33,150,243,.12)}
    @media (prefers-color-scheme: dark){
        .category-card{background:#111;border:1px solid rgba(255,255,255,.06)}
    }
</style>
@endpush
@endonce
