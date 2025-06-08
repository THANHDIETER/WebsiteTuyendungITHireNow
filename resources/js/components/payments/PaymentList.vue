<template>
  <div class="container py-4">
    <h2 class="h3 mb-4"><i class="bi bi-receipt"></i> Danh sách hóa đơn</h2>

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
          <tr v-for="invoice in invoices" :key="invoice.id">
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
                {{ invoice.status }}
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

    <!-- Modal xem chi tiết -->
    <div
      class="modal fade"
      id="invoiceModal"
      tabindex="-1"
      aria-labelledby="invoiceModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invoiceModalLabel">Chi tiết hóa đơn</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body" ref="modalContentRef">
            <div v-if="loadingDetail" class="text-muted">Đang tải chi tiết...</div>

            <div v-else-if="selectedInvoice">
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Số hóa đơn:</div><div class="col">{{ selectedInvoice.invoice_number }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Gói:</div><div class="col">{{ selectedInvoice.package?.name || 'Không xác định' }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Số tiền:</div><div class="col">{{ formatCurrency(selectedInvoice.amount) }} {{ selectedInvoice.currency }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Trạng thái:</div><div class="col">{{ selectedInvoice.status }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Phương thức:</div><div class="col">{{ selectedInvoice.payment_method || '---' }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Gateway:</div><div class="col">{{ selectedInvoice.payment_gateway || '---' }}</div></div>
              <div class="row mb-2"><div class="col-sm-4 fw-bold">Thanh toán:</div><div class="col">{{ formatDate(selectedInvoice.paid_at) }}</div></div>
            </div>

            <div v-else class="text-danger">Không tìm thấy hóa đơn.</div>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-outline-success"
              @click="downloadInvoicePdf"
              :disabled="!selectedInvoice"
            >
              <i class="bi bi-download me-1"></i> Tải PDF
            </button>

            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Đóng
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const invoices = ref([])
const selectedInvoice = ref(null)
const loadingDetail = ref(false)
const modalContentRef = ref(null)

onMounted(async () => {
  const res = await axios.get('/api/payments')
  invoices.value = res.data
})

async function viewInvoice(id) {
  loadingDetail.value = true
  selectedInvoice.value = null
  try {
    const res = await axios.get(`/api/payments/${id}`)
    selectedInvoice.value = res.data
  } catch (err) {
    console.error(err)
    selectedInvoice.value = null
  } finally {
    loadingDetail.value = false
  }
}

function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN').format(amount)
}

function formatDate(dateStr) {
  if (!dateStr) return '---'
  return new Date(dateStr).toLocaleDateString('vi-VN')
}

function downloadInvoicePdf() {
  if (!selectedInvoice.value?.id) return
  const url = `/api/payments/${selectedInvoice.value.id}/pdf`
  window.open(url, '_blank')
}
</script>
