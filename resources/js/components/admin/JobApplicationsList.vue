<template>
  <div class="container my-5">
    <h3 class="text-center fw-bold display-5 text-primary mb-4">Quản lý đơn ứng tuyển</h3>

    <!-- Bộ lọc, tìm kiếm, phân trang -->
    <div class="card shadow-sm rounded mb-4">
      <div class="card-body">
        <div class="row g-3 align-items-center">
          <div class="col-md-5">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
              </span>
              <input
                v-model="search"
                @input="changePage(1)"
                class="form-control border-start-0"
                placeholder="Tìm theo tên ứng viên hoặc công ty..."
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-funnel-fill"></i>
              </span>
              <select v-model="filter" @change="changePage(1)" class="form-select border-start-0">
                <option value="">Tất cả trạng thái</option>
                <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-list-ol"></i>
              </span>
              <select v-model.number="perPage" @change="changePage(1)" class="form-select border-start-0">
                <option value="10">Hiển thị 10</option>
                <option value="20">Hiển thị 20</option>
                <option value="50">Hiển thị 50</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading spinner -->
    <div v-if="loading" class="d-flex justify-content-center align-items-center my-5">
      <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
        <span class="visually-hidden">Đang tải...</span>
      </div>
    </div>

    <!-- Bảng dữ liệu -->
    <div v-else>
      <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle mb-0">
          <thead class="table-light text-center">
            <tr>
              <th>ID</th>
              <th>Ứng viên</th>
              <th>Công việc</th>
              <th>Công ty</th>
              <th>Email</th>
              <th>CV</th>
              <th>Trạng thái</th>
              <th>Ghi chú</th>
              <th style="min-width: 230px;">Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="app in applications" :key="app.id">
              <td class="text-center">{{ app.id }}</td>
              <td>{{ app.user?.name || 'N/A' }}</td>
              <td>{{ app.job?.title || 'N/A' }}</td>
              <td>{{ app.company?.name || 'N/A' }}</td>
              <td>{{ app.email }}</td>
              <td class="text-center">
                <a
                  v-if="app.cv_url"
                  :href="app.cv_url"
                  target="_blank"
                  class="btn btn-sm btn-outline-primary"
                  title="Tải CV"
                >
                  <i class="bi bi-download"></i>
                </a>
                <span v-else class="text-muted">Không có</span>
              </td>
              <td class="text-center">
                <span class="badge bg-secondary">{{ statuses[app.status] || 'Không rõ' }}</span>
              </td>
              <td :title="app.note">{{ app.note?.length > 20 ? app.note.slice(0, 20) + '...' : app.note }}</td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <button
                    class="btn btn-secondary btn-sm action-btn"
                    @click="openViewDetail(app)"
                    title="Xem chi tiết"
                    type="button"
                  >
                    <i class="bi bi-eye"></i>
                    <span class="ms-1 d-none d-md-inline">Xem</span>
                  </button>

                  <button
                    class="btn btn-info btn-sm action-btn"
                    @click="openDetail(app)"
                    title="Chi tiết & Sửa"
                    type="button"
                  >
                    <i class="bi bi-pencil-square"></i>
                    <span class="ms-1 d-none d-md-inline">Sửa</span>
                  </button>

                  <button
                    class="btn btn-danger btn-sm action-btn"
                    @click="confirmDelete(app)"
                    title="Xóa"
                    type="button"
                  >
                    <i class="bi bi-trash"></i>
                    <span class="ms-1 d-none d-md-inline">Xóa</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="applications.length === 0">
              <td colspan="9" class="text-center text-muted py-3">Không có dữ liệu</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Phân trang -->
      <div class="d-flex justify-content-between align-items-center mt-3 px-2">
        <div class="text-muted small">
          Hiển thị {{ startEntry }}–{{ endEntry }} / {{ total }} đơn
        </div>
        <nav v-if="totalPages > 1" aria-label="Page navigation">
          <ul class="pagination mb-0">
            <li class="page-item" :class="{ disabled: page === 1 }">
              <button class="page-link" @click="changePage(page - 1)" :disabled="page === 1">«</button>
            </li>

            <li
              v-for="p in pageNumbersToShow"
              :key="p"
              class="page-item"
              :class="{ active: page === p }"
            >
              <button class="page-link" @click="changePage(p)">{{ p }}</button>
            </li>

            <li class="page-item" :class="{ disabled: page === totalPages }">
              <button class="page-link" @click="changePage(page + 1)" :disabled="page === totalPages">»</button>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Modal chi tiết & chỉnh sửa -->
    <div
      class="modal fade"
      id="detailModal"
      tabindex="-1"
      aria-labelledby="detailModalLabel"
      aria-hidden="true"
      ref="detailModal"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form @submit.prevent="submitUpdate">
            <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">Chi tiết đơn ứng tuyển #{{ selectedApplication?.id }}</h5>
              <button type="button" class="btn-close" @click="closeDetail" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div v-if="selectedApplication">
                <div class="mb-3 row">
                  <label class="col-sm-3 col-form-label">Ứng viên:</label>
                  <div class="col-sm-9">{{ selectedApplication.user?.name || 'N/A' }}</div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-3 col-form-label">Công việc:</label>
                  <div class="col-sm-9">{{ selectedApplication.job?.title || 'N/A' }}</div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-3 col-form-label">Công ty:</label>
                  <div class="col-sm-9">{{ selectedApplication.company?.name || 'N/A' }}</div>
                </div>
                <div class="mb-3 row">
                  <label for="status" class="col-sm-3 col-form-label">Trạng thái:</label>
                  <div class="col-sm-9">
                    <select v-model="form.status" id="status" class="form-select" required>
                      <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
                    </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="note" class="col-sm-3 col-form-label">Ghi chú:</label>
                  <div class="col-sm-9">
                    <textarea v-model="form.note" id="note" class="form-control" rows="3" placeholder="Nhập ghi chú..."></textarea>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="interview_date" class="col-sm-3 col-form-label">Ngày phỏng vấn:</label>
                  <div class="col-sm-9">
                    <input type="datetime-local" v-model="form.interview_date" id="interview_date" class="form-control" />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="is_shortlisted" class="col-sm-3 col-form-label">Đã chọn lọc:</label>
                  <div class="col-sm-9">
                    <input type="checkbox" v-model="form.is_shortlisted" id="is_shortlisted" />
                  </div>
                </div>
              </div>
              <div v-else class="text-center text-muted">Đang tải chi tiết...</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeDetail">Đóng</button>
              <button type="submit" class="btn btn-primary" :disabled="saving">
                <span v-if="saving" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Lưu thay đổi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal xem chi tiết riêng -->
    <div
      class="modal fade"
      id="viewDetailModal"
      tabindex="-1"
      aria-labelledby="viewDetailModalLabel"
      aria-hidden="true"
      ref="viewDetailModal"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewDetailModalLabel">Chi tiết đơn ứng tuyển #{{ selectedApplication?.id }}</h5>
            <button type="button" class="btn-close" @click="closeViewDetail" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div v-if="selectedApplication">
              <p><strong>Ứng viên:</strong> {{ selectedApplication.user?.name || 'N/A' }}</p>
              <p><strong>Công việc:</strong> {{ selectedApplication.job?.title || 'N/A' }}</p>
              <p><strong>Công ty:</strong> {{ selectedApplication.company?.name || 'N/A' }}</p>
              <p><strong>Email:</strong> {{ selectedApplication.email }}</p>
              <p><strong>Trạng thái:</strong> {{ statuses[selectedApplication.status] || 'Không rõ' }}</p>
              <p><strong>Ghi chú:</strong> {{ selectedApplication.note || '(Không có)' }}</p>
              <p><strong>Ngày phỏng vấn:</strong> {{ selectedApplication.interview_date || '(Chưa có)' }}</p>
              <p><strong>Đã chọn lọc:</strong> {{ selectedApplication.is_shortlisted ? 'Có' : 'Không' }}</p>
              <p>
                <strong>CV:</strong>
                <a
                  v-if="selectedApplication.cv_url"
                  :href="selectedApplication.cv_url"
                  target="_blank"
                  class="btn btn-sm btn-outline-primary"
                >
                  Tải CV
                </a>
                <span v-else class="text-muted">Không có</span>
              </p>
            </div>
            <div v-else class="text-center text-muted">Đang tải chi tiết...</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeViewDetail">Đóng</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue'
import axios from 'axios'
import * as bootstrap from 'bootstrap'

const showAlertModal = window.showAlertModal

const applications = ref([])
const total = ref(0)
const loading = ref(false)

const search = ref('')
const filter = ref('')
const page = ref(1)
const perPage = ref(10)

const selectedApplication = ref(null)
const saving = ref(false)
const deleting = ref(false)

const statuses = {
  pending: 'Chờ xử lý',
  viewed: 'Đã xem',
  under_review: 'Đang đánh giá',
  rejected: 'Đã loại',
  contacting: 'Đang liên hệ',
  interview_scheduled: 'Mời phỏng vấn',
  interviewed: 'Đã phỏng vấn',
  offered: 'Trúng tuyển',
  hired: 'Nhận việc',
  candidate_declined: 'Ứng viên từ chối',
  no_response: 'Không phản hồi',
  saved: 'Đã lưu hồ sơ',
}

const form = ref({
  status: '',
  note: '',
  interview_date: '',
  is_shortlisted: false,
})

let detailModalInstance = null
let viewDetailModalInstance = null

const fetchApplications = async () => {
  loading.value = true
  try {
    const res = await axios.get('/api/admin/job-applications', {
      params: {
        per_page: perPage.value,
        page: page.value,
        status: filter.value || undefined,
        search: search.value.trim() || undefined,
      },
    })
    applications.value = res.data.data
    total.value = res.data.total
  } catch (err) {
    console.error('Lỗi khi tải:', err)
    showAlertModal({
      title: 'Lỗi',
      message: 'Không tải được danh sách đơn ứng tuyển.',
      type: 'alert',
      status: 'danger',
    })
  } finally {
    loading.value = false
  }
}

const totalPages = computed(() => Math.ceil(total.value / perPage.value))
const startEntry = computed(() => (total.value === 0 ? 0 : (page.value - 1) * perPage.value + 1))
const endEntry = computed(() => Math.min(startEntry.value + applications.value.length - 1, total.value))

const changePage = (newPage) => {
  if (newPage >= 1 && newPage <= totalPages.value) {
    page.value = newPage
  }
}

const pageNumbersToShow = computed(() => {
  const maxPages = 7
  const pages = []
  let start = Math.max(1, page.value - Math.floor(maxPages / 2))
  let end = start + maxPages - 1
  if (end > totalPages.value) {
    end = totalPages.value
    start = Math.max(1, end - maxPages + 1)
  }
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  return pages
})

const openDetail = async (app) => {
  selectedApplication.value = null
  form.value = {
    status: '',
    note: '',
    interview_date: '',
    is_shortlisted: false,
  }

  await nextTick()

  const el = document.getElementById('detailModal')
  if (!el) {
    console.error('Không tìm thấy phần tử modal detailModal')
    return
  }

  if (!detailModalInstance) detailModalInstance = new bootstrap.Modal(el)
  detailModalInstance.show()

  try {
    const res = await axios.get(`/api/admin/job-applications/${app.id}`)
    selectedApplication.value = res.data
    form.value.status = selectedApplication.value.status || ''
    form.value.note = selectedApplication.value.note || ''
    form.value.interview_date = selectedApplication.value.interview_date
      ? selectedApplication.value.interview_date.slice(0, 16)
      : ''
    form.value.is_shortlisted = selectedApplication.value.is_shortlisted || false
  } catch (err) {
    console.error('Lỗi khi lấy chi tiết:', err)
    showAlertModal({
      title: 'Lỗi',
      message: 'Không tải được chi tiết đơn ứng tuyển.',
      type: 'alert',
      status: 'danger',
    })
  }
}

const closeDetail = () => {
  if (detailModalInstance) detailModalInstance.hide()
  selectedApplication.value = null
}

const openViewDetail = async (app) => {
  selectedApplication.value = null

  await nextTick()

  const el = document.getElementById('viewDetailModal')
  if (!el) {
    console.error('Không tìm thấy phần tử modal viewDetailModal')
    return
  }

  if (!viewDetailModalInstance) viewDetailModalInstance = new bootstrap.Modal(el)
  viewDetailModalInstance.show()

  try {
    const res = await axios.get(`/api/admin/job-applications/${app.id}`)
    selectedApplication.value = res.data
  } catch (err) {
    console.error('Lỗi khi lấy chi tiết:', err)
    showAlertModal({
      title: 'Lỗi',
      message: 'Không tải được chi tiết đơn ứng tuyển.',
      type: 'alert',
      status: 'danger',
    })
  }
}

const closeViewDetail = () => {
  if (viewDetailModalInstance) viewDetailModalInstance.hide()
  selectedApplication.value = null
}

const submitUpdate = async () => {
  if (!selectedApplication.value) return
  saving.value = true
  try {
    await axios.put(`/api/admin/job-applications/${selectedApplication.value.id}`, {
      status: form.value.status,
      note: form.value.note,
      interview_date: form.value.interview_date,
      is_shortlisted: form.value.is_shortlisted,
    })
    showAlertModal({
      title: 'Thành công',
      message: 'Cập nhật đơn ứng tuyển thành công!',
      type: 'alert',
      status: 'success',
    })
    closeDetail()
    fetchApplications()
  } catch (err) {
    console.error('Lỗi cập nhật:', err)
    showAlertModal({
      title: 'Lỗi',
      message: 'Cập nhật đơn ứng tuyển thất bại!',
      type: 'alert',
      status: 'danger',
    })
  } finally {
    saving.value = false
  }
}

const confirmDelete = (app) => {
  selectedApplication.value = app
  showAlertModal({
    title: 'Xác nhận xóa',
    message: `Bạn có chắc chắn muốn xóa đơn ứng tuyển #${app.id} không?`,
    type: 'confirm',
    status: 'warning',
    onConfirm: deleteApplication,
  })
}

const deleteApplication = async () => {
  if (!selectedApplication.value) return
  deleting.value = true
  try {
    await axios.delete(`/api/admin/job-applications/${selectedApplication.value.id}`)
    showAlertModal({
      title: 'Thành công',
      message: 'Xóa đơn ứng tuyển thành công!',
      type: 'alert',
      status: 'success',
    })
    fetchApplications()
  } catch (err) {
    console.error('Lỗi xóa:', err)
    showAlertModal({
      title: 'Lỗi',
      message: 'Xóa đơn ứng tuyển thất bại!',
      type: 'alert',
      status: 'danger',
    })
  } finally {
    deleting.value = false
    selectedApplication.value = null
  }
}

watch([search, filter, perPage], () => {
  page.value = 1
  fetchApplications()
})

watch(page, fetchApplications)

onMounted(fetchApplications)
</script>

<style scoped>
.table td,
.table th {
  vertical-align: middle;
}

.table thead th {
  white-space: nowrap;
}

/* Nút hành động đều, cùng kích thước */
.action-btn {
  min-width: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
  white-space: nowrap;
}

.action-btn i {
  font-size: 1.1rem;
}

/* Responsive: ẩn text trên màn hình nhỏ */
@media (max-width: 576px) {
  .action-btn span {
    display: none;
  }
}

/* Nút Xem */
.btn-secondary.action-btn {
  background-color: #6c757d;
  border-color: #6c757d;
  color: white;
}

.btn-secondary.action-btn:hover {
  background-color: #5a6268;
  border-color: #545b62;
}

/* Nút Sửa */
.btn-info.action-btn {
  background-color: #0d6efd;
  border-color: #0d6efd;
  color: white;
}

.btn-info.action-btn:hover {
  background-color: #0b5ed7;
  border-color: #0a58ca;
}

/* Nút Xóa */
.btn-danger.action-btn {
  background-color: #dc3545;
  border-color: #dc3545;
  color: white;
}

.btn-danger.action-btn:hover {
  background-color: #bb2d3b;
  border-color: #b02a37;
}
</style>
