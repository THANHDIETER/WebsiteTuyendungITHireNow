<template>
    <div class="p-4">
        <h1 class="mb-4 fw-bold fs-2">Quản lý đơn ứng tuyển</h1>
        <!-- Thanh tìm kiếm và chọn số dòng/trang -->
        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
            <input v-model="search" @keyup.enter="fetchList(1)" class="form-control" style="max-width: 240px"
                placeholder="Tìm ứng viên, công việc, công ty...">
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
                    <td>{{ app.user?.name }}</td>
                    <td>{{ app.job?.title }}</td>
                    <td>{{ app.company?.name }}</td>
                    <td>
                        <span :class="{
    'badge rounded-pill px-3 py-2 text-uppercase fw-semibold': true,
    'bg-secondary': app.status === 'pending',
    'bg-success': app.status === 'approved' || app.status === 'hired',
    'bg-danger': app.status === 'rejected',
    'bg-warning text-dark': app.status === 'cancelled',
    'bg-info text-dark': app.status === 'withdrawn',
    'bg-dark': app.status === 'archived'
  }">
                            {{
                            app.status === 'pending' ? 'Đang chờ' :
                            app.status === 'approved' ? 'Đã duyệt' :
                            app.status === 'rejected' ? 'Từ chối' :
                            app.status === 'cancelled' ? 'Đã hủy' :
                            app.status === 'withdrawn' ? 'Ứng viên rút' :
                            app.status === 'hired' ? 'Đã tuyển' :
                            app.status === 'archived' ? 'Lưu trữ' :
                            app.status
                            }}
                        </span>
                    </td>

                    <td class="text-nowrap">
                        <div class="d-flex align-items-center gap-2">
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
        <div class="mb-4 d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <button class="btn btn-outline-primary btn-sm px-3" :disabled="!pagination.prev_page_url"
                @click="changePage(page - 1)">
                ← Trước
            </button>
            <span class="fw-semibold text-primary-emphasis">
                Trang <strong>{{ page }}</strong>
            </span>
            <button class="btn btn-outline-primary btn-sm px-3" :disabled="!pagination.next_page_url"
                @click="changePage(page + 1)">
                Sau →
            </button>
        </div>

        <!-- Modal Form (để nguyên, hoặc tuỳ biến theo hướng dẫn trước đó) -->
        <div v-if="formOpen" class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-lg modal-dialog-centered">
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
                                        <option value="pending">Chờ xử lý</option>
                                        <option value="approved">Đã duyệt</option>
                                        <option value="rejected">Từ chối</option>
                                        <option value="cancelled">Đã hủy</option>
                                        <option value="withdrawn">Ứng viên rút</option>
                                        <option value="hired">Đã tuyển</option>
                                        <option value="archived">Lưu trữ</option>
                                    </select>

                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" v-model="form.is_shortlisted"
                                            id="shortlistedCheck">
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
                                    <label class="form-label fw-semibold">
                                        Giai đoạn hiện tại
                                        <span v-if="form.application_stage" class="ms-2 badge bg-info text-dark">
                                            {{ formatStage(form.application_stage) }}
                                        </span>
                                    </label>
                                    <select v-model="form.application_stage" class="form-select"
                                        :disabled="stageOptions.length === 0">
                                        <option v-for="stage in stageOptions" :key="stage" :value="stage">
                                            {{ formatStage(stage) }}
                                        </option>
                                    </select>
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


                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ghi chú</label>
                                    <textarea v-model="form.note" class="form-control" rows="2"
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <!-- Thông tin cá nhân -->
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
                                        <i class="bi bi-box-arrow-up-right me-1"> </i>
                                        Xem CV (PDF)
                                    </a>
                                </p>
                            </div>

                            <!-- Thông tin công việc -->
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
                                    <i class="bi bi-stack me-1 text-secondary"></i>
                                    Giai đoạn:
                                    <strong>{{ formatStage(detailApp.application_stage) }}</strong>
                                </p>

                                <p>
                                    <i class="bi bi-calendar-event me-1 text-secondary"></i> Ngày phỏng vấn:
                                    <strong>{{ formatDate(detailApp.interview_date) }}</strong>
                                </p>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-12">
                                <div class="p-3 bg-light rounded border">
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-info-circle-fill me-2"></i>Trạng thái</h6>
                                    <span :class="{
  'badge rounded-pill px-3 py-2 text-uppercase fw-semibold': true,
  'bg-secondary': detailApp.status === 'pending',
  'bg-success': detailApp.status === 'approved' || detailApp.status === 'hired',
  'bg-danger': detailApp.status === 'rejected',
  'bg-warning text-dark': detailApp.status === 'cancelled',
  'bg-info text-dark': detailApp.status === 'withdrawn',
  'bg-dark': detailApp.status === 'archived'
}">
                                        {{
                                        detailApp.status === 'pending' ? 'Đang chờ' :
                                        detailApp.status === 'approved' ? 'Đã duyệt' :
                                        detailApp.status === 'rejected' ? 'Từ chối' :
                                        detailApp.status === 'cancelled' ? 'Đã hủy' :
                                        detailApp.status === 'withdrawn' ? 'Ứng viên rút' :
                                        detailApp.status === 'hired' ? 'Đã tuyển' :
                                        detailApp.status === 'archived' ? 'Lưu trữ' :
                                        detailApp.status
                                        }}
                                    </span>

                                    <span v-if="detailApp.is_shortlisted" class="badge bg-primary ms-2">
                                        <i class="bi bi-star-fill me-1"></i> Đã lọt DS
                                    </span>
                                </div>
                            </div>

                            <!-- Thư xin việc -->
                            <div class="col-12">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-envelope-paper-heart me-2"></i>Thư xin việc</h6>
                                    <p class="mb-0">{{ detailApp.cover_letter || 'Không có' }}</p>
                                </div>
                            </div>

                            <!-- Ghi chú -->
                            <div class="col-12">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-journal-text me-2"></i>Ghi chú
                                    </h6>
                                    <p class="mb-0">{{ detailApp.note || 'Không có ghi chú.' }}</p>
                                </div>
                            </div>

                            <!-- Thông tin hệ thống -->
                            <div class="col-12">
                                <div class="p-3 bg-light rounded border">
                                    <h6 class="fw-bold text-secondary mb-2"><i
                                            class="bi bi-clock-history me-2"></i>Thông tin hệ thống</h6>
                                    <p class="mb-1">Tạo lúc: <strong>{{ formatDate(detailApp.created_at) }}</strong></p>
                                    <p class="mb-1">Cập nhật: <strong>{{ formatDate(detailApp.updated_at) }}</strong>
                                    </p>
                                    <p v-if="detailApp.deleted_at">Đã xoá: <strong class="text-danger">{{
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
    import { ref, computed, onMounted, watch } from 'vue'
    import axios from 'axios'

    // Thiết lập token mặc định từ localStorage
    const token = localStorage.getItem('access_token')
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    }

    // Reactive
    const jobApplications = ref([])
    const pagination = ref({})
    const page = ref(1)
    const formOpen = ref(false)
    const detailApp = ref(null)
    const editApp = ref(null)
    const search = ref('')
    const perPage = ref(10)

    const image = (filePath) => (!filePath ? '#' : `/storage/${filePath}`)

    // Giai đoạn theo trạng thái
    const stageOptionsMap = {
        pending: [
            'new',
            'cv_screening',
            'phone_screen',
            'interview_scheduled'
        ],
        approved: [
            'interview_scheduled',
            'interviewed',
            'offer_made'
        ],
        hired: [
            'offer_accepted',
            'onboarding',
            'completed'
        ],
        rejected: [
            'new',
            'phone_screen',
            'interviewed',
            'offer_declined'
        ],
        cancelled: [
            'new'
        ],
        withdrawn: [
            'new'
        ],
        archived: [
            'completed'
        ]
    }


    // Danh sách stage khả dụng dựa vào status hiện tại
    const stageOptions = computed(() => {
        const selectedStatus = form.value.status || 'pending'
        return stageOptionsMap[selectedStatus] || []
    })

    // Form ứng tuyển
    const form = ref({
        job_id: '',
        user_id: '',
        company_id: '',
        image: '',
        cover_letter: '',
        status: 'pending',
        is_shortlisted: false,
        source: '',
        application_stage: 'new',
        interview_date: '',
        note: ''
    })

    // Tự động cập nhật application_stage nếu stage hiện tại không hợp lệ khi status thay đổi
    watch(() => form.value.status, (newStatus) => {
        const validStages = stageOptionsMap[newStatus] || []
        if (!validStages.includes(form.value.application_stage)) {
            form.value.application_stage = validStages.length > 0 ? validStages[0] : ''
        }
    })

    // Định dạng tên stage để hiển thị
    function formatStage(stage) {
        const labels = {
            new: 'Mới',
            cv_screening: 'Sàng lọc CV',
            phone_screen: 'Phỏng vấn qua điện thoại',
            interview_scheduled: 'Đã lên lịch phỏng vấn',
            interviewed: 'Đã phỏng vấn',
            offer_made: 'Gửi offer',
            offer_accepted: 'Chấp nhận offer',
            offer_declined: 'Từ chối offer',
            onboarding: 'Onboarding',
            completed: 'Hoàn tất'
        }
        return labels[stage] || stage
    }

    // Lấy danh sách đơn ứng tuyển
    const fetchList = async (gotoPage = page.value) => {
        try {
            const { data } = await axios.get('/api/job-applications', {
                params: {
                    page: gotoPage,
                    search: search.value,
                    per_page: perPage.value
                }
            })
            jobApplications.value = data.data
            pagination.value = data
            page.value = data.current_page
        } catch (err) {
            showAlertModal({
                title: 'Lỗi tải danh sách',
                message: 'Không thể tải dữ liệu. Vui lòng thử lại.',
                status: 'error',
                type: 'alert'
            })
        }
    }

    // Chuyển trang
    const changePage = (p) => fetchList(p)

    // Mở form tạo/sửa
    const openForm = (app = null) => {
        if (app) {
            editApp.value = app
            Object.assign(form.value, {
                id: app.id,
                job_id: app.job_id,
                user_id: app.user?.id,
                company_id: app.company?.id,
                company_name: app.company?.name,
                user_name: app.user?.name,
                job_title: app.job?.title,
                image: app.image,
                cover_letter: app.cover_letter,
                status: app.status,
                is_shortlisted: app.is_shortlisted,
                source: app.source,
                application_stage: app.application_stage,
                interview_date: app.interview_date,
                note: app.note
            })
        } else {
            editApp.value = null
            Object.assign(form.value, {
                job_id: '',
                user_id: '',
                company_id: '',
                image: '',
                cover_letter: '',
                status: 'pending',
                is_shortlisted: false,
                source: '',
                application_stage: stageOptionsMap['pending'][0] || '',
                interview_date: '',
                note: ''
            })
        }
        formOpen.value = true
    }

    // Đóng form
    const closeForm = () => {
        formOpen.value = false
    }

    // Lưu đơn ứng tuyển
    const save = async () => {
        try {
            if (editApp.value) {
                await axios.put(`/api/job-applications/${editApp.value.id}`, form.value)
                showAlertModal({
                    title: 'Cập nhật thành công',
                    message: `Đơn ứng tuyển #${editApp.value.id} đã được cập nhật.`,
                    status: 'success',
                    type: 'alert'
                })
            } else {
                await axios.post('/api/job-applications', form.value)
                showAlertModal({
                    title: 'Tạo mới thành công',
                    message: `Đơn ứng tuyển mới đã được thêm.`,
                    status: 'success',
                    type: 'alert'
                })
            }
            formOpen.value = false
            fetchList()
        } catch (error) {
            showAlertModal({
                title: 'Lỗi',
                message: error?.response?.data?.message || 'Đã xảy ra lỗi khi lưu.',
                status: 'error',
                type: 'alert'
            })
        }
    }

    // Xoá đơn ứng tuyển
    const remove = async (id) => {
        showAlertModal({
            title: 'Xác nhận xoá',
            message: `Bạn có chắc chắn muốn xoá đơn ứng tuyển #${id}?`,
            type: 'confirm',
            status: 'warning',
            onConfirm: async () => {
                try {
                    await axios.delete(`/api/job-applications/${id}`)
                    fetchList()
                    showAlertModal({
                        title: 'Đã xoá',
                        message: `Đơn ứng tuyển #${id} đã được xoá.`,
                        status: 'success',
                        type: 'alert'
                    })
                } catch (err) {
                    showAlertModal({
                        title: 'Lỗi khi xoá',
                        message: err?.response?.data?.message || 'Không thể xoá đơn ứng tuyển.',
                        status: 'error',
                        type: 'alert'
                    })
                }
            }
        })
    }

    // Xem chi tiết
    const showDetail = (app) => {
        detailApp.value = app
    }

    // Định dạng ngày
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
        const d = new Date(datetime)
        return d.toLocaleString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        })
    }

    // Fetch lần đầu
    onMounted(() => fetchList())
</script>