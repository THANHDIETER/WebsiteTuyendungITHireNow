<form id="editNotificationForm" action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Loại thông báo -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Loại thông báo <span class="text-danger">*</span></label>
        <select name="type" class="form-select" required>
            <option value="">-- Chọn loại --</option>
            <option value="App\Notifications\System\GeneralNotification"
                {{ old('type', $notification->type) == 'App\Notifications\System\GeneralNotification' ? 'selected' : '' }}>
                GeneralNotification
            </option>
            <option value="App\Notifications\System\MaintenanceNotification"
                {{ old('type', $notification->type) == 'App\Notifications\System\MaintenanceNotification' ? 'selected' : '' }}>
                MaintenanceNotification
            </option>
        </select>
    </div>

    <!-- Nội dung JSON -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Nội dung (JSON) <span class="text-danger">*</span></label>
        <textarea name="data" class="form-control font-monospace" rows="5" required>{{ old('data', json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
        <div class="form-text">
            Ví dụ: <code>{"message": "Thông báo nội dung ở đây"}</code>
        </div>
    </div>

    <!-- Nút -->
    <div class="text-end">
        <button type="submit" class="btn btn-warning text-dark">
            <i class="bi bi-save me-1"></i> Cập nhật
        </button>
    </div>
</form>

<script>
document.getElementById('editNotificationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(res => res.json())
    .then(resp => {
        alert(resp.message);
        location.reload();
    });
});
</script>

<style>
    .form-label { font-size: 0.9rem; }
    textarea { font-size: 0.85rem; line-height: 1.4; }
    code {
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
