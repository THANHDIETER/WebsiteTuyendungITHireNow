<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title" id="applyModalLabel">
                    <i class="bi bi-send-check me-2"></i>Nộp đơn ứng tuyển
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Đóng"></button>
            </div>

            <div class="modal-body p-3">
                <div id="applyAlert"></div> {{-- AJAX messages here --}}

                <form id="applyForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                            value="{{ old('full_name', Auth::user()->name ?? '') }}">
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', Auth::user()->email ?? '') }}">
                    </div>

                    <div class="mb-2">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', Auth::user()->phone_number ?? '') }}">
                    </div>

                    <div class="mb-2">
                        <label for="cv_file" class="form-label">Chọn CV <span class="text-muted">(PDF, tối đa
                                2MB)</span></label>
                        <input type="file" name="cv_file" id="cv_file" class="form-control" accept="application/pdf">
                    </div>

                    <div class="mb-2">
                        <label for="cover_letter" class="form-label">Thư giới thiệu <small class="text-muted">(Không bắt
                                buộc)</small></label>
                        <textarea class="form-control" id="cover_letter" name="cover_letter" rows="3"></textarea>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Đóng
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm d-none me-2" id="applyLoading"
                                role="status"></span>
                            <i class="bi bi-send"></i> Gửi đơn ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const applyForm = document.getElementById('applyForm');
            const applyAlert = document.getElementById('applyAlert');
            const applyModal = document.getElementById('applyModal');
            const applyLoading = document.getElementById('applyLoading');
            const cvFile = document.getElementById('cv_file');

            if (applyForm) {
                applyForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (!cvFile.files || !cvFile.files.length) {
                        applyAlert.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>Bạn phải tải lên file CV.</div>
                            </div>`;
                        return;
                    }

                    if (cvFile.files[0].size > 2 * 1024 * 1024) {
                        applyAlert.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>File CV quá lớn (tối đa 2MB).</div>
                            </div>`;
                        return;
                    }

                    const formData = new FormData(applyForm);
                    applyAlert.innerHTML = '';
                    applyLoading.classList.remove('d-none');

                    fetch("{{ route('jobs.apply', $job) }}", {
                        method: "POST",
                        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: formData
                    })
                        .then(async response => {
                            applyLoading.classList.add('d-none');
                            let data;
                            try {
                                data = await response.json();
                            } catch (e) {
                                applyAlert.innerHTML = `
                                <div class="alert alert-danger d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>Lỗi: Server không trả về JSON hợp lệ.</div>
                                </div>`;
                                throw new Error("Invalid JSON");
                            }

                            if (!response.ok) {
                                if (response.status === 422 && data.errors) {
                                    let errs = '<div class="alert alert-danger"><ul class="mb-0">';
                                    Object.values(data.errors).forEach(err => {
                                        errs += `<li>${err}</li>`;
                                    });
                                    errs += '</ul></div>';
                                    applyAlert.innerHTML = errs;
                                } else if (data.error) {
                                    applyAlert.innerHTML = `
                                    <div class="alert alert-danger d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <div>${data.error}</div>
                                    </div>`;
                                } else {
                                    applyAlert.innerHTML = `
                                    <div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại.</div>`;
                                }
                                throw new Error("Request failed");
                            }

                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                applyAlert.innerHTML = `
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <div>${data.success}</div>
                                </div>`;
                                applyForm.reset();

                                // ✅ Auto close modal sau 2s
                                setTimeout(() => {
                                    const modalInstance = bootstrap.Modal.getInstance(applyModal);
                                    modalInstance.hide();
                                }, 2000);
                            }
                        })
                        .catch(err => console.error(err));
                });

                // Reset form + alert khi đóng modal
                if (applyModal) {
                    applyModal.addEventListener('hidden.bs.modal', function () {
                        applyForm.reset();
                        applyAlert.innerHTML = '';
                        applyLoading.classList.add('d-none');
                    });
                }
            }
        });
    </script>
@endpush