<template>
    <div class="p-4 bg-white rounded-3 shadow-sm">
        <h1 class="mb-4 fw-bold fs-2 text-primary">
            <i class="bi bi-file-earmark-person-fill me-2"></i> Quản lý đơn ứng tuyển
        </h1>

        <!-- Thanh tìm kiếm và chọn số dòng/trang -->
        <div class="d-flex align-items-center gap-3 mb-4 flex-wrap" style="row-gap: 0.5rem;">
            <select v-model="filterStatus" @change="fetchList(1)" class="form-select form-select-sm"
                style="max-width: 240px; min-width: 240px;" aria-label="Lọc trạng thái">
                <option value="">Tất cả trạng thái</option>
                <option v-for="status in statusOptions" :key="status.value" :value="status.value">
                    {{ status.label }}
                </option>
            </select>

            <div class="input-group" style="max-width: 320px; min-width: 240px;">
                <input v-model="search" @keyup.enter="fetchList(1)" type="search" class="form-control form-control-sm"
                    placeholder="Tìm ứng viên, công việc, công ty..." aria-label="Tìm kiếm" />
                <button class="btn btn-outline-primary btn-sm" type="button" @click="fetchList(1)" aria-label="Tìm kiếm"
                    title="Tìm kiếm">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="ms-auto d-flex align-items-center gap-2">
                <label for="perPageSelect" class="mb-0 text-nowrap text-secondary fw-semibold">Số dòng/trang:</label>
                <select id="perPageSelect" v-model="perPage" @change="fetchList(1)" class="form-select form-select-sm"
                    style="width: 90px;" aria-label="Số dòng trên trang">
                    <option v-for="n in [5, 10, 20, 50, 100, 500]" :key="n" :value="n">
                        {{ n }}
                    </option>
                </select>
            </div>
        </div>

        <button v-if="canCreate" @click="openForm()" class="mb-4 btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Tạo mới
        </button>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-4">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 20%;">Ứng viên</th>
                        <th style="width: 20%;">Công việc</th>
                        <th style="width: 20%;">Công ty</th>
                        <th style="width: 15%;">Trạng thái</th>
                        <th style="width: 20%;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="app in jobApplications" :key="app.id" class="align-middle">
                        <td class="text-center">{{ app.id }}</td>
                        <td>{{ app.user?.name || app.full_name }}</td>
                        <td>{{ app.job?.title }}</td>
                        <td>{{ app.company?.name }}</td>
                        <td class="text-center">
                            <span :class="statusBadgeClass(app.status)" class="text-uppercase">{{
                                statusLabel(app.status) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                                <button @click="showDetail(app)"
                                    class="btn btn-sm btn-outline-info d-flex align-items-center gap-1"
                                    title="Xem chi tiết" aria-label="Xem chi tiết">
                                    <i class="bi bi-eye-fill"></i> Xem
                                </button>
                                <button @click="openForm(app)"
                                    class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1"
                                    title="Sửa đơn" aria-label="Sửa đơn">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </button>
                                <button @click="confirmRemove(app.id)"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                    title="Xoá đơn" aria-label="Xoá đơn">
                                    <i class="bi bi-trash-fill"></i> Xoá
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="jobApplications.length === 0">
                        <td colspan="6" class="text-center text-muted py-4">Không có dữ liệu</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="text-secondary fw-semibold" aria-live="polite" aria-atomic="true">
                Tổng <span class="text-primary">{{ pagination.total || 0 }}</span> bản ghi |
                Trang <span class="text-primary">{{ page }}</span> /
                <span class="text-primary">{{ pagination.last_page || 1 }}</span>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-sm mb-0 flex-wrap gap-1">
                    <li class="page-item" :class="{ disabled: page <= 1 }">
                        <button class="page-link" @click="changePage(1)" :disabled="page <= 1" aria-label="Trang đầu"
                            title="Trang đầu">
                            <i class="bi bi-chevron-double-left"></i>
                        </button>
                    </li>
                    <li class="page-item" :class="{ disabled: page <= 1 }">
                        <button class="page-link" @click="changePage(page - 1)" :disabled="page <= 1"
                            aria-label="Trang trước" title="Trang trước">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                    </li>
                    <li v-for="p in pageNumbers" :key="p" class="page-item" :class="{ active: p === page }">
                        <button class="page-link" @click="changePage(p)" :aria-current="p === page ? 'page' : null">
                            {{ p }}
                        </button>
                    </li>
                    <li class="page-item" :class="{ disabled: page >= pagination.last_page }">
                        <button class="page-link" @click="changePage(page + 1)" :disabled="page >= pagination.last_page"
                            aria-label="Trang sau" title="Trang sau">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </li>
                    <li class="page-item" :class="{ disabled: page >= pagination.last_page }">
                        <button class="page-link" @click="changePage(pagination.last_page)"
                            :disabled="page >= pagination.last_page" aria-label="Trang cuối" title="Trang cuối">
                            <i class="bi bi-chevron-double-right"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Modal Form -->
        <div v-if="formOpen" class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);"
            role="dialog" aria-modal="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title">
                            {{ editApp ? 'Sửa' : 'Tạo mới' }} Đơn ứng tuyển
                            <span v-if="form.id" class="badge bg-warning text-dark ms-2">#{{ form.id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="closeForm"
                            aria-label="Đóng"></button>
                    </div>
                    <form @submit.prevent="save" novalidate>
                        <div class="modal-body px-4 py-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullNameInput" class="form-label fw-semibold">Họ tên</label>
                                    <input id="fullNameInput" v-model="form.full_name" type="text"
                                        class="form-control bg-light" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="emailInput" class="form-label fw-semibold">Email</label>
                                    <input id="emailInput" v-model="form.email" type="email"
                                        class="form-control bg-light" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="phoneInput" class="form-label fw-semibold">Số điện thoại</label>
                                    <input id="phoneInput" v-model="form.phone" type="text"
                                        class="form-control bg-light" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="cvInput" class="form-label fw-semibold">Đường dẫn CV</label>
                                    <div class="input-group">
                                        <input id="cvInput" v-model="form.image" type="text"
                                            class="form-control bg-light" readonly />
                                        <a v-if="form.image" :href="image(form.image)" class="btn btn-outline-secondary"
                                            target="_blank" rel="noopener" title="Xem CV">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Thư xin việc</label>
                                    <textarea class="form-control bg-light" rows="3"
                                        :value="form.cover_letter || 'Không có'" readonly></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ngày ứng tuyển</label>
                                    <input type="text" class="form-control bg-light"
                                        :value="formatDate(form.applied_at)" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="statusSelect" class="form-label fw-semibold">Trạng thái</label>
                                    <select id="statusSelect" v-model="form.status" class="form-select"
                                        :disabled="validStatusOptions.length === 1" aria-describedby="statusHelp">
                                        <option v-for="status in validStatusOptions" :key="status" :value="status">
                                            {{ statusLabel(status) }}
                                        </option>
                                    </select>
                                    <div id="statusHelp" class="form-text">
                                        Chỉ cho phép chọn trạng thái hợp lệ theo luồng
                                    </div>
                                </div>

                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" v-model="form.is_shortlisted"
                                            id="shortlistedCheck" />
                                        <label class="form-check-label" for="shortlistedCheck">Đã lọt vào danh
                                            sách</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nguồn ứng tuyển</label>
                                    <input v-model="form.source" type="text" class="form-control bg-light" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="interviewDateInput" class="form-label fw-semibold">Ngày phỏng vấn (nếu
                                        có)</label>
                                    <div class="input-group">
                                        <input id="interviewDateInput" v-model="form.interview_date"
                                            type="datetime-local" class="form-control"
                                            aria-describedby="interviewDatePreview" />
                                        <span class="input-group-text bg-light text-muted" style="font-size: 0.875rem;"
                                            id="interviewDatePreview"> <i class="bi bi-calendar-event me-1"></i>
                                            {{ formatDateTime(form.interview_date) }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ngày tạo đơn</label>
                                    <input type="text" class="form-control bg-light"
                                        :value="formatDateTime(form.created_at)" readonly />
                                </div>

                                <div class="col-md-12">
                                    <label for="noteTextarea" class="form-label fw-semibold">Ghi chú</label>
                                    <textarea id="noteTextarea" v-model="form.note" class="form-control" rows="3"
                                        placeholder="Ghi chú thêm (tuỳ chọn)"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-outline-secondary" @click="closeForm" aria-label="Huỷ">
                                Huỷ
                            </button>
                            <button type="submit" class="btn btn-success">
                                {{ editApp ? 'Lưu thay đổi' : 'Tạo mới' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail (Giao diện đẹp hơn) -->
        <div v-if="detailApp" class="modal d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.3);" role="dialog"
            aria-modal="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document"
                aria-label="Chi tiết đơn ứng tuyển">
                <div class="modal-content shadow border-0 rounded-4">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <i class="bi bi-person-lines-fill"></i>
                            Chi tiết đơn ứng tuyển
                            <span v-if="detailApp.id" class="badge bg-warning text-dark ms-2">#{{ detailApp.id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="detailApp = null"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <div class="card border-info h-100">
                                    <div class="card-header bg-info text-white fw-bold">Thông tin ứng viên</div>
                                    <div class="card-body">
                                        <p><strong>Họ tên:</strong> {{ detailApp.user?.name || detailApp.full_name }}
                                        </p>
                                        <p><strong>Email:</strong> {{ detailApp.email || detailApp.user?.email }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ detailApp.phone || detailApp.user?.phone
                                            }}</p>

                                        <!-- Phần CV dạng input group đẹp -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Đường dẫn CV</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" :value="detailApp.image || ''"
                                                    readonly style="background-color: #f8f9fa;"
                                                    aria-label="Đường dẫn CV" />
                                                <a v-if="detailApp.image" :href="image(detailApp.image)" target="_blank"
                                                    rel="noopener" class="btn btn-outline-secondary" title="Mở CV">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <p><strong>Thư xin việc:</strong></p>
                                        <p class="small text-muted" style="white-space: pre-wrap;">
                                            {{ detailApp.cover_letter || 'Không có' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-info h-100">
                                    <div class="card-header bg-info text-white fw-bold">Thông tin đơn ứng tuyển</div>
                                    <div class="card-body">
                                        <p><strong>Công việc:</strong> {{ detailApp.job?.title }}</p>
                                        <p><strong>Công ty:</strong> {{ detailApp.company?.name }}</p>
                                        <p>
                                            <strong>Trạng thái:</strong>
                                            <span :class="statusBadgeClass(detailApp.status)"
                                                class="text-uppercase px-2 py-1 rounded">
                                                {{ statusLabel(detailApp.status) }}
                                            </span>
                                        </p>
                                        <p><strong>Ngày ứng tuyển:</strong> {{ formatDate(detailApp.applied_at) }}</p>
                                        <p><strong>Ngày phỏng vấn:</strong> {{ formatDateTime(detailApp.interview_date)
                                            }}</p>
                                        <p><strong>Nguồn ứng tuyển:</strong> {{ detailApp.source }}</p>
                                        <p><strong>Ghi chú:</strong></p>
                                        <p class="small text-muted" style="white-space: pre-wrap;">
                                            {{ detailApp.note || 'Không có' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-outline-secondary" @click="detailApp = null"
                            aria-label="Đóng chi tiết">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script setup>
    import { ref, onMounted, computed } from 'vue'
    import axios from 'axios'

    // Hàm showAlertModal đã import sẵn từ layout
    // Bạn chỉ cần gọi như ví dụ bên dưới
    // showAlertModal({ title, message, type, status, onConfirm })

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
        'offered',
        'no_response',
        'rejected',
        'saved'
    ]

    const form = ref({
        id: null,
        job_id: '',
        user_id: '',
        company_id: '',
        full_name: '',
        email: '',
        phone: '',
        image: '',
        cover_letter: '',
        applied_at: '',
        status: 'pending',
        is_shortlisted: false,
        source: '',
        interview_date: '',
        note: '',
        created_at: '',
        updated_at: '',
        deleted_at: ''
    })

    const validStatusOptions = computed(() => {
        const current = initialStatus.value

        if (current === 'pending') {
            return ['interview_scheduled', 'rejected', 'saved']
        }

        if (current === 'interview_scheduled') {
            return ['offered', 'no_response', 'rejected']
        }

        if (['rejected', 'hired', 'offered', 'candidate_declined', 'no_response'].includes(current)) {
            return [current]
        }

        if (current === 'rejected') {
            return ['rejected']
        }

        const idx = statusFlow.indexOf(current)
        if (idx === -1) return statusFlow

        return statusFlow.slice(idx)
    })

    // Dùng showAlertModal cho các thông báo lỗi
    function showError(message) {
        showAlertModal({
            title: 'Lỗi',
            message,
            type: 'alert',
            status: 'error',
            onConfirm: () => { }
        })
    }

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
        { value: 'interview_scheduled', label: 'Mời phỏng vấn' },
        { value: 'offered', label: 'Trúng tuyển' },
        { value: 'no_response', label: 'Không phản hồi' },
        { value: 'rejected', label: 'Đã loại' },
        { value: 'saved', label: 'Lưu hồ sơ' }
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
                full_name: app.full_name || app.user?.name || '',
                email: app.email || app.user?.email || '',
                phone: app.phone || app.user?.phone || '',
                image: app.image || '',
                cover_letter: app.cover_letter || '',
                applied_at: app.applied_at || '',
                status: app.status || 'pending',
                is_shortlisted: !!app.is_shortlisted,
                source: app.source || '',
                interview_date: app.interview_date ? app.interview_date.substring(0, 16) : '',
                note: app.note || '',
                created_at: app.created_at || '',
                updated_at: app.updated_at || '',
                deleted_at: app.deleted_at || ''
            }

            const validOptions = validStatusOptions.value
            if (!validOptions.includes(form.value.status)) {
                form.value.status = validOptions[0]
            }
        } else {
            editApp.value = null
            initialStatus.value = 'pending'

            const validOptions = validStatusOptions.value

            form.value = {
                id: null,
                job_id: '',
                user_id: '',
                company_id: '',
                full_name: '',
                email: '',
                phone: '',
                image: '',
                cover_letter: '',
                applied_at: '',
                status: validOptions[0],
                is_shortlisted: false,
                source: '',
                interview_date: '',
                note: '',
                created_at: '',
                updated_at: '',
                deleted_at: ''
            }
        }
        formOpen.value = true
    }

    const closeForm = () => {
        formOpen.value = false
        editApp.value = null
    }

    // Sử dụng showAlertModal cho thông báo thành công
    const save = async () => {
        try {
            const currentStatus = initialStatus.value
            const newStatus = form.value.status
            const interviewDate = form.value.interview_date

            if (!validateStatusChange(currentStatus, newStatus, interviewDate)) {
                return
            }

            if (editApp.value) {
                await axios.put(`/api/job-applications/${editApp.value.id}`, form.value)
                showAlertModal({
                    title: 'Thành công',
                    message: `Cập nhật đơn #${editApp.value.id} thành công.`,
                    type: 'alert',
                    status: 'success',
                    onConfirm: () => { }
                })
            } else {
                await axios.post('/api/job-applications', form.value)
                showAlertModal({
                    title: 'Thành công',
                    message: 'Tạo mới đơn ứng tuyển thành công.',
                    type: 'alert',
                    status: 'success',
                    onConfirm: () => { }
                })
            }

            closeForm()
            fetchList(page.value)
        } catch (err) {
            showError('Lỗi: ' + (err.response?.data?.message || err.message || 'Lỗi không xác định'))
        }
    }

    // Dùng showAlertModal để hỏi xác nhận xóa
    const confirmRemove = id => {
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
                        status: 'success',
                        onConfirm: () => { }
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
            'bg-danger': ['rejected', 'no_response'].includes(status)
        }
    }

    function statusLabel(status) {
        switch (status) {
            case 'pending': return 'Chờ xử lý'
            case 'viewed': return 'Đã xem'
            case 'under_review': return 'Đang đánh giá'
            case 'contacting': return 'Đang liên hệ'
            case 'interview_scheduled': return 'Mời phỏng vấn'
            case 'offered': return 'Trúng tuyển'
            case 'no_response': return 'Không phản hồi'
            case 'rejected': return 'Đã loại'
            case 'saved': return 'Lưu hồ sơ'
            default: return status
        }
    }

    onMounted(() => fetchList())

    const pageNumbers = computed(() => {
        const totalPages = pagination.value.last_page || 1
        const currentPage = page.value
        let start = Math.max(currentPage - 2, 1)
        let end = Math.min(currentPage + 2, totalPages)

        if (currentPage <= 3) {
            end = Math.min(5, totalPages)
        }
        if (currentPage >= totalPages - 2) {
            start = Math.max(totalPages - 4, 1)
        }

        const pages = []
        for (let i = start; i <= end; i++) {
            pages.push(i)
        }
        return pages
    })
</script>