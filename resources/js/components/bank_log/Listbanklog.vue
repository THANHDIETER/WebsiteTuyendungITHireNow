<template>
  <div class="ms-2">
    <h4 class="mb-4  text-primary fw-bold"> Giao dịch theo từng tài khoản</h4>

    <div
      v-for="account in bankAccounts"
      :key="account.id"
      class="mb-5 p-4 border rounded shadow bg-white animate__animated animate__fadeIn"
    >
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="text-dark mb-0">🏦 {{ account.bank.toUpperCase() }}</h5>
          <small class="text-muted">Số tài khoản: {{ account.account_number }}</small>
        </div>
        <button
          class="btn btn-sm btn-outline-primary px-3"
          @click="toggleCard(account.id)"
        >
          {{ cardStates[account.id]?.opened ? 'Ẩn giao dịch' : 'Xem giao dịch' }}
        </button>
      </div>

      <!-- Nội dung card -->
      <transition name="fade">
        <div v-if="cardStates[account.id]?.opened">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group input-group-sm me-2 w-50">
              <span class="input-group-text bg-light">🔍</span>
              <input
                v-model="cardStates[account.id].keyword"
                class="form-control"
                placeholder="Tìm kiếm mã GD, mô tả, loại..."
                @input="debouncedSearch(account.id)"
              />
            </div>
            <div>
              <select
                class="form-select form-select-sm w-auto"
                v-model="cardStates[account.id].perPage"
                @change="changePage(account.id, 1)"
              >
                <option :value="10">10 dòng</option>
                <option :value="20">20 dòng</option>
                <option :value="50">50 dòng</option>
                <option :value="100">100 dòng</option>
              </select>
            </div>
          </div>

          <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
              <tr class="text-center text-uppercase">
                <th>ID</th>
                <th>Mã GD</th>
                <th>Số tiền</th>
                <th>Thời gian</th>
                <th>Loại</th>
                <th>Mô tả</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!bankLogsMap[account.id]?.data?.length">
                <td colspan="6" class="text-center text-muted py-3">Không có giao dịch nào.</td>
              </tr>
              <tr v-for="log in bankLogsMap[account.id]?.data || []" :key="log.id">
                <td class="text-center text-dark">{{ log.id }}</td>
                <td class="text-center text-dark">{{ log.trans_id }}</td>
                <td :class="['text-center fw-bold', log.type === 'credit' ? 'text-success' : 'text-danger']">
                  {{ formatCurrency(log.amount) }}
                </td>
                <td class="text-center text-dark ">{{ formatTime(log.trans_time) }}</td>
                <td class="text-center text-dark">{{ log.type }}</td>
                <td class="text-center ">
                  <button
                    v-if="log.description"
                    class="btn btn-sm btn-link text-primary"
                    @click="viewDetail(log)"
                  >
                    <i class="bi bi-eye"></i>
                  </button>
                  <span v-else class="text-muted">—</span>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <nav v-if="bankLogsMap[account.id]?.last_page > 1" class="mt-3">
            <ul class="pagination justify-content-center ">
              <li class="page-item" :class="{ disabled: cardStates[account.id].page === 1 }">
                <button class="page-link" @click="changePage(account.id, cardStates[account.id].page - 1)">«</button>
              </li>
              <li class="page-item disabled">
                <span class="page-link">Trang {{ cardStates[account.id].page }}</span>
              </li>
              <li class="page-item" :class="{ disabled: cardStates[account.id].page >= bankLogsMap[account.id]?.last_page }">
                <button class="page-link" @click="changePage(account.id, cardStates[account.id].page + 1)">»</button>
              </li>
            </ul>
          </nav>
        </div>
      </transition>
    </div>

    <!-- Modal xem mô tả -->
    <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
      <div class="modal-box animate__animated animate__zoomIn">
        <h5 class="fw-bold mb-2">Chi tiết mô tả</h5>
        <p>{{ selectedLog?.description }}</p>
        <div class="text-end mt-3">
          <button class="btn btn-secondary" @click="showModal = false">Đóng</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'
import { debounce } from 'lodash'

const bankAccounts = ref([])
const bankLogsMap = reactive({})
const cardStates = reactive({})
const showModal = ref(false)
const selectedLog = ref(null)

const viewDetail = (log) => {
  selectedLog.value = log
  showModal.value = true
}

const fetchBankAccounts = async () => {
  const token = localStorage.getItem('access_token')
  try {
    const res = await axios.get('/api/bank-accounts', {
      headers: { Authorization: `Bearer ${token}` }
    })
    bankAccounts.value = res.data

    for (const acc of res.data) {
      cardStates[acc.id] = {
        page: 1,
        perPage: 10,
        keyword: '',
        opened: false
      }
    }
  } catch (err) {
    showAlertModal({
      title: 'Lỗi tải tài khoản',
      message: 'Không thể tải danh sách tài khoản ngân hàng.',
      type: 'alert',
      status: 'error'
    })
  }
}


const fetchLogs = async (accountId) => {
  const token = localStorage.getItem('access_token')
  const state = cardStates[accountId]
  try {
    const res = await axios.get('/api/bank-logs', {
      headers: { Authorization: `Bearer ${token}` },
      params: {
        bank_account_id: accountId,
        page: state.page,
        per_page: state.perPage,
        keyword: state.keyword
      }
    })
    bankLogsMap[accountId] = res.data

    // Nếu tìm kiếm không ra kết quả
    if (res.data.data?.length === 0 && state.keyword) {
      showAlertModal({
        title: 'Không có kết quả',
        message: 'Không tìm thấy giao dịch nào phù hợp với từ khoá.',
        type: 'alert',
        status: 'info'
      })
    }
  } catch (err) {
    showAlertModal({
      title: 'Lỗi tải giao dịch',
      message: 'Không thể tải danh sách giao dịch cho tài khoản này.',
      type: 'alert',
      status: 'error'
    })
  }
}


const toggleCard = async (accountId) => {
  cardStates[accountId].opened = !cardStates[accountId].opened
  if (cardStates[accountId].opened) {
    cardStates[accountId].page = 1
    await fetchLogs(accountId)
  }
}

const changePage = async (accountId, newPage) => {
  cardStates[accountId].page = newPage
  await fetchLogs(accountId)
}

const debouncedSearch = debounce(async (accountId) => {
  cardStates[accountId].page = 1
  await fetchLogs(accountId)
}, 400)

onMounted(fetchBankAccounts)

const formatTime = (t) => new Date(t).toLocaleString('vi-VN')
const formatCurrency = (val) => Number(val).toLocaleString('vi-VN') + ' đ'
</script>

<style scoped>
@import 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';

.table {
  border-radius: 8px;
  background: #fff;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}
.table thead th {
  background: #f5f5f5;
  text-transform: uppercase;
  font-size: 0.85rem;
  color: #444;
}
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
}
.modal-box {
  background: #fff;
  padding: 1.5rem 2rem;
  border-radius: 12px;
  max-width: 500px;
  width: 90%;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}
.bi-eye {
  cursor: pointer;
  transition: transform 0.2s;
}
.bi-eye:hover {
  color: #0d6efd;
  transform: scale(1.2);
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

</style>
