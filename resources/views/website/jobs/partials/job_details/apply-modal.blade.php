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
                <div id="applyAlert"></div>

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

                    {{-- CV section --}}
                    <div class="mb-3">
                        <label class="form-label">CV <span class="text-danger">*</span></label>

                        @if($cvs->count())
                            <div class="d-flex gap-4 align-items-center mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_select" value="select">
                                    <label class="form-check-label" for="cv_choice_select">
                                        Chọn CV đã upload
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_upload" value="upload">
                                    <label class="form-check-label" for="cv_choice_upload">
                                        Upload CV mới
                                    </label>
                                </div>
                            </div>

                            <div id="cv_select_wrap" class="mb-2 d-none">
                                <select class="form-select" id="cv_select" name="cv_select">
                                    <option value="">-- Chọn CV --</option>
                                    @foreach($cvs as $cv)
                                        <option value="{{ $cv->id }}">
                                            {{ $cv->title ?? $cv->original_name ?? basename($cv->file_path) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="cv_upload_wrap" class="mb-2 d-none">
                                <input type="file" name="cv_file" id="cv_file" class="form-control" accept="application/pdf">
                                <small class="text-muted">Chỉ nhận file PDF, tối đa 2MB</small>
                            </div>
                        @else
                            {{-- Nếu chưa có CV thì chỉ cho upload, không hiển thị radio --}}
                            <input type="hidden" name="cv_choice" value="upload">
                            <div id="cv_upload_wrap" class="mb-2">
                                <input type="file" name="cv_file" id="cv_file" class="form-control" accept="application/pdf">
                                <small class="text-muted">Chỉ nhận file PDF, tối đa 2MB</small>
                            </div>
                        @endif
                    </div>

                    <div class="mb-2">
                        <label for="cover_letter" class="form-label">Thư giới thiệu <small
                                class="text-muted">(Không bắt buộc)</small></label>
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
    const cvSelectWrap = document.getElementById('cv_select_wrap');
    const cvUploadWrap = document.getElementById('cv_upload_wrap');
    const cvSelect = document.getElementById('cv_select');
    const cvFile = document.getElementById('cv_file');

    // Chọn radio
    document.querySelectorAll('input[name="cv_choice"]').forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'select') {
                if (cvSelectWrap) cvSelectWrap.classList.remove('d-none');
                if (cvUploadWrap) cvUploadWrap.classList.add('d-none');
                if (cvFile) cvFile.value = '';
            } else if (this.value === 'upload') {
                if (cvUploadWrap) cvUploadWrap.classList.remove('d-none');
                if (cvSelectWrap) cvSelectWrap.classList.add('d-none');
                // ❌ Không reset cvSelect để giữ lại lựa chọn cũ
            }
        });
    });

    if (applyForm) {
        applyForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const choice = document.querySelector('input[name="cv_choice"]:checked') || document.querySelector('input[name="cv_choice"][type="hidden"]');

            if (!choice) {
                applyAlert.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>Bạn phải chọn 1 trong 2: CV đã upload hoặc upload CV mới.</div>
                    </div>`;
                return;
            }

            if (choice.value === 'select') {
                if (!cvSelect.value) {
                    applyAlert.innerHTML = `
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>Vui lòng chọn CV đã upload.</div>
                        </div>`;
                    return;
                }
            }

            if (choice.value === 'upload') {
                if (!cvFile.files.length) {
                    applyAlert.innerHTML = `
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>Bạn phải upload file CV.</div>
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
                        applyAlert.innerHTML = `<div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại.</div>`;
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
                    if (cvSelectWrap) cvSelectWrap.classList.add('d-none');
                    if (cvUploadWrap) cvUploadWrap.classList.add('d-none');

                    setTimeout(() => {
                        const modalInstance = bootstrap.Modal.getInstance(applyModal);
                        modalInstance.hide();
                    }, 2000);
                }
            })
            .catch(err => console.error(err));
        });

        if (applyModal) {
            applyModal.addEventListener('hidden.bs.modal', function () {
                applyForm.reset();
                applyAlert.innerHTML = '';
                applyLoading.classList.add('d-none');
                if (cvSelectWrap) cvSelectWrap.classList.add('d-none');
                if (cvUploadWrap) cvUploadWrap.classList.add('d-none');
            });
        }
    }
});
</script>
@endpush
