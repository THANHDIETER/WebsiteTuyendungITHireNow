
<!-- Modal -->
<div class="modal fade" id="globalAlertModal" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start p-4 border-0 shadow-lg rounded-4" style="max-width: 480px; margin: auto;">
            <div class="text-center mb-3 modal-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <h5 class="text-center fw-bold modal-title mb-2">Thông báo</h5>
            <div class="modal-body-message text-muted"></div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="button" class="btn btn-primary px-4" id="globalAlertModal-confirm-btn">Đồng ý</button>
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Huỷ</button>
            </div>
        </div>
    </div>
</div>

<!-- CSS Cải tiến -->
<style>
    .modal-body-message {
        font-size: 1rem;
        line-height: 1.5;
        white-space: pre-line;
        text-align: left;
        /* Căn lề trái văn bản */
        max-width: 90%;
        /* Đảm bảo khối không quá to */
        margin-left: auto;
        /* Căn giữa toàn khối */
        margin-right: auto;
    }


    .modal-icon {
        font-size: 2.75rem;
        animation: popIn 0.3s ease-in-out;
    }

    .modal-icon.success i {
        color: #28a745;
    }

    .modal-icon.error i {
        color: #dc3545;
    }

    .modal-icon.warning i {
        color: #ffc107;
    }

    .modal-icon.info i {
        color: #0dcaf0;
    }

    #globalAlertModal .modal-content {
        animation: fadeInUp 0.25s ease-in-out;
        background-color: #fff;
        border-radius: 1rem;
    }

    .modal-title {
        font-size: 1.25rem;
    }

    .modal-body-message {
        font-size: 1rem;
        line-height: 1.5;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes popIn {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>


<!-- JS showAlertModal cải tiến -->
<script>
    function showAlertModal({
        title = 'Thông báo',
        message = '',
        type = 'confirm',
        status = 'info',
        onConfirm = () => { }
    }) {
        const modalEl = document.getElementById('globalAlertModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        // Tiêu đề và nội dung
        modalEl.querySelector('.modal-title').textContent = title;
        modalEl.querySelector('.modal-body-message').innerHTML = message.replace(/\n/g, '<br>');

        // Icon
        const iconMap = {
            success: 'bi-check-circle-fill',
            error: 'bi-x-circle-fill',
            warning: 'bi-exclamation-circle-fill',
            info: 'bi-info-circle-fill'
        };
        const iconEl = modalEl.querySelector('.modal-icon i');
        const iconWrapper = modalEl.querySelector('.modal-icon');
        iconEl.className = `bi ${iconMap[status] || 'bi-info-circle-fill'}`;
        iconWrapper.className = `modal-icon text-center ${status}`;

        // Xử lý nút xác nhận
        const confirmBtn = modalEl.querySelector('#globalAlertModal-confirm-btn');
        const cancelBtn = modalEl.querySelector('[data-bs-dismiss]');
        const newBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

        if (type === 'alert') {
            cancelBtn.classList.add('d-none');
            newBtn.textContent = 'Đóng';
        } else {
            cancelBtn.classList.remove('d-none');
            newBtn.textContent = 'Đồng ý';
        }

        // Gọi callback
        newBtn.onclick = () => {
            modal.hide();
            if (type === 'confirm') onConfirm();
        };

        modal.show();
    }
</script>
