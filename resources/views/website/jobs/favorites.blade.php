@extends('website.layouts.master1')

@section('content')
<div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
     data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
     style="max-height: 80px; height: 80px; padding: 0 !important;">
    &nbsp;
</div>

<div class="container py-4">
    <h3 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i> Việc làm yêu thích</h3>

    @if($favorites->count())
        <div class="list-group shadow-sm rounded">
            @foreach($favorites as $job)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <a href="javascript:void(0)" 
                               class="text-decoration-none text-dark fw-semibold view-job" 
                               data-id="{{ $job->id }}">
                                {{ $job->title }}
                            </a>
                        </h5>
                        <small class="text-muted">
                            <i class="bi bi-building me-1"></i>{{ $job->company->name ?? 'Công ty' }}
                        </small>
                    </div>

                    <div class="d-flex">
                        <!-- Nút xem chi tiết -->
                        <button type="button" 
                                class="btn btn-sm btn-primary me-2 view-job" 
                                data-id="{{ $job->id }}">
                            <i class="bi bi-eye"></i> Xem
                        </button>

                        <!-- Nút bỏ yêu thích -->
                        <form action="{{ route('favorites.destroy', $job->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Bỏ yêu thích">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="alert alert-info shadow-sm">
            <i class="bi bi-info-circle"></i> Bạn chưa có công việc yêu thích nào.
        </div>
    @endif
</div>

<!-- Modal xem chi tiết -->
<div class="modal fade" id="jobDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-briefcase-fill me-2"></i> Chi tiết công việc</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 id="jobTitle" class="fw-bold"></h4>
                <p class="mb-1"><i class="bi bi-building me-2"></i><strong>Công ty:</strong> <span id="jobCompany"></span></p>
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><strong>Địa điểm:</strong> <span id="jobLocation"></span></p>
                <p class="mb-1"><i class="bi bi-cash-coin me-2"></i><strong>Mức lương:</strong> <span id="jobSalary"></span></p>
                <p class="mb-1"><i class="bi bi-clock-history me-2"></i><strong>Ngày đăng:</strong> <span id="jobDate"></span></p>
                <p class="mb-3"><i class="bi bi-person-badge me-2"></i><strong>Cấp bậc:</strong> <span id="jobLevel"></span></p>

                <hr>
                <div class="mb-3">
                    <h6 class="fw-semibold text-primary"><i class="bi bi-card-text me-1"></i> Mô tả công việc</h6>
                    <div id="jobDescription" class="text-muted"></div>
                </div>
                <div class="mb-3">
                    <h6 class="fw-semibold text-primary"><i class="bi bi-list-check me-1"></i> Yêu cầu</h6>
                    <div id="jobRequirements" class="text-muted"></div>
                </div>
                <div class="mb-3">
                    <h6 class="fw-semibold text-primary"><i class="bi bi-gift me-1"></i> Quyền lợi</h6>
                    <div id="jobBenefits" class="text-muted"></div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="applyForm" action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send-check"></i> Ứng tuyển ngay
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = new bootstrap.Modal(document.getElementById('jobDetailModal'));

    document.querySelectorAll(".view-job").forEach(btn => {
        btn.addEventListener("click", function() {
            let jobId = this.dataset.id;

            fetch(`/favorites/job/${jobId}`)
                .then(res => res.json())
                .then(data => {
                    // Fill data
                    document.getElementById("jobTitle").innerText = data.title;
                    document.getElementById("jobCompany").innerText = data.company;
                    document.getElementById("jobLocation").innerText = data.location;
                    document.getElementById("jobSalary").innerText = data.salary;
                    document.getElementById("jobDate").innerText = data.created_at;
                    document.getElementById("jobLevel").innerText = data.level;

                    document.getElementById("jobDescription").innerHTML = data.description || '<em>Chưa có mô tả</em>';
                    document.getElementById("jobRequirements").innerHTML = data.requirements || '<em>Chưa có yêu cầu</em>';
                    document.getElementById("jobBenefits").innerHTML = data.benefits || '<em>Chưa có quyền lợi</em>';

                    // Gán action cho form apply
                    document.getElementById("applyForm").action = `/jobs/${jobId}/apply`;

                    modal.show();
                });
        });
    });
});
</script>
@endpush
