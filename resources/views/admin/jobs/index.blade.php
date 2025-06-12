@extends('admin.layouts.default')

@section('content')


    <div class="container-fluid py-4">
        <h2 class="h4 mb-4">Tin tuyển dụng chờ duyệt</h2>

        {{-- Filter --}}
        <form method="GET" class="row g-3 mb-4 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tìm theo ID</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Tìm theo ID">
            </div>
            <div class="col-md-4">
                <label class="form-label">Danh mục</label>
                <select name="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Công ty</th>
                            <th>Danh mục</th>
                            <th>Hình thức</th>
                            <th>Mức lương</th>
                            <th>Hạn nộp</th>
                            <th>Nổi bật</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $job)
                            <tr data-id="{{ $job->id }}">
                                <td>{{ $job->id }}</td>
                                <td>{{ Str::limit($job->title, 10) }}</td>
                                <td>{{ Str::limit($job->company->name, 10) }}</td>
                                <td>{{ Str::limit($job->category->name, 10) }}</td>
                                <td>{{ $job->job_type_label }}</td>
                                <td class="text-nowrap">{{ $job->salary_range }}</td>
                                <td>{{ optional($job->deadline)?->format('d/m/Y') ?? '-' }}</td>
                                <td>{!! $job->featured_badge !!}</td>
                                <td class="job-status">{!! $job->status_badge !!}</td>
                                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                                <td class="text-center align-middle action-cell">
                                    <div class="d-flex justify-content-center gap-1 flex-nowrap">
                                        @if ($job->status === 'pending')
                                            <button type="button"
                                                class="btn btn-success btn-sm btn-approve d-flex align-items-center justify-content-center"
                                                data-id="{{ $job->id }}" title="Duyệt" style="width: 36px; height: 36px;">
                                                <i class="bi bi-check-lg fs-5"></i>
                                            </button>
                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-reject d-flex align-items-center justify-content-center"
                                                data-id="{{ $job->id }}" title="Từ chối" style="width: 36px; height: 36px;">
                                                <i class="bi bi-x-lg fs-5"></i>
                                            </button>
                                        @endif

                                        <button
                                            class="btn btn-secondary btn-sm btn-view d-flex align-items-center justify-content-center"
                                            data-id="{{ $job->id }}" title="Xem chi tiết" style="width: 36px; height: 36px;">
                                            <i class="bi bi-eye fs-5"></i>
                                        </button>

                                        @if (!in_array($job->status, ['closed', 'published']))
                                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST"
                                                class="d-inline delete-form" data-id="{{ $job->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-dark btn-sm btn-delete d-flex align-items-center justify-content-center"
                                                    title="Xoá" style="width: 36px; height: 36px;">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-3">Không có tin tuyển dụng nào phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($jobs->hasPages())
            <div class="row mt-4 align-items-center">
                <div class="col-md-6 small text-muted">
                    Hiển thị <strong>{{ $jobs->firstItem() }}</strong> đến <strong>{{ $jobs->lastItem() }}</strong>
                    trong tổng số <strong>{{ $jobs->total() }}</strong> kết quả
                </div>
                <div class="col-md-6">
                    <nav class="d-flex justify-content-md-end justify-content-center">
                        {{ $jobs->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal chi tiết --}}
    <div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết tin tuyển dụng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="jobDetailContent">
                    <p class="text-center text-muted">Đang tải...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = '{{ csrf_token() }}';
        let isFetchingJobDetail = false;

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-view');
            if (!btn || isFetchingJobDetail) return;

            isFetchingJobDetail = true;

            const jobId = btn.dataset.id;
            const modalEl = document.getElementById('jobDetailModal');
            const contentEl = document.getElementById('jobDetailContent');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            contentEl.innerHTML = '<p class="text-center text-muted">Đang tải...</p>';

            fetch(`/admin/jobs/${jobId}`)
                .then(response => response.text())
                .then(html => {
                    contentEl.innerHTML = html;
                    setTimeout(() => {
                        modalEl.removeAttribute('inert');
                        modal.show();
                        modalEl.addEventListener('shown.bs.modal', () => {
                            const closeBtn = modalEl.querySelector('.btn-close');
                            if (closeBtn) closeBtn.focus();
                        }, { once: true });
                        isFetchingJobDetail = false;
                    }, 50);
                })
                .catch(() => {
                    contentEl.innerHTML = '<p class="text-danger text-center">Không thể tải dữ liệu.</p>';
                    isFetchingJobDetail = false;
                });

            modalEl.addEventListener('hidden.bs.modal', function handler() {
                modalEl.setAttribute('inert', 'true');
                if (modalEl.contains(document.activeElement)) document.activeElement.blur();
                setTimeout(() => btn.focus(), 10);
                modalEl.removeEventListener('hidden.bs.modal', handler);
            });
        });

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            e.preventDefault();
            const form = btn.closest('form');
            const id = form.dataset.id;

            showAlertModal({
                title: 'Bạn có chắc muốn xoá tin #' + id + '?',
                message: 'Hành động này sẽ không thể khôi phục.',
                onConfirm: () => form.submit()
            });
        });

        function handleAction(selector, action, fallbackStatusHtml) {
            document.addEventListener('click', function (e) {
                const btn = e.target.closest(selector);
                if (!btn) return;

                const jobId = btn.dataset.id;

                showAlertModal({
                    title: action === 'approve' ? 'Bạn muốn duyệt tin?' : 'Bạn muốn từ chối tin?',
                    message: action === 'approve'
                        ? 'Tin sẽ được đăng công khai.'
                        : 'Tin sẽ bị từ chối và không hiển thị.',
                    onConfirm: () => {
                        fetch(`/admin/jobs/${jobId}/${action}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(res => res.json().then(data => ({ status: res.status, body: data })))
                            .then(({ status, body }) => {
                                const row = document.querySelector(`tr[data-id="${jobId}"]`);
                                if (!row) return;

                                row.querySelector('.job-status').innerHTML = body.status_html || fallbackStatusHtml;
                                row.querySelector('.action-cell').innerHTML = `
                                <div class="d-flex justify-content-center gap-1 flex-nowrap">
                                    <button class="btn btn-secondary btn-sm btn-view d-flex align-items-center justify-content-center"
                                            data-id="${jobId}" title="Xem chi tiết" style="width: 36px; height: 36px;">
                                        <i class="bi bi-eye fs-5"></i>
                                    </button>
                                </div>
                            `;

                                showAlertModal({
                                    type: 'alert',
                                    title: (status === 200 && body.success) ? 'Thành công' : 'Thông báo',
                                    message: body.message || 'Có lỗi xảy ra.'
                                });
                            })
                            .catch(() => {
                                showAlertModal({
                                    type: 'alert',
                                    title: 'Lỗi mạng',
                                    message: 'Không thể kết nối đến máy chủ.'
                                });
                            });
                    }
                });
            });
        }


        handleAction('.btn-approve', 'approve', '<span class="badge bg-success">Đã đăng</span>');
        handleAction('.btn-reject', 'reject', '<span class="badge bg-danger">Từ chối</span>');
    });
</script>