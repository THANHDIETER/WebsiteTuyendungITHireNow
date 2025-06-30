<template>
  <div class="container py-4">
    <h2 class="h3 mb-4">
      <i class="bi bi-receipt"></i> Danh sách hóa đơn
    </h2>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Trạng thái</label>
        <select class="form-select" v-model="statusFilter" @change="fetchInvoices(1)">
          <option value="">Tất cả</option>
          <option value="paid">Đã thanh toán</option>
          <option value="pending">Chờ xử lý</option>
          <option value="failed">Thất bại</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Số dòng mỗi trang</label>
        <select class="form-select" v-model="perPage" @change="fetchInvoices(1)">
          <option :value="10">10</option>
          <option :value="20">20</option>
          <option :value="50">50</option>
          <option :value="100">100</option>
        </select>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Mã hóa đơn</th>
            <th>Gói</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Chi tiết</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loadingList">
            <td colspan="6" class="text-center text-muted py-4">
              <div class="spinner-border text-primary" role="status"></div>
            </td>
          </tr>
          <tr v-else-if="invoices.length === 0">
            <td colspan="6" class="text-center text-muted py-3">Không có hóa đơn nào.</td>
          </tr>
          <tr v-else v-for="invoice in invoices" :key="invoice.id">
            <td class="fw-monospace text-primary">{{ invoice.invoice_number }}</td>
            <td>{{ invoice.package?.name }}</td>
            <td class="text-success fw-semibold">
              {{ formatCurrency(invoice.amount) }} {{ invoice.currency }}
            </td>
            <td>
              <span
                class="badge"
                :class="{
                  'bg-success': invoice.status === 'paid',
                  'bg-warning text-dark': invoice.status === 'pending',
                  'bg-danger': invoice.status === 'failed'
                }"
              >
                {{ translateStatus(invoice.status) }}
              </span>
            </td>
            <td>{{ formatDate(invoice.paid_at) }}</td>
            <td>
              <button
                class="btn btn-outline-primary btn-sm"
                @click="viewInvoice(invoice.id)"
                data-bs-toggle="modal"
                data-bs-target="#invoiceModal"
              >
                Xem chi tiết
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <nav class="mt-4 d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
          <button class="page-link" @click="changePage(pagination.current_page - 1)">Trang trước</button>
        </li>
        <li
          v-for="page in pagination.last_page"
          :key="page"
          class="page-item"
          :class="{ active: page === pagination.current_page }"
        >
          <button class="page-link" @click="changePage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
          <button class="page-link" @click="changePage(pagination.current_page + 1)">Trang sau</button>
        </li>
      </ul>
    </nav>

    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invoiceModalLabel">Chi tiết hóa đơn</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body" ref="modalContentRef">
            <div v-if="loadingDetail" class="text-muted">
              <div class="spinner-border text-primary me-2" role="status"></div>
              Đang tải chi tiết...
            </div>

            <div v-else-if="selectedInvoice">
              <div class="row mb-2" v-for="(value, label) in invoiceFields" :key="label">
                <div class="col-sm-4 fw-bold">{{ label }}</div>
                <div class="col">{{ value }}</div>
              </div>
            </div>

            <div v-else class="text-danger">Không tìm thấy hóa đơn.</div>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-outline-success"
              @click="downloadInvoicePdf"
              :disabled="!selectedInvoice || loadingDownload"
            >
              <span v-if="loadingDownload" class="spinner-border spinner-border-sm me-1"></span>
              <i v-else class="bi bi-download me-1"></i>
              Tải PDF
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

axios.interceptors.request.use(config => {
  const token = localStorage.getItem('access_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

const invoices = ref([])
const pagination = ref({ current_page: 1, last_page: 1, total: 0 })
const perPage = ref(10)
const statusFilter = ref('')

const selectedInvoice = ref(null)
const loadingDetail = ref(false)
const loadingList = ref(false)
const loadingDownload = ref(false)

async function fetchInvoices(page = 1) {
  loadingList.value = true
  try {
    const { data } = await axios.get('/api/payments', {
      params: { page, per_page: perPage.value, status: statusFilter.value }
    })
    invoices.value = data.data
    pagination.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      total: data.total
    }
  } catch (e) {
    console.error(e)
  } finally {
    loadingList.value = false
  }
}

function changePage(page) {
  if (page >= 1 && page <= pagination.value.last_page) fetchInvoices(page)
}

async function viewInvoice(id) {
  loadingDetail.value = true
  selectedInvoice.value = null
  try {
    const { data } = await axios.get(`/api/payments/${id}`)
    selectedInvoice.value = data
  } catch (e) {
    console.error(e)
  } finally {
    loadingDetail.value = false
  }
}

const invoiceFields = computed(() => {
  if (!selectedInvoice.value) return {}
  return {
    'Số hóa đơn': selectedInvoice.value.invoice_number,
    'Gói': selectedInvoice.value.package?.name || 'Không xác định',
    'Số tiền': `${formatCurrency(selectedInvoice.value.amount)} ${selectedInvoice.value.currency}`,
    'Trạng thái': translateStatus(selectedInvoice.value.status),
    'Cổng thanh toán': selectedInvoice.value.payment_gateway || '---',
    'Thanh toán lúc': formatDate(selectedInvoice.value.paid_at)
  }
})

function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN').format(amount)
}

function formatDate(dateStr) {
  if (!dateStr) return '---'
  const d = new Date(dateStr)
  const day = `${d.getDate()}`.padStart(2, '0')
  const month = `${d.getMonth() + 1}`.padStart(2, '0')
  const year = d.getFullYear()
  return `${day}/${month}/${year}`
}

function translateStatus(status) {
  switch (status) {
    case 'paid':
      return 'Đã thanh toán'
    case 'pending':
      return 'Chờ xử lý'
    case 'failed':
      return 'Thất bại'
    default:
      return status
  }
}

async function downloadInvoicePdf() {
  if (!selectedInvoice.value?.id) return
  loadingDownload.value = true
  try {
    const { data } = await axios.get(`/api/payments/${selectedInvoice.value.id}/pdf`, {
      responseType: 'blob'
    })
    const blob = new Blob([data], { type: 'application/pdf' })
    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = `HoaDon-${selectedInvoice.value.invoice_number}.pdf`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    URL.revokeObjectURL(url)
  } catch (e) {
    console.error(e)
  } finally {
    loadingDownload.value = false
  }
}

onMounted(() => fetchInvoices())
</script>

<style scoped>
.table td,
.table th {
  vertical-align: middle;
}
</style>
