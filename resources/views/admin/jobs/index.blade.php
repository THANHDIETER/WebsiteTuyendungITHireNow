@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid py-4 mb-2">
        <h2 class="h4 mb-4">Tin tuyển dụng chờ duyệt</h2>

        {{-- Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tìm theo ID</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nhập ID tin tuyển dụng">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Danh mục</label>
                        <select name="category" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i> Lọc kết quả
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Công ty</th>
                            <th>Danh mục</th>
                            <th>Hình thức</th>
                            <th>Mức lương</th>
                            <th>Hạn nộp</th>
                            <th>Nổi bật</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse ($jobs as $job)
                            <tr data-id="{{ $job->id }}">
                                <td>{{ $job->id }}</td>
                                <td>{{ Str::limit($job->title, 10) }}</td>
                                <td>{{ Str::limit($job->company->name ?? '-', 10) }}</td>
                                <td>
                                    {{ $job->categories->isNotEmpty()
                                        ? Str::limit($job->categories->pluck('name')->join(', '), 10)
                                        : '-' }}
                                </td>
                                <td>{{ $job->jobType?->name ?? '-' }}</td>
                                <td>{{ $job->salary_range }}</td>
                                <td>{{ optional($job->deadline)?->format('d/m/Y') ?? '-' }}</td>
                                <td>{!! $job->featured_badge !!}</td>
                                <td class="job-status">{!! $job->status_badge !!}</td>
                                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                                <td class="text-center align-middle action-cell">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        {{-- Xem chi tiết --}}
                                        <button type="button" class="btn btn-secondary btn-sm btn-view" data-id="{{ $job->id }}" title="Xem chi tiết">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>

                                        {{-- Duyệt / Từ chối --}}
                                        @if ($job->status === 'pending')
                                            <button type="button" class="btn btn-success btn-sm btn-approve" data-id="{{ $job->id }}" title="Duyệt">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-reject" data-id="{{ $job->id }}" title="Từ chối">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                        @endif

                                        {{-- Xoá nếu chưa đóng hoặc đã đăng --}}
                                        @if (!in_array($job->status, ['closed', 'published']))
                                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline delete-form" data-id="{{ $job->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-dark btn-sm btn-delete" title="Xoá">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Khôi phục nếu vừa cập nhật gần đây --}}
                                        @if (in_array($job->status, ['published', 'closed']) && $job->updated_at->diffInMinutes(now()) <= 5)
                                            <button type="button" class="btn btn-warning btn-sm revert-job" data-url="{{ route('admin.jobs.revert', $job->id) }}" title="Khôi phục về chờ duyệt">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                       @empty
                            <tr>
                                <td colspan="11" class="text-muted py-4">Không có tin tuyển dụng nào phù hợp.</td>
                            </tr>
                       @endforelse
                    </tbody>
                </table>
            </div>
        </div>



        {{-- Pagination --}}
        @if ($jobs->hasPages())
            <div class="row mt-4 align-items-center">
                <div class="col-md-6 small text-muted">
                    Hiển thị <strong>{{ $jobs->firstItem() }}</strong> đến <strong>{{ $jobs->lastItem() }}</strong> trong tổng
                    số <strong>{{ $jobs->total() }}</strong> kết quả
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
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = '{{ csrf_token() }}';
            let isFetchingJobDetail = false;

            // ✅ Hàm dựng lại nút theo statusHtml
            function renderActionButtons(jobId, statusHtml) {
                const isPublished = statusHtml.includes('Đã đăng');
                const isRejected = statusHtml.includes('Từ chối');
                const isPending = statusHtml.includes('Chờ duyệt') || (!isPublished && !isRejected);

                let html = `<div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">`;

                // 👁 Xem chi tiết: luôn có
                html += `
                                        <button class="btn btn-secondary btn-sm btn-view" data-id="${jobId}" title="Xem chi tiết">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    `;

                if (isPublished) {
                    const revertUrl = `/admin/jobs/${jobId}/revert`;
                    html += `
                                            <button type="button" class="btn btn-warning btn-sm revert-job"
                                                data-url="${revertUrl}" title="Khôi phục về chờ duyệt">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        `;
                }

                if (isRejected) {
                    const deleteRoute = `{{ route('admin.jobs.destroy', ':id') }}`.replace(':id', jobId);
                    html += `
                                            <form action="${deleteRoute}" method="POST" class="d-inline delete-form" data-id="${jobId}">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-dark btn-sm btn-delete" title="Xoá">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        `;
                }

                if (isPending) {
                    // ✅ Hiện đầy đủ cả 3 nút khi pending
                    html += `
                                            <button type="button" class="btn btn-success btn-sm btn-approve"
                                                data-id="${jobId}" title="Duyệt">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-reject"
                                                data-id="${jobId}" title="Từ chối">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                        `;

                    const deleteRoute = `{{ route('admin.jobs.destroy', ':id') }}`.replace(':id', jobId);
                    html += `
                                            <form action="${deleteRoute}" method="POST" class="d-inline delete-form" data-id="${jobId}">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-dark btn-sm btn-delete" title="Xoá">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        `;
                }

                html += `</div>`;
                return html;
            }

            // 👁 Xem chi tiết
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
                    .then(async (response) => {
                        if (!response.ok) {
                            const contentType = response.headers.get("Content-Type") || "";
                            if (contentType.includes("application/json")) {
                                const json = await response.json();
                                throw new Error(json.message || 'Lỗi không xác định');
                            } else {
                                throw new Error('Lỗi tải chi tiết');
                            }
                        }
                        return response.text();
                    })
                    .then(html => {
                        contentEl.innerHTML = html;
                        setTimeout(() => {
                            modalEl.removeAttribute('inert');
                            modal.show();
                            isFetchingJobDetail = false;
                        }, 50);
                    })
                    .catch((err) => {
                        const errorMessage = err.message?.trim();

                        showAlertModal({
                            title: 'Lỗi',
                            message: errorMessage || 'Không thể tải dữ liệu chi tiết.'
                        });

                        if (errorMessage === 'Tin tuyển dụng không tồn tại.') {
                            const row = document.querySelector(`tr[data-id="${jobId}"]`);
                            if (row) row.remove();
                        }

                        isFetchingJobDetail = false;
                    });

            });

            // 🗑 Xoá (không reload)
            document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;

    e.preventDefault();
    const form = btn.closest('form');
    const row = btn.closest('tr'); // ✅ Thêm dòng này
    const id = form.dataset.id;
    const action = form.getAttribute('action');

    showAlertModal({
        title: `Xoá tin tuyển dụng #${id}?`,
        message: 'Hành động này không thể hoàn tác.',
        onConfirm: () => {
            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
                .then(async (res) => {
                    if (res.status === 204) {
                        return { success: true, message: 'Tin đã được xoá.' };
                    }
                    const data = await res.json();
                    return data;
                })
                .then(res => {
                    showAlertModal({
                        type: 'alert',
                        title: res.success ? 'Đã xoá' : 'Lỗi',
                        message: res.message || (res.success ? 'Tin đã được xoá thành công.' : 'Xoá thất bại.')
                    });

                    if (res.success || res.message === 'Tin tuyển dụng không tồn tại.') {
                        if (row) row.remove();
                    }
                })
                .catch((err) => {
                    console.error('Fetch error:', err); // để debug
                    showAlertModal({
                        type: 'alert',
                        title: 'Lỗi',
                        message: 'Không thể kết nối đến máy chủ.'
                    });
                });
        }
    });
});



            // ✅ Duyệt / Từ chối
            function handleAction(selector, action, fallbackStatusHtml) {
                document.addEventListener('click', function (e) {
                    const btn = e.target.closest(selector);
                    if (!btn) return;

                    const jobId = btn.dataset.id;

                    showAlertModal({
                        title: action === 'approve' ? 'Duyệt tin tuyển dụng?' : 'Từ chối tin?',
                        message: action === 'approve'
                            ? 'Tin sẽ được đăng công khai.'
                            : 'Tin sẽ bị từ chối và không hiển thị.',
                        onConfirm: () => {
                            fetch(`/admin/jobs/${jobId}/${action}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(res => {
                                    const row = document.querySelector(`tr[data-id="${jobId}"]`);
                                    if (!row || !res.status_html) return;

                                    row.querySelector('.job-status').innerHTML = res.status_html;
                                    row.querySelector('.action-cell').innerHTML = renderActionButtons(jobId, res.status_html);

                                    showAlertModal({
                                        type: 'alert',
                                        title: res.success ? 'Thành công' : 'Thất bại',
                                        message: res.message || 'Có lỗi xảy ra.'
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

            // 🔁 Khôi phục về pending (không reload)
            $(document).on('click', '.revert-job', function () {
                const url = $(this).data('url');

                showAlertModal({
                    title: 'Khôi phục về trạng thái chờ duyệt?',
                    message: 'Tin sẽ quay lại trạng thái pending.',
                    onConfirm: () => {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: { _token: csrfToken },
                            success: function (res) {
                                const jobId = url.split('/').slice(-2, -1)[0];
                                const row = document.querySelector(`tr[data-id="${jobId}"]`);
                                if (!row || !res.status_html) return;

                                row.querySelector('.job-status').innerHTML = res.status_html;
                                row.querySelector('.action-cell').innerHTML = renderActionButtons(jobId, res.status_html);

                                showAlertModal({
                                    type: 'alert',
                                    title: res.success ? 'Thành công' : 'Lỗi',
                                    message: res.message
                                });
                            },
                            error: function (xhr) {
                                let res;
                                try { res = xhr.responseJSON; } catch (_) { res = null; }

                                const jobId = url.split('/').slice(-2, -1)[0];
                                const row = document.querySelector(`tr[data-id="${jobId}"]`);

                                if (res?.status_html && row) {
                                    row.querySelector('.job-status').innerHTML = res.status_html;
                                    row.querySelector('.action-cell').innerHTML = renderActionButtons(jobId, res.status_html);
                                }

                                showAlertModal({
                                    type: 'alert',
                                    title: 'Lỗi',
                                    message: res?.message || 'Không thể kết nối đến máy chủ.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush