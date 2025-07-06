<template>
    <div class="p-4">
        <h1 class="mb-4 fw-bold fs-2">Quản lý đơn ứng tuyển</h1>

        <!-- Thanh tìm kiếm và chọn số dòng/trang -->
        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
            <!-- Dropdown chọn trạng thái -->
            <select v-model="filterStatus" @change="fetchList(1)" class="form-select form-select-sm p-2"
                style="width: 240px;">
                <option value="">Tất cả trạng thái</option>
                <option v-for="status in statusOptions" :key="status.value" :value="status.value">
                    {{ status.label }}
                </option>
            </select>

            <!-- Ô tìm kiếm -->
            <input v-model="search" @keyup.enter="fetchList(1)" class="form-control" style="width: 240px;"
                placeholder="Tìm ứng viên, công việc, công ty..." />
            <button class="btn btn-outline-secondary" @click="fetchList(1)">
                <i class="bi bi-search"></i>
            </button>

            <div class="ms-auto d-flex align-items-center gap-2">
                <label class="mb-0 text-nowrap text-secondary fw-semibold">Số dòng/trang:</label>
                <select v-model="perPage" @change="fetchList(1)" class="form-select form-select-sm"
                    style="width: 80px;">
                    <option v-for="n in [5, 10, 20, 50, 100, 500]" :key="n" :value="n">{{ n }}</option>
                </select>
            </div>
        </div>



        <button v-if="canCreate" @click="openForm()" class="mb-4 btn btn-primary">Tạo mới</button>

        <table class="table table-bordered mb-4 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ứng viên</th>
                    <th>Công việc</th>
                    <th>Công ty</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="app in jobApplications" :key="app.id">
                    <td>{{ app.id }}</td>
                    <td>{{ app.user?.name || app.full_name }}</td>
                    <td>{{ app.job?.title }}</td>
                    <td>{{ app.company?.name }}</td>
                    <td>
                        <span :class="statusBadgeClass(app.status)">
                            {{ statusLabel(app.status) }}
                        </span>
                    </td>
                    <td class="text-nowrap align-middle">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button @click="showDetail(app)"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-eye"></i> Xem
                            </button>
                            <button @click="openForm(app)"
                                class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button @click="remove(app.id)"
                                class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
                        </div>
                    </td>

                </tr>
                <tr v-if="jobApplications.length === 0">
                    <td colspan="6" class="text-center text-muted py-4">Không có dữ liệu</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="text-secondary fw-semibold">
                Tổng <span class="text-primary">{{ pagination.total || 0 }}</span> bản ghi | Trang
                <span class="text-primary">{{ page }}</span> / <span class="text-primary">{{ pagination.last_page || 1
                    }}</span>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">

                    <!-- Trang đầu -->
                    <li class="page-item" :class="{ disabled: page <= 1 }">
                        <button class="page-link" @click="changePage(1)" :disabled="page <= 1" aria-label="Trang đầu">
                            «
                        </button>
                    </li>

                    <!-- Trang trước -->
                    <li class="page-item" :class="{ disabled: page <= 1 }">
                        <button class="page-link" @click="changePage(page - 1)" :disabled="page <= 1"
                            aria-label="Trang trước">
                            ←
                        </button>
                    </li>

                    <!-- Các số trang hiển thị (ví dụ: hiện 5 trang xung quanh trang hiện tại) -->
                    <li v-for="p in pageNumbers" :key="p" class="page-item" :class="{ active: p === page }">
                        <button class="page-link" @click="changePage(p)">{{ p }}</button>
                    </li>

                    <!-- Trang sau -->
                    <li class="page-item" :class="{ disabled: page >= (pagination.last_page || 1) }">
                        <button class="page-link" @click="changePage(page + 1)"
                            :disabled="page >= (pagination.last_page || 1)" aria-label="Trang sau">
                            →
                        </button>
                    </li>

                    <!-- Trang cuối -->
                    <li class="page-item" :class="{ disabled: page >= (pagination.last_page || 1) }">
                        <button class="page-link" @click="changePage(pagination.last_page)"
                            :disabled="page >= (pagination.last_page || 1)" aria-label="Trang cuối">
                            »
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Modal Form -->
        <div v-if="formOpen" class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title">
                            {{ editApp ? 'Sửa' : 'Tạo mới' }} Đơn ứng tuyển
                            <span v-if="form.id" class="badge bg-warning text-dark ms-2">#{{ form.id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="closeForm"></button>
                    </div>
                    <form @submit.prevent="save">
                        <div class="modal-body px-4 py-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Vị trí ứng tuyển</label>
                                    <input v-model="form.job_id" type="hidden" />
                                    <input v-model="form.job_title" type="text" class="form-control bg-light"
                                        placeholder="Tên vị trí" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ứng viên</label>
                                    <input v-model="form.user_id" type="hidden" />
                                    <input v-model="form.user_name" type="text" class="form-control bg-light"
                                        placeholder="Họ tên ứng viên" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Công ty</label>
                                    <input v-model="form.company_id" type="hidden" />
                                    <input v-model="form.company_name" type="text" class="form-control bg-light"
                                        placeholder="Tên công ty" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Đường dẫn CV</label>
                                    <div class="input-group">
                                        <input v-model="form.image" type="text" class="form-control bg-light"
                                            readonly />
                                        <a v-if="form.image" :href="image(form.image)" class="btn btn-outline-secondary"
                                            target="_blank" title="Xem CV">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Thư xin việc</label>
                                    <textarea class="form-control bg-light" rows="3"
                                        :value="form.cover_letter || 'Không có'" readonly></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Trạng thái</label>
                                    <select v-model="form.status" class="form-select">
                                        <option v-for="status in validStatusOptions" :key="status" :value="status">
                                            {{ statusLabel(status) }}
                                        </option>
                                    </select>

                                </div>

                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" v-model="form.is_shortlisted"
                                            id="shortlistedCheck" />
                                        <label class="form-check-label" for="shortlistedCheck">Đã lọt vào danh
                                            sách</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nguồn ứng tuyển</label>
                                    <input v-model="form.source" type="text" class="form-control bg-light"
                                        placeholder="Ví dụ: Facebook, Website..." readonly />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ngày phỏng vấn (nếu có)</label>
                                    <div class="input-group">
                                        <input v-model="form.interview_date" type="datetime-local" class="form-control"
                                            aria-label="Ngày phỏng vấn" />
                                        <span class="input-group-text bg-light text-muted" style="font-size: 0.875rem;">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ formatDateTime(form.interview_date) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Ghi chú</label>
                                    <textarea v-model="form.note" class="form-control" rows="5"
                                        placeholder="Ghi chú thêm (tuỳ chọn)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-outline-secondary" @click="closeForm">Huỷ</button>
                            <button type="submit" class="btn btn-success">
                                {{ editApp ? 'Lưu thay đổi' : 'Tạo mới' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div v-if="detailApp" class="modal d-block" tabindex="-1" style="background:rgba(0,0,0,0.3)">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content shadow border-0 rounded-4">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Chi tiết đơn ứng tuyển
                            <span v-if="detailApp?.id" class="badge bg-warning text-dark ms-2">#{{ detailApp.id
                                }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="detailApp = null"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-fill me-2"></i>Thông tin
                                    ứng viên</h6>
                                <p><i class="bi bi-person me-1 text-secondary"></i> Họ tên: <strong>{{
                                        detailApp.full_name }}</strong></p>
                                <p><i class="bi bi-envelope me-1 text-secondary"></i> Email: <strong>{{ detailApp.email
                                        }}</strong></p>
                                <p><i class="bi bi-telephone me-1 text-secondary"></i> SĐT: <strong>{{ detailApp.phone
                                        }}</strong></p>
                                <p>
                                    <i class="bi bi-file-earmark-person me-1 text-secondary"></i> CV:
                                    <a :href="image(detailApp.image)" target="_blank">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Xem CV (PDF)
                                    </a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-briefcase-fill me-2"></i>Thông tin
                                    ứng tuyển</h6>
                                <p><i class="bi bi-briefcase me-1 text-secondary"></i> Vị trí: <strong>{{
                                        detailApp.job?.title }}</strong></p>
                                <p><i class="bi bi-building me-1 text-secondary"></i> Công ty: <strong>{{
                                        detailApp.company?.name }}</strong></p>
                                <p><i class="bi bi-calendar-check me-1 text-secondary"></i> Ngày ứng tuyển: <strong>{{
                                        formatDate(detailApp.applied_at) }}</strong></p>
                                <p><i class="bi bi-link-45deg me-1 text-secondary"></i> Nguồn: <strong>{{
                                        detailApp.source || '—' }}</strong></p>
                                <p>
                                    <i class="bi bi-calendar-event me-1 text-secondary"></i> Ngày phỏng vấn: <strong>{{
                                        formatDate(detailApp.interview_date) }}</strong>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 bg-light rounded border">
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-info-circle-fill me-2"></i>Trạng thái</h6>
                                    <span :class="statusBadgeClass(detailApp.status)">{{ statusLabel(detailApp.status)
                                        }}</span>
                                    <span v-if="detailApp.is_shortlisted" class="badge bg-primary ms-2">
                                        <i class="bi bi-star-fill me-1"></i> Đã lọt DS
                                    </span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-envelope-paper-heart me-2"></i>Thư xin việc</h6>
                                    <p class="mb-0">{{ detailApp.cover_letter || 'Không có' }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-journal-text me-2"></i>Ghi chú
                                    </h6>
                                    <p class="mb-0">{{ detailApp.note || 'Không có ghi chú.' }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded border">
                                    <h6 class="fw-bold text-secondary mb-2"><i
                                            class="bi bi-clock-history me-2"></i>Thông tin hệ thống</h6>
                                    <p class="mb-1">Tạo lúc: <strong>{{ formatDate(detailApp.created_at) }}</strong></p>
                                    <p class="mb-1">Cập nhật: <strong>{{ formatDate(detailApp.updated_at) }}</strong>
                                    </p>
                                    <p v-if="detailApp.deleted_at" class="text-danger">Đã xoá: <strong>{{
                                            formatDate(detailApp.deleted_at) }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-outline-secondary" @click="detailApp = null">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, computed } from 'vue'
    import axios from 'axios'

    const token = localStorage.getItem('access_token')
    if (token) axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

    const jobApplications = ref([])
    const pagination = ref({})
    const page = ref(1)
    const formOpen = ref(false)
    const detailApp = ref(null)
    const editApp = ref(null)
    const search = ref('')
    const perPage = ref(10)
    const filterStatus = ref('')

    const initialStatus = ref('')

    const canCreate = false

    const image = filePath =>
        filePath ? (filePath.startsWith('http') ? filePath : `/storage/${filePath}`) : '#'

    const statusFlow = [
        'pending',
        'viewed',
        'under_review',
        'contacting',
        'interview_scheduled',
        'interviewed',
        'offered',
        'hired',
        'candidate_declined',
        'no_response',
        'rejected'
    ]

    const form = ref({
        id: null,
        job_id: '',
        user_id: '',
        company_id: '',
        job_title: '',
        user_name: '',
        company_name: '',
        image: '',
        cover_letter: '',
        status: 'pending',
        is_shortlisted: false,
        source: '',
        interview_date: '',
        note: ''
    })

    // Hàm tính valid status options theo trạng thái hiện tại (initialStatus)
    const validStatusOptions = computed(() => {
        const current = initialStatus.value

        // Nếu đơn bị từ chối rồi thì chỉ hiện trạng thái rejected để không đổi
        if (current === 'rejected') {
            return ['rejected']
        }

        // Nếu đã nhận việc thì chỉ giữ lại trạng thái hired
        if (current === 'hired') {
            return ['hired']
        }

        // Nếu ứng viên từ chối hoặc không phản hồi thì chỉ giữ lại trạng thái hiện tại (không cho đổi)
        if (['candidate_declined', 'no_response'].includes(current)) {
            return [current]
        }

        // Nếu là trạng thái bình thường thì chỉ cho chọn trạng thái từ current trở đi (không được lùi)
        const idx = statusFlow.indexOf(current)
        if (idx === -1) return statusFlow

        // Nếu đã phỏng vấn rồi thì không cho đổi xuống dưới 'interviewed' (ví dụ), bạn có thể điều chỉnh thêm logic này nếu muốn
        // Ở đây để đơn giản cho phép chọn từ current trở đi
        return statusFlow.slice(idx)
    })

    // Hàm hiển thị thông báo sử dụng showAlertModal
    function showError(message) {
        showAlertModal({
            title: 'Lỗi',
            message,
            type: 'alert',
            status: 'error',
            onConfirm: () => { }
        })
    }

    // Hàm validate trạng thái trước khi gửi lên API
    function validateStatusChange(currentStatus, newStatus, interviewDate) {
        const statusOrder = statusFlow

        const currentIndex = statusOrder.indexOf(currentStatus)
        const newIndex = statusOrder.indexOf(newStatus)

        if (currentIndex === -1 || newIndex === -1) {
            showError('Trạng thái không hợp lệ.')
            return false
        }

        if (newIndex < currentIndex) {
            showError('Không thể quay lại trạng thái trước.')
            return false
        }

        if (currentStatus === 'rejected' && newStatus !== 'rejected') {
            showError('Không thể cập nhật đơn đã bị từ chối.')
            return false
        }

        if (currentStatus === 'hired' && newStatus !== 'hired') {
            showError('Không thể thay đổi trạng thái sau khi ứng viên đã nhận việc.')
            return false
        }

        if (interviewDate) {
            const now = new Date()
            const interview = new Date(interviewDate)
            if (now > interview) {
                const invalidBeforeInterviewStatuses = [
                    'pending',
                    'viewed',
                    'under_review',
                    'contacting',
                    'interview_scheduled'
                ]
                if (invalidBeforeInterviewStatuses.includes(newStatus)) {
                    showError('Không thể chuyển trạng thái về trước sau khi ngày phỏng vấn đã trôi qua.')
                    return false
                }
            }
        }

        return true
    }
    const statusOptions = [
        { value: 'pending', label: 'Chờ xử lý' },
        { value: 'viewed', label: 'Đã xem' },
        { value: 'under_review', label: 'Đang đánh giá' },
        { value: 'contacting', label: 'Đang liên hệ' },
        { value: 'interview_scheduled', label: 'Đã mời phỏng vấn' },
        { value: 'interviewed', label: 'Đã phỏng vấn' },
        { value: 'offered', label: 'Trúng tuyển' },
        { value: 'hired', label: 'Đã nhận việc' },
        { value: 'candidate_declined', label: 'Ứng viên từ chối' },
        { value: 'no_response', label: 'Không phản hồi' },
        { value: 'rejected', label: 'Đã loại' }
    ]


    const fetchList = async (gotoPage = 1) => {
        try {
            const { data } = await axios.get('/api/job-applications', {
                params: {
                    page: gotoPage,
                    search: search.value,
                    per_page: perPage.value,
                    status: filterStatus.value
                }
            })
            jobApplications.value = data.data
            pagination.value = data
            page.value = data.current_page
        } catch (err) {
            showError('Lỗi tải danh sách: ' + (err.message || 'Không thể tải dữ liệu.'))
        }
    }

    const changePage = p => fetchList(p)

    const openForm = app => {
        if (app) {
            editApp.value = app
            initialStatus.value = app.status || 'pending'

            form.value = {
                id: app.id,
                job_id: app.job_id,
                user_id: app.user_id,
                company_id: app.company_id,
                job_title: app.job?.title || '',
                user_name: app.user?.name || app.full_name || '',
                company_name: app.company?.name || '',
                image: app.image || '',
                cover_letter: app.cover_letter || '',
                status: app.status || 'pending',
                is_shortlisted: !!app.is_shortlisted,
                source: app.source || '',
                interview_date: app.interview_date ? app.interview_date.substring(0, 16) : '',
                note: app.note || ''
            }
        } else {
            editApp.value = null
            initialStatus.value = 'pending'
            form.value = {
                id: null,
                job_id: '',
                user_id: '',
                company_id: '',
                job_title: '',
                user_name: '',
                company_name: '',
                image: '',
                cover_letter: '',
                status: 'pending',
                is_shortlisted: false,
                source: '',
                interview_date: '',
                note: ''
            }
        }
        formOpen.value = true
    }

    const closeForm = () => {
        formOpen.value = false
        editApp.value = null
    }

    const save = async () => {
        try {
            const currentStatus = initialStatus.value
            const newStatus = form.value.status
            const interviewDate = form.value.interview_date

            if (!validateStatusChange(currentStatus, newStatus, interviewDate)) {
                return
            }

            if (editApp.value && editApp.value.id) {
                await axios.put(`/api/job-applications/${editApp.value.id}`, form.value)
                showAlertModal({
                    title: 'Thành công',
                    message: `Cập nhật đơn #${editApp.value.id} thành công.`,
                    type: 'alert',
                    status: 'success'
                })
            } else {
                await axios.post('/api/job-applications', form.value)
                showAlertModal({
                    title: 'Thành công',
                    message: 'Tạo mới đơn ứng tuyển thành công.',
                    type: 'alert',
                    status: 'success'
                })
            }

            closeForm()
            fetchList(page.value)
        } catch (err) {
            showError('Lỗi khi lưu: ' + (err.response?.data?.message || err.message || 'Lỗi không xác định'))
        }
    }


    const remove = id => {
        showAlertModal({
            title: 'Xác nhận',
            message: `Bạn có chắc muốn xoá đơn #${id}?`,
            type: 'confirm',
            status: 'warning',
            onConfirm: async () => {
                try {
                    await axios.delete(`/api/job-applications/${id}`)
                    showAlertModal({
                        title: 'Thành công',
                        message: `Đơn #${id} đã xoá.`,
                        type: 'alert',
                        status: 'success'
                    })
                    fetchList(page.value)
                } catch {
                    showError('Không thể xoá đơn ứng tuyển.')
                }
            }
        })
    }

    const showDetail = app => {
        detailApp.value = app
    }

    function formatDate(date) {
        if (!date) return '—'
        return new Date(date).toLocaleDateString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        })
    }

    function formatDateTime(datetime) {
        if (!datetime) return '—'
        return new Date(datetime).toLocaleString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        })
    }

    function statusBadgeClass(status) {
        return {
            'badge rounded-pill px-3 py-2 text-uppercase fw-semibold': true,
            'bg-secondary': status === 'pending',
            'bg-info text-dark': ['viewed', 'under_review', 'contacting', 'interview_scheduled'].includes(status),
            'bg-success': ['offered', 'hired'].includes(status),
            'bg-danger': ['rejected', 'candidate_declined', 'no_response'].includes(status)
        }
    }

    function statusLabel(status) {
        switch (status) {
            case 'pending': return 'Chờ xử lý'
            case 'viewed': return 'Đã xem'
            case 'under_review': return 'Đang đánh giá'
            case 'contacting': return 'Đang liên hệ'
            case 'interview_scheduled': return 'Đã mời phỏng vấn'
            case 'interviewed': return 'Đã phỏng vấn'
            case 'offered': return 'Trúng tuyển'
            case 'hired': return 'Đã nhận việc'
            case 'candidate_declined': return 'Ứng viên từ chối'
            case 'no_response': return 'Không phản hồi'
            case 'rejected': return 'Đã loại'
            default: return status
        }
    }

    onMounted(() => fetchList())
</script>