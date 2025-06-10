<template>
    <div class="container py-4">
        <h2 class="h3 mb-4"><i class="bi bi-receipt"></i> Danh sách hóa đơn</h2>

        <!-- Bộ lọc -->
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

        <!-- Bảng hóa đơn -->
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
                            <span class="badge" :class="{
                  'bg-success': invoice.status === 'paid',
                  'bg-warning text-dark': invoice.status === 'pending',
                  'bg-danger': invoice.status === 'failed'
                }">
                                {{ translateStatus(invoice.status) }}
                            </span>
                        </td>
                        <td>{{ formatDate(invoice.paid_at) }}</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm" @click="viewInvoice(invoice.id)"
                                data-bs-toggle="modal" data-bs-target="#invoiceModal">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <nav class="mt-4 d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                    <button class="page-link" @click="changePage(pagination.current_page - 1)">Trang trước</button>
                </li>
                <li v-for="page in pagination.last_page" :key="page" class="page-item"
                    :class="{ active: page === pagination.current_page }">
                    <button class="page-link" @click="changePage(page)">{{ page }}</button>
                </li>
                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                    <button class="page-link" @click="changePage(pagination.current_page + 1)">Trang sau</button>
                </li>
            </ul>
        </nav>

        <!-- Modal xem chi tiết -->
        <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel">Chi tiết hóa đơn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" ref="modalContentRef">
                        <div v-if="loadingDetail" class="text-muted">Đang tải chi tiết...</div>

                        <div v-else-if="selectedInvoice">
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Số hóa đơn:</div>
                                <div class="col">{{ selectedInvoice.invoice_number }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Gói:</div>
                                <div class="col">{{ selectedInvoice.package?.name || 'Không xác định' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Số tiền:</div>
                                <div class="col">{{ formatCurrency(selectedInvoice.amount) }} {{
                                    selectedInvoice.currency }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Trạng thái:</div>
                                <div class="col">{{ translateStatus(selectedInvoice.status) }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Phương thức:</div>
                                <div class="col">{{ selectedInvoice.payment_method || '---' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Gateway:</div>
                                <div class="col">{{ selectedInvoice.payment_gateway || '---' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Thanh toán:</div>
                                <div class="col">{{ formatDate(selectedInvoice.paid_at) }}</div>
                            </div>
                        </div>

                        <div v-else class="text-danger">Không tìm thấy hóa đơn.</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" @click="downloadInvoicePdf"
                            :disabled="!selectedInvoice">
                            <i class="bi bi-download me-1"></i> Tải PDF
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import axios from 'axios'

    // Thêm Bearer Token tự động từ localStorage
    axios.interceptors.request.use(config => {
        const token = localStorage.getItem('access_token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    })

    // State
    const invoices = ref([])
    const pagination = ref({ current_page: 1, last_page: 1, total: 0 })
    const perPage = ref(10)
    const statusFilter = ref('')

    const selectedInvoice = ref(null)
    const loadingDetail = ref(false)
    const modalContentRef = ref(null)

    // Lấy danh sách hóa đơn
    async function fetchInvoices(page = 1) {
        try {
            const res = await axios.get('/api/payments', {
                params: {
                    page,
                    per_page: perPage.value,
                    status: statusFilter.value
                }
            })
            invoices.value = res.data.data
            pagination.value = {
                current_page: res.data.current_page,
                last_page: res.data.last_page,
                total: res.data.total
            }
        } catch (error) {
            console.error(error)
        }
    }

    function changePage(page) {
        if (page >= 1 && page <= pagination.value.last_page) {
            fetchInvoices(page)
        }
    }

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

    function downloadInvoicePdf() {
        if (!selectedInvoice.value?.id) return
        const url = `/api/payments/${selectedInvoice.value.id}/pdf`
        window.open(url, '_blank')
    }

    onMounted(() => {
        fetchInvoices()
    })
</script>