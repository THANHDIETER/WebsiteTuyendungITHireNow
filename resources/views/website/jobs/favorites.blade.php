@extends('website.layouts.master')

@section('content')
<div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
     data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
     style="max-height: 80px; height: 80px; padding: 0 !important;" loading="lazy">
    &nbsp;
</div>

<div class="container py-4">
    <div class="row">
        {{-- Cột trái: Việc làm yêu thích --}}
        <div class="col-lg-8">
            <h3 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i> Việc làm yêu thích</h3>

            @if($favorites->count())
                <div id="favorites-list">
                    @foreach($favorites as $job)
                        <div class="card shadow-sm border-0 mb-3 job-item-{{ $job->id }}">
                            <div class="card-body d-flex flex-column flex-md-row align-items-start">
                                {{-- Logo công ty --}}
                                <div class="me-md-3 mb-2 mb-md-0 d-flex align-items-center justify-content-center border rounded bg-white"
                                     style="width:90px; height:90px; flex-shrink:0;">
                                    <img src="{{ $job->company->logo_url ? asset('storage/'.$job->company->logo_url) : asset('client/assets/img/default-company.png') }}" 
                                         alt="{{ $job->company->name ?? 'Công ty' }}" 
                                         class="img-fluid" style="max-height:80px; object-fit:contain;" loading="lazy">
                                </div>

                                {{-- Nội dung --}}
                                <div class="flex-grow-1 d-flex flex-column">
                                    <h5 class="mb-1">
                                        <a href="{{ route('jobs.show', $job->slug) }}" 
                                           class="text-decoration-none text-dark fw-bold">
                                           {{ $job->title }}
                                        </a>
                                    </h5>
                                    <p class="mb-1 text-muted"><i class="bi bi-building"></i> {{ $job->company->name ?? 'Công ty' }}</p>
                                    <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ $job->location->name ?? 'Địa điểm' }}</p>
                                    <p class="mb-1"><i class="bi bi-cash-coin"></i> {{ $job->salary_min }} - {{ $job->salary_max }} {{ $job->currency }}</p>

                                    {{-- Footer --}}
                                    <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                        <span class="text-muted small">
                                            <i class="bi bi-clock-history"></i> {{ $job->created_at->format('d/m/Y') }}
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('jobs.show', $job->slug) }}" 
                                               class="btn btn-sm btn-success me-2">
                                               <i class="bi bi-send-check"></i> Ứng tuyển
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger btn-remove-favorite" 
                                                    data-id="{{ $job->id }}" title="Bỏ yêu thích">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $favorites->links() }}
                </div>
            @else
                <div class="alert alert-info shadow-sm">
                    <i class="bi bi-info-circle"></i> Bạn chưa có công việc yêu thích nào.
                </div>
            @endif
        </div>

        {{-- Cột phải: Gợi ý việc làm --}}
        <div class="col-lg-4">
            @if(!empty($suggestedJobs) && count($suggestedJobs))
            <h4 class="mb-4"><i class="bi bi-lightbulb-fill text-warning me-2"></i> Gợi ý việc làm</h4>
            <div class="list-group shadow-sm">
                @foreach($suggestedJobs as $job)
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <a href="{{ route('jobs.show', $job['slug']) }}" 
                               class="fw-semibold text-dark text-decoration-none d-block">
                               {{ $job['title'] }}
                            </a>
                            <div class="small text-muted">
                                <i class="bi bi-building"></i> {{ $job['company']['name'] }}
                            </div>
                            <div class="small">
                                <i class="bi bi-geo-alt"></i> {{ $job['location'] }}
                            </div>
                            <div class="small text-success fw-semibold">
                                <i class="bi bi-cash-coin"></i> {{ $job['salary_display'] }}
                            </div>
                        </div>
                        {{-- Nút tim --}}
                        <i class="bi {{ $job['favorited'] ? 'bi-heart-fill text-danger' : 'bi-heart text-muted' }} 
                                  fs-4 btn-toggle-favorite"
                           role="button"
                           style="cursor:pointer;"
                           data-id="{{ $job['id'] }}">
                        </i>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card { transition: all 0.2s ease-in-out; }
.card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
.list-group-item { border: none; border-bottom: 1px solid #eee; }
.list-group-item:last-child { border-bottom: none; }
.btn-toggle-favorite { transition: color 0.2s ease-in-out; }
.btn-toggle-favorite:hover { color: red !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Xóa yêu thích trong favorites
    document.querySelectorAll(".btn-remove-favorite").forEach(btn => {
        btn.addEventListener("click", function() {
            let jobId = this.dataset.id;
            if(!confirm("Bạn có chắc chắn muốn bỏ yêu thích công việc này?")) return;

            fetch(`/favorites/${jobId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.querySelector(".job-item-" + jobId).remove();
                } else {
                    alert(data.message || "Có lỗi xảy ra!");
                }
            })
            .catch(() => alert("Có lỗi xảy ra khi kết nối server!"));
        });
    });

    // Toggle yêu thích trong gợi ý
    document.querySelectorAll(".btn-toggle-favorite").forEach(icon => {
        icon.addEventListener("click", function() {
            let jobId = this.dataset.id;
            fetch(`/favorites/${jobId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.favorited) {
                    this.classList.add("text-danger");
                    this.classList.replace("bi-heart", "bi-heart-fill");
                } else {
                    this.classList.remove("text-danger");
                    this.classList.replace("bi-heart-fill", "bi-heart");
                    this.classList.add("text-muted");
                }
            })
            .catch(() => alert("Có lỗi xảy ra khi kết nối server!"));
        });
    });
});
</script>
@endpush
