<div class="modal fade" id="globalAlertModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4" style="max-width: 440px; margin: auto; border-radius: 16px;">
            <div class="fs-1 mb-3 modal-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <h5 class="mb-2 fw-bold modal-title">Thông báo</h5>
            <p class="text-muted mb-4 modal-body-message">Đây là nội dung thông báo</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-primary px-4" id="globalAlertModal-confirm-btn">Đồng ý</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<style>
#globalAlertModal .modal-content {
    border: none;
    box-shadow: 0 5px 40px rgba(0, 0, 0, 0.15);
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
.modal-icon i {
    font-size: 2.5rem;
}
.modal-icon.success i {
    color: #28a745; /* xanh lá */
}
.modal-icon.error i {
    color: #dc3545; /* đỏ */
}
.modal-icon.warning i {
    color: #ffc107; /* vàng */
}
.modal-icon.info i {
    color: #17a2b8; /* xanh dương */
}
</style>

<script>
function showAlertModal({
    title = 'Thông báo',
    message = '',
    type = 'confirm',
    status = 'info', // success | error | warning | info
    onConfirm = () => {}
}) {
    const modalEl = document.getElementById('globalAlertModal');
    modalEl.removeAttribute('inert');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modalEl.querySelector('.modal-title').textContent = title;
    modalEl.querySelector('.modal-body-message').textContent = message;

    // Handle icon class
    const iconMap = {
        success: 'bi-check-circle-fill',
        error: 'bi-x-circle-fill',
        warning: 'bi-exclamation-circle-fill',
        info: 'bi-info-circle-fill',
        question: 'bi-question-circle-fill' 

    };

    const iconEl = modalEl.querySelector('.modal-icon i');
    const iconWrapper = modalEl.querySelector('.modal-icon');
    iconEl.className = `bi ${iconMap[status] || 'bi-info-circle-fill'}`;
    iconWrapper.className = `fs-1 mb-3 modal-icon ${status}`;

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

    let lastFocused = document.activeElement;
    modalEl.addEventListener('hidden.bs.modal', function handler() {
        modalEl.setAttribute('inert', 'true');
        if (lastFocused && typeof lastFocused.focus === 'function') {
            setTimeout(() => lastFocused.focus(), 10);
        } else {
            document.body.focus();
        }
        modalEl.removeEventListener('hidden.bs.modal', handler);
    });

    newBtn.onclick = function () {
        modal.hide();
        if (type === 'confirm') onConfirm();
    };

    modal.show();
    modalEl.removeAttribute('inert');
}
</script>

@if (session('success') || session('info') || session('error') || session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = {
        success: 'success',
        info: 'info',
        error: 'error',
        warning: 'warning'
    }['{{ session()->has("success") ? "success" : (session()->has("info") ? "info" : (session()->has("warning") ? "warning" : "error")) }}'];

    const title = {
        success: 'Thành công',
        info: 'Thông báo',
        error: 'Lỗi',
        warning: 'Cảnh báo'
    }[type];

    const message = `{!! session('success') ?? session('info') ?? session('warning') ?? session('error') !!}`;

    showAlertModal({
        type: 'alert',
        status: type,
        title,
        message
    });
});
</script>
@endif
