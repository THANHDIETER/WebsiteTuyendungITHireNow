<template>
  <section class="bg-light py-2">
    <div class="container">
      <!-- Header -->
      <div class="d-flex align-items-center justify-content-between mb-4 section-header animate-fadeInUp">
        <h4 class="fw-bold text-primary mb-0 section-title">
          <i class="bi bi-briefcase-fill me-2"></i> Việc làm tốt nhất
        </h4>
        <a href="/cong-viec" class="btn btn-sm btn-outline-primary rounded-pill px-3 section-btn">
          Xem tất cả <i class="bi bi-arrow-right-circle ms-1"></i>
        </a>
      </div>

      <!-- Bộ lọc Location -->
      <div class="d-flex flex-wrap gap-2 mb-4">
        <button
          v-for="loc in locations"
          :key="loc.id"
          @click="filterByLocation(loc.id)"
          class="btn rounded-pill btn-sm fw-semibold px-3"
          :class="selectedLocation === loc.id ? 'btn-primary text-white shadow' : 'btn-outline-primary'">
          <i class="bi bi-geo-alt-fill me-1"></i> {{ loc.name }}
        </button>

        <button
          @click="filterByLocation(null)"
          class="btn rounded-pill btn-sm fw-semibold px-3"
          :class="!selectedLocation ? 'btn-secondary text-white shadow' : 'btn-outline-secondary'">
          Tất cả
        </button>
      </div>

      <!-- Job Cards -->
      <div class="row g-3">
        <!-- Loading -->
        <div v-if="loading" class="col-12 text-center text-muted py-5">
          <div class="spinner-border text-primary mb-3" role="status"></div>
          <p>Đang tải việc làm...</p>
        </div>

        <!-- Có dữ liệu -->
        <div v-else-if="jobs.length" v-for="job in jobs" :key="job.id" class="col-12 col-md-6 col-lg-4 mt-3">
          <div class="card h-100 border-0 shadow-sm rounded-3 p-3 position-relative job-card"
               data-bs-toggle="tooltip"
               data-bs-html="true"
               :title="tooltipContent(job)">
            
            <!-- Featured -->
            <span v-if="job.is_featured"
              class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill shadow-sm small">
              <i class="bi bi-fire me-1"></i> HOT
            </span>

            <div class="d-flex flex-column h-100">
              <!-- Logo -->
              <div class="text-center mb-3">
                <a :href="`/cong-viec/${job.slug}`" class="d-inline-block" style="width:55px; height:55px;">
                  <img
                    :src="job.company?.logo_url ? `/storage/${job.company.logo_url}` : '/default-logo.png'"
                    :alt="job.company?.name || 'Company Logo'"
                    class="img-fluid rounded-circle border p-1 bg-white shadow-sm"
                    style="width:100%; height:100%; object-fit:contain;" loading="lazy">
                </a>
              </div>

              <!-- Title -->
              <h6 class="fw-semibold mb-1 small text-truncate">
                <a :href="`/cong-viec/${job.slug}`"
                   class="text-decoration-none text-dark">
                  {{ job.title }}
                </a>
              </h6>

              <!-- Company -->
              <div class="text-muted small mb-1">
                <i class="bi bi-building me-1"></i> {{ job.company?.name || 'Công ty không xác định' }}
              </div>

              <!-- Salary -->
              <div class="fw-semibold text-success small mb-1">
                <i class="bi bi-cash-stack me-1"></i>
                <span v-if="job.salary_negotiable">Thỏa thuận</span>
                <span v-else>
                  {{ formatSalary(job.salary_min) }} - {{ formatSalary(job.salary_max) }} {{ job.currency }}
                </span>
              </div>
                                          <div class="d-flex justify-content-between align-items-center small">

              <!-- Location -->
              <div class="text-muted small mb-2">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                {{ job.location?.name || 'Không rõ địa chỉ' }}
              </div>

              <!-- Favorite -->
              <div class="mt-auto text-end" v-if="userRole === 'job_seeker'">
              <!--   <hr class="my-2"> -->
                <button type="button"
                        class="btn btn-sm rounded-circle save-job-btn"
                        :disabled="favoriteLoading"
                        :class="job.is_favorited ? 'btn-danger' : 'btn-outline-secondary'"
                        @click="toggleFavorite(job)">
                  <i class="bi" :class="job.is_favorited ? 'bi-heart-fill' : 'bi-heart'"></i>
                </button>
              </div>
                                          </div>

            </div>
          </div>
        </div>

        <!-- Không có dữ liệu -->
        <div v-else class="col-12 text-center text-muted py-5">
          <i class="bi bi-emoji-frown fs-1 d-block mb-2"></i>
          Không có việc làm nào được hiển thị.
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-4 d-flex justify-content-center align-items-center gap-2" v-if="lastPage > 1">
        <!-- Prev -->
        <button class="btn btn-outline-success pagination-btn"
                :disabled="currentPage === 1"
                @click="fetchJobs(currentPage - 1)">
          <i class="bi bi-chevron-left"></i>
        </button>

        <!-- Page info -->
        <span class="fw-semibold small">
          <span class="text-success">{{ currentPage }}</span>
          <span class="text-muted"> / {{ lastPage }} trang</span>
        </span>

        <!-- Next -->
        <button class="btn btn-outline-success pagination-btn"
                :disabled="currentPage === lastPage"
                @click="fetchJobs(currentPage + 1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div ref="toastEl" class="toast align-items-center text-bg-primary border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body">{{ toastMessage }}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import * as bootstrap from 'bootstrap'

const jobs = ref([])
const currentPage = ref(1)
const lastPage = ref(1)
const locations = ref([])
const selectedLocation = ref(null)
const loading = ref(true)
const userRole = document.getElementById("vue-wrapper")?.dataset.userRole || null;
console.log("User Role:", userRole);
const favoriteLoading = ref(false)

// toast
const toastEl = ref(null)
const toastMessage = ref("")
let toastInstance = null

const showToast = (msg) => {
  toastMessage.value = msg
  if (!toastInstance && toastEl.value) {
    toastInstance = new bootstrap.Toast(toastEl.value)
  }
  toastInstance?.show()
}

const fetchJobs = async (page = 1) => {
  loading.value = true
  try {
    const { data } = await axios.get('/api/jobs', {
      params: { location: selectedLocation.value, page }
    })
    jobs.value = data.data
    currentPage.value = data.current_page
    lastPage.value = data.last_page

    nextTick(() => initTooltips())
  } finally {
    loading.value = false
  }
}

const fetchLocations = async () => {
  const { data } = await axios.get('/api/locations')
  locations.value = data
}

const filterByLocation = (id) => {
  selectedLocation.value = id
  fetchJobs(1)
}

const truncate = (str, n) => str?.length > n ? str.substr(0, n) + '...' : str
const formatSalary = (num) => new Intl.NumberFormat().format(num)

const stripHtml = (html) => {
  let doc = new DOMParser().parseFromString(html, "text/html");
  return doc.body.textContent || "";
}

const tooltipContent = (job) => {
  return `
    <div class="tooltip-header"><i class="bi bi-briefcase-fill text-primary me-1"></i> ${job.title}</div>
    <hr class="my-1">
    <div class="tooltip-body">${truncate(stripHtml(job.description), 200)}</div>
  `
}

const toggleFavorite = async (job) => {
  try {
    const data = await window.handleFavorite(job.id)
    if (typeof data.favorited !== 'undefined') {
      job.is_favorited = data.favorited
    }
    if (data.message) showToast(data.message)

    // 🔥 cập nhật jobs trong mảng (đảm bảo Vue reactive)
    jobs.value = jobs.value.map(j =>
      j.id === job.id ? { ...j, is_favorited: job.is_favorited } : j
    )

  } catch (err) {
    showToast(err.message || "Có lỗi xảy ra", "error")
  }
}



const initTooltips = () => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  tooltipTriggerList.forEach(el => {
    new bootstrap.Tooltip(el)
  })
}

onMounted(() => {
  fetchJobs()
  fetchLocations()
})
</script>

<style scoped>
/* Tooltip đẹp */
.tooltip-inner {
  max-width: 340px;
  text-align: left;
  background: #fff !important;
  color: #333 !important;
  border: 1px solid #e0e0e0;
  padding: 10px 14px;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  font-size: 0.85rem;
  line-height: 1.45;
}
.tooltip.show .tooltip-inner { opacity: 1; }

.tooltip-header {
  font-weight: 600;
  font-size: 0.9rem;
  color: #0d6efd;
  margin-bottom: 4px;
}
.tooltip-body { font-size: 0.82rem; color: #555; }
.tooltip .tooltip-arrow::before {
  border-top-color: #fff !important;
  border-bottom-color: #fff !important;
}

/* Job Card hover */
.job-card { transition: all 0.25s ease; font-size: 0.9rem; }
.job-card:hover { transform: translateY(-4px); box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1); }
.job-card h6 { font-size: 0.95rem; }

/* Pagination buttons */
.pagination-btn {
  width: 36px;
  height: 36px;
  border-radius: 50% !important;
  display: flex; align-items: center; justify-content: center;
  padding: 0;
}

/* Header title animation */
.section-title::after {
  content: ""; display: block; width: 50px; height: 3px;
  background: linear-gradient(90deg,#0d6efd,#6610f2);
  margin: 6px auto 0; border-radius: 2px;
  animation: growLine 1s ease forwards;
}
@keyframes growLine { from { width: 0; opacity: 0; } to { width: 50px; opacity: 1; } }

.section-btn { transition: all 0.3s ease; }
.section-btn:hover { transform: translateX(4px); }

/* Fade In Up animation */
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
.animate-fadeInUp { animation: fadeInUp 0.8s ease both; }
</style>
