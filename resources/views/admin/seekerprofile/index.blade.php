@extends('admin.layouts.default')

@section('content')
<div class="container-fluid py-4">
    <h2 class="h4 mb-4">Danh sách ứng tuyển</h2>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ứng viên</th>
                        <th>Email</th>
                        <th>Công ty</th>
                        <th>Vị trí ứng tuyển</th>
                        <th>CV</th>
                        <th>Thư xin việc</th>
                        <th>Ngày ứng tuyển</th>
                        <th>Trạng thái</th>
                        <th>Shortlist</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{ $app->id }}</td>
                            <td>{{ $app->user?->name ?? '-' }}</td>
                            <td>{{ $app->user?->email ?? '-' }}</td>
                            <td>{{ $app->company?->name ?? '-' }}</td>
                            <td>{{ $app->job?->title ?? '-' }}</td>
                            <td>
                                @if($app->cv_url)
                                    <a href="{{ asset('storage/' . ltrim($app->cv_url, '/admin/')) }}" target="_blank">Xem CV</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ Str::limit($app->cover_letter, 20) }}</td>
                            <td>{{ $app->applied_at?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $app->status }}</td>
                            <td>{!! $app->is_shortlisted ? '<span class="badge bg-success">✔</span>' : '-' !!}</td>
                            <td>{{ $app->note }}</td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm btn-view" data-id="{{ $app->id }}" data-cv="{{ asset('storage/' . ltrim($app->cv_url, '/admin/')) }}" data-cover="{{ $app->cover_letter }}" data-status="{{ $app->status }}" data-note="{{ $app->note }}" data-user="{{ $app->user?->name }}" data-email="{{ $app->user?->email }}" data-job="{{ $app->job?->title }}" data-company="{{ $app->company?->name }}" data-applied="{{ $app->applied_at?->format('d/m/Y') }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-3">Không có ứng viên nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($applications->hasPages())
        <div class="row mt-4 align-items-center">
            <div class="col-md-6 small text-muted">
                Hiển thị <strong>{{ $applications->firstItem() }}</strong> đến <strong>{{ $applications->lastItem() }}</strong>
                trong tổng số <strong>{{ $applications->total() }}</strong> kết quả
            </div>
            <div class="col-md-6">
                <nav class="d-flex justify-content-md-end justify-content-center">
                    {{ $applications->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    @endif
</div>

<!-- Modal chi tiết ứng viên -->
<div class="modal fade" id="cvDetailModal" tabindex="-1" aria-labelledby="cvDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cvDetailModalLabel">Chi tiết ứng viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>Ứng viên:</strong> <span id="cvUser"></span></li>
                    <li class="list-group-item"><strong>Email:</strong> <span id="cvEmail"></span></li>
                    <li class="list-group-item"><strong>Công ty:</strong> <span id="cvCompany"></span></li>
                    <li class="list-group-item"><strong>Vị trí ứng tuyển:</strong> <span id="cvJob"></span></li>
                    <li class="list-group-item"><strong>Ngày ứng tuyển:</strong> <span id="cvApplied"></span></li>
                    <li class="list-group-item"><strong>Trạng thái:</strong> <span id="cvStatus"></span></li>
                    <li class="list-group-item"><strong>Shortlist:</strong> <span id="cvShortlist"></span></li>
                    <li class="list-group-item"><strong>Ghi chú:</strong> <span id="cvNote"></span></li>
                    <li class="list-group-item"><strong>CV:</strong> <a id="cvLink" href="#" target="_blank">Xem CV</a></li>
                    <li class="list-group-item"><strong>Thư xin việc:</strong> <span id="cvCover"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-view').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('cvUser').textContent = btn.dataset.user || '-';
            document.getElementById('cvEmail').textContent = btn.dataset.email || '-';
            document.getElementById('cvCompany').textContent = btn.dataset.company || '-';
            document.getElementById('cvJob').textContent = btn.dataset.job || '-';
            document.getElementById('cvApplied').textContent = btn.dataset.applied || '-';
            document.getElementById('cvStatus').textContent = btn.dataset.status || '-';
            document.getElementById('cvShortlist').textContent = btn.closest('tr').querySelector('td:nth-child(10)').innerHTML;
            document.getElementById('cvNote').textContent = btn.dataset.note || '-';
            document.getElementById('cvLink').href = btn.dataset.cv || '#';
            document.getElementById('cvLink').textContent = btn.dataset.cv ? 'Xem CV' : 'Không có';
            document.getElementById('cvCover').textContent = btn.dataset.cover || '-';
            var modal = new bootstrap.Modal(document.getElementById('cvDetailModal'));
            modal.show();
        });
    });
});
</script>
@endpush
@endsection
