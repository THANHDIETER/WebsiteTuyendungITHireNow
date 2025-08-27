<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="applyModalLabel">Nộp đơn ứng tuyển</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data"
                    id="applyForm">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                            name="full_name" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', Auth::user()->phone_number ?? '') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Chọn CV --}}
                    <div class="mb-3">
                        <label class="form-label d-block">Chọn CV</label>

                        @if($cvs->count() > 0)
                            {{-- Radio chọn cách nộp --}}
                            <div class="d-flex gap-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_saved"
                                        value="saved" checked>
                                    <label class="form-check-label" for="cv_choice_saved">Dùng CV đã lưu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cv_choice" id="cv_choice_upload"
                                        value="upload">
                                    <label class="form-check-label" for="cv_choice_upload">Tải CV mới</label>
                                </div>
                            </div>

                            {{-- Nhóm select CV đã có --}}
                            <div id="cv_saved_group" class="mb-2">
                                <select name="cv_id" id="cv_id" class="form-select">
                                    <option value="">-- Chọn CV từ hồ sơ của bạn --</option>
                                    @foreach($cvs as $cv)
                                        <option value="{{ $cv->id }}">{{ $cv->title ?? basename($cv->file_path) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nhóm upload file (ẩn mặc định) --}}
                            <div id="cv_upload_group" class="mb-2 d-none">
                                <input type="file" name="cv_file" id="cv_file" class="form-control"
                                    accept="application/pdf">
                                <div class="form-text">Tải file PDF (tối đa 2MB).</div>
                            </div>
                        @else
                            {{-- Không có CV trong hệ thống -> bắt buộc upload --}}
                            <input type="hidden" name="cv_choice" value="upload">
                            <input type="file" name="cv_file" id="cv_file" class="form-control" accept="application/pdf"
                                required>
                            <div class="form-text">Bạn chưa có CV trong hệ thống, vui lòng upload file PDF (tối đa 2MB).
                            </div>
                        @endif

                    </div>


                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">Thư giới thiệu (không bắt buộc)</label>
                        <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter"
                            name="cover_letter" rows="4"
                            placeholder="Giới thiệu ngắn gọn về kinh nghiệm, thành tích và lý do phù hợp với vị trí này...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                            <i class="bi bi-send"></i> Gửi đơn ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div> {{-- /modal-content --}}
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Reset form khi đóng modal
        const applyModal = document.getElementById('applyModal');
        if (applyModal) {
            applyModal.addEventListener('hidden.bs.modal', function () {
                const form = document.getElementById('applyForm');
                if (form) form.reset();
            });
        }

        const savedRadio = document.getElementById('cv_choice_saved');
        const uploadRadio = document.getElementById('cv_choice_upload');
        const savedGroup = document.getElementById('cv_saved_group');
        const uploadGroup = document.getElementById('cv_upload_group');
        const cvSelect = document.getElementById('cv_id');
        const cvFile = document.getElementById('cv_file');

        function toggleCVInput() {
            if (savedRadio && savedRadio.checked) {
                // Hiện select CV đã lưu
                savedGroup.classList.remove('d-none');
                uploadGroup.classList.add('d-none');

                if (cvSelect) cvSelect.setAttribute('required', 'required');
                if (cvFile) cvFile.removeAttribute('required');
            } else if (uploadRadio && uploadRadio.checked) {
                // Hiện upload CV mới
                savedGroup.classList.add('d-none');
                uploadGroup.classList.remove('d-none');

                if (cvSelect) {
                    cvSelect.removeAttribute('required');
                    cvSelect.value = '';
                }
                if (cvFile) cvFile.setAttribute('required', 'required');
            }
        }

        if (savedRadio) savedRadio.addEventListener('change', toggleCVInput);
        if (uploadRadio) uploadRadio.addEventListener('change', toggleCVInput);
        toggleCVInput(); // chạy lần đầu

        // Giới hạn file 2MB
        if (cvFile) {
            cvFile.addEventListener('change', function () {
                const f = this.files?.[0];
                if (f && f.size > 2 * 1024 * 1024) {
                    alert('File quá lớn (tối đa 2MB). Vui lòng chọn file khác.');
                    this.value = '';
                }
            });
        }

        // Swipe support cho carousel trên mobile
        const carouselEl = document.getElementById('relatedJobsCarousel');
        if (carouselEl) {
            let startX = 0;
            carouselEl.addEventListener('touchstart', (e) => {
                startX = e.changedTouches[0].screenX;
            });
            carouselEl.addEventListener('touchend', (e) => {
                const endX = e.changedTouches[0].screenX;
                if (Math.abs(endX - startX) > 50) {
                    const dir = endX < startX ? 'next' : 'prev';
                    const c = bootstrap.Carousel.getOrCreateInstance(carouselEl);
                    c[dir]();
                }
            });
        }
    });
</script>