<template>
  <div class="container mb-5 bg-light rounded shadow-sm">
    <h3 class="text-center fw-bold display-5 text-primary">Danh sách đơn ứng tuyển</h3>

    <div class="card p-3 mb-4 shadow-sm border-0 rounded">
      <div class="row g-3 align-items-center">
        <div class="col-md-5">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input v-model="search" @input="changePage(1)" class="form-control shadow-sm border-start-0"
              placeholder="Tìm theo tên ứng viên hoặc công ty..." />
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel-fill"></i></span>
            <select v-model="filter" @change="changePage(1)" class="form-select shadow-sm border-start-0">
              <option value="">Tất cả trạng thái</option>
              <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-list-ol"></i></span>
            <select v-model.number="perPage" @change="changePage(1)" class="form-select shadow-sm border-start-0">
              <option value="10">Hiển thị 10</option>
              <option value="20">Hiển thị 20</option>
              <option value="50">Hiển thị 50</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="text-center text-muted fs-5 mb-3 py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Đang tải...</span>
      </div>
      <p class="mt-2">Đang tải dữ liệu...</p>
    </div>

    <div v-else class="table-responsive">
      <table class="table table-bordered table-hover align-middle shadow-sm rounded">
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
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="app in paginatedApplications" :key="app.id">
            <td class="text-center">{{ app.id }}</td>
            <td>{{ app.user?.name || 'N/A' }}</td>
            <td>{{ app.job?.title || 'N/A' }}</td>
            <td>{{ app.company?.name || 'N/A' }}</td>
            <td>{{ app.email }}</td>
            <td class="text-center">
              <a v-if="app.cv_url" :href="app.cv_url" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-download"></i>
              </a>
              <span v-else class="text-muted">Không có</span>
            </td>
            <td class="text-center">
              <span class="badge bg-secondary">{{ statuses[app.status] || 'Không rõ' }}</span>
            </td>
            <td>
              <span :title="app.note">{{ app.note?.slice(0, 20) }}{{ app.note?.length > 20 ? '...' : '' }}</span>
            </td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-info me-1" @click="openDetail(app)" title="Chi tiết">
                <i class="bi bi-eye-fill"></i>
              </button>
              <!-- Có thể thêm các hành động duyệt, từ chối -->
            </td>
          </tr>
          <tr v-if="paginatedApplications.length === 0">
            <td colspan="9" class="text-center text-muted">Không có dữ liệu</td>
          </tr>
        </tbody>
      </table>

      <div class="d-flex justify-content-between align-items-center px-2">
        <div class="text-muted small">
          Hiển thị {{ startEntry }}–{{ endEntry }} / {{ total }} đơn
        </div>
        <nav v-if="totalPages > 1">
          <ul class="pagination mb-0">
            <li class="page-item" :class="{ disabled: page === 1 }">
              <a class="page-link" href="#" @click.prevent="changePage(page - 1)">«</a>
            </li>
            <li class="page-item" v-for="p in totalPages" :key="p" :class="{ active: page === p }">
              <a class="page-link" href="#" @click.prevent="changePage(p)">{{ p }}</a>
            </li>
            <li class="page-item" :class="{ disabled: page === totalPages }">
              <a class="page-link" href="#" @click.prevent="changePage(page + 1)">»</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'

const applications = ref([])
const total = ref(0)
const loading = ref(false)

const search = ref('')
const filter = ref('')
const page = ref(1)
const perPage = ref(10)

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

const fetchApplications = async () => {
  loading.value = true
  try {
    const res = await axios.get('/api/job-applications', {
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
  } finally {
    loading.value = false
  }
}

const paginatedApplications = computed(() => applications.value)
const totalPages = computed(() => Math.ceil(total.value / perPage.value))
const startEntry = computed(() => (page.value - 1) * perPage.value + 1)
const endEntry = computed(() => Math.min(startEntry.value + applications.value.length - 1, total.value))

const changePage = (newPage) => {
  if (newPage >= 1 && newPage <= totalPages.value) {
    page.value = newPage
  }
}

const openDetail = (app) => {
  console.log('Xem chi tiết:', app)
  // bạn có thể mở modal chi tiết tại đây
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
</style>
