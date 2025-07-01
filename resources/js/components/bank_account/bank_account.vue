<template>
  <div class="container">
    <h1 class="text-center display-5 fw-bold gradient-text mb-4">Quản lý Tài Khoản Ngân Hàng</h1>

    <!-- FORM MODAL với animation -->
    <transition name="modal-fade">
      <div v-if="showForm" class="modal-backdrop" @click.self="resetForm">
        <div class="modal-box animate__animated animate__zoomIn">
          <form @submit.prevent="submitForm" class="row g-3" enctype="multipart/form-data" autocomplete="off">
            <h5 class="fw-bold text-primary text-center mb-3">
              {{ isEditing ? 'Sửa #' + editingId : 'Thêm tài khoản mới' }}
            </h5>

            <div class="col-md-6">
            <label class="form-label">Ngân hàng</label>
            <select v-model="form.bank" class="form-select form-select-lg shadow-sm">
              <option disabled value="">Chọn ngân hàng</option>
              <option value="Momo">Momo</option>
              <option value="MBbank">MB Bank</option>
              <option value="ACB">ACB</option>
            </select>
          </div>
            <div class="col-md-6">
              <label class="form-label">Chi nhánh</label>
              <input v-model="form.branch" type="text" class="form-control form-control-lg shadow-sm"
                placeholder="VD: Hà Nội, HCM..." />
            </div>
            <div class="col-md-6">
              <label class="form-label">Số tài khoản</label>
              <input v-model="form.account_number" type="text" class="form-control form-control-lg shadow-sm"
                placeholder="Nhập số tài khoản" />
            </div>
            <div class="col-md-6">
  <label class="form-label">Chủ tài khoản</label>
  <input v-model="form.account_name" type="text" class="form-control form-control-lg shadow-sm"
         placeholder="Nhập tên chủ tài khoản" />
</div>

            <div class="col-md-6">
              <label class="form-label">Mật khẩu</label>
              <input v-model="form.password" type="password" class="form-control form-control-lg shadow-sm"
                placeholder="Nhập mật khẩu" autocomplete="new-password" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Token</label>
              <input v-model="form.token" type="password" class="form-control form-control-lg shadow-sm"
                placeholder="API Token" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Ảnh đại diện</label>
              <input type="file" @change="handleImageChange" class="form-control form-control-lg shadow-sm"
                accept="image/*" />
              <img v-if="previewImage" :src="previewImage" class="mt-2 rounded shadow border"
                style="max-height: 80px;" />
            </div>

            <div class="col-12 form-check mt-2 ps-3">
              <input v-model="form.is_active" type="checkbox" class="form-check-input"
                :true-value="1" :false-value="0" id="activeCheck" />
              <label class="form-check-label" for="activeCheck">Hoạt động</label>
            </div>

            <div class="col-12 text-end mt-3">
              <button type="submit" class="btn btn-gradient me-2 px-4 py-2 fw-bold shadow-sm">
                {{ isEditing ? 'Cập nhật' : 'Thêm mới' }}
              </button>
              <button type="button" @click="resetForm" class="btn btn-outline-secondary px-4 py-2">Huỷ</button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    <!-- DANH SÁCH -->
    <div class="mt-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Danh sách tài khoản</h2>
        <button @click="startCreate" class="btn btn-success px-4 py-2 shadow-sm">+ Thêm mới</button>
      </div>

      <transition-group name="fade-list" tag="table" class="table table-bordered table-hover align-middle shadow-sm">
        <thead class="bg-dark text-white">
          <tr>
            <th>ID</th>
            <th>Ngân hàng</th>
            <th>Chủ tài khoản</th>
            <th>Chi nhánh</th>
            <th>Số tài khoản</th>
            <th>Ảnh</th>
            <th>Hoạt động</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading" key="loading">
            <td colspan="7" class="text-center py-4">Đang tải dữ liệu...</td>
          </tr>
          <tr v-else-if="accounts.length === 0" key="empty">
            <td colspan="7" class="text-center text-muted">Không có tài khoản nào.</td>
          </tr>
          <tr v-else v-for="account in accounts" :key="account.id" class="fade-list-item">
            <td>{{ account.id }}</td>
            <td class="text-uppercase">{{ account.bank }}</td>
            <td>{{ account.account_name || '—' }}</td>

            <td>{{ account.branch || '—' }}</td>
            <td>{{ account.account_number || '—' }}</td>
            <td>
              <img v-if="account.image" :src="`/storage/${account.image}`" alt="Ảnh"
                class="rounded shadow border" style="max-height: 40px;" />
            </td>
            <td>
              <span :class="account.is_active ? 'text-success fw-bold' : 'text-danger fw-bold'">
                {{ account.is_active ? 'Hoạt động' : 'Tạm dừng' }}
              </span>
            </td>
            <td>
              <button @click="editAccount(account)" class="btn btn-sm btn-outline-primary me-2 px-3">Sửa</button>
              <button @click="confirmDelete(account.id)" class="btn btn-sm btn-outline-danger px-3">Xoá</button>
            </td>
          </tr>
        </tbody>
      </transition-group>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const getEmptyForm = () => ({
  bank: '',
  account_number: '',
  account_name: '',
  token: '',
  password: '',
  branch: '',
  is_active: 1,
})

const form = ref(getEmptyForm())
const imageFile = ref(null)
const previewImage = ref(null)
const editingId = ref(null)
const isEditing = ref(false)
const accounts = ref([])
const showForm = ref(false)
const isLoading = ref(true)

const api = axios.create({ baseURL: '/api' })
api.interceptors.request.use(config => {
  const token = localStorage.getItem('access_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

const fetchAccounts = async () => {
  try {
    const res = await api.get('/bank-accounts')
    accounts.value = res.data
  } catch {
    showAlertModal({
      title: 'Lỗi',
      message: 'Không thể tải danh sách tài khoản',
      type: 'alert',
      status: 'error'
    })
  } finally {
    isLoading.value = false
  }
}

onMounted(fetchAccounts)

const handleImageChange = (e) => {
  const file = e.target.files[0]
  imageFile.value = file
  previewImage.value = file ? URL.createObjectURL(file) : null
}

const startCreate = () => {
  form.value = getEmptyForm()
  imageFile.value = null
  previewImage.value = null
  editingId.value = null
  isEditing.value = false
  showForm.value = true
}

const editAccount = (account) => {
  editingId.value = account.id
  isEditing.value = true
  form.value = {
    bank: account.bank ?? '',
    account_number: account.account_number ?? '',
    token: account.token ?? '',
    password: account.password ?? '',
    account_name: account.account_name ?? '',
    branch: account.branch ?? '',
    is_active: account.is_active === 1 ? 1 : 0,
  }
  imageFile.value = null
  previewImage.value = account.image ? `/storage/${account.image}` : null
  showForm.value = true
}

const resetForm = () => {
  form.value = getEmptyForm()
  imageFile.value = null
  previewImage.value = null
  editingId.value = null
  isEditing.value = false
  showForm.value = false
}

const submitForm = async () => {
  try {
    const formData = new FormData()
    Object.entries(form.value).forEach(([key, val]) => {
      formData.append(key, val ?? '')
    })
    if (imageFile.value) {
      formData.append('image', imageFile.value)
    }

    const config = { headers: { 'Content-Type': 'multipart/form-data' } }

    if (isEditing.value && editingId.value) {
      await api.post(`/bank-accounts/${editingId.value}?_method=PUT`, formData, config)
      showAlertModal({
        title: 'Thành công',
        message: 'Cập nhật tài khoản thành công.',
        type: 'alert',
        status: 'success'
      })
    } else {
      await api.post('/bank-accounts', formData, config)
      showAlertModal({
        title: 'Thành công',
        message: 'Tạo tài khoản mới thành công.',
        type: 'alert',
        status: 'success'
      })
    }

    await fetchAccounts()
    resetForm()
  } catch (err) {
    const msg = err.response?.data?.message || ''
    const errors = err.response?.data?.errors
    const detail = errors ? Object.values(errors).flat().join('\n') : ''
    showAlertModal({
      title: 'Lỗi',
      message: msg + (detail ? '\n' + detail : ''),
      type: 'alert',
      status: 'error'
    })
  }
}

const confirmDelete = (id) => {
  showAlertModal({
    title: 'Xác nhận xoá',
    message: 'Bạn có chắc chắn muốn xoá tài khoản này?',
    type: 'confirm',
    status: 'warning',
    onConfirm: () => deleteAccount(id)
  })
}

const deleteAccount = async (id) => {
  try {
    await api.delete(`/bank-accounts/${id}`)
    await fetchAccounts()
    showAlertModal({
      title: 'Đã xoá',
      message: 'Tài khoản đã được xoá.',
      type: 'alert',
      status: 'success'
    })
  } catch {
    showAlertModal({
      title: 'Lỗi',
      message: 'Không thể xoá tài khoản.',
      type: 'alert',
      status: 'error'
    })
  }
}
</script>

<style scoped>
/* Hiệu ứng transition cho modal */
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity .3s;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
.modal-fade-enter-to, .modal-fade-leave-from {
  opacity: 1;
}

/* Hiệu ứng cho danh sách table */
.fade-list-enter-active,
.fade-list-leave-active {
  transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
}
.fade-list-enter-from {
  opacity: 0;
  transform: translateY(24px) scale(0.95);
}
.fade-list-leave-to {
  opacity: 0;
  transform: translateY(24px) scale(0.95);
}

/* Gradient text */
.gradient-text {
  background: linear-gradient(90deg, #1f8ef1, #3fc1c9, #f9ca24);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  animation: fadeInBg 0.4s;
}
@keyframes fadeInBg {
  from { opacity: 0 }
  to { opacity: 1 }
}
.modal-box {
  background: #fff;
  padding: 2.4rem 2.2rem 1.7rem 2.2rem;
  border-radius: 20px;
  width: 97%;
  max-width: 850px;    /* <-- Tăng rộng tối đa lên 750px */
  min-width: 350px;
  box-shadow: 0 10px 32px rgba(31, 143, 241, 0.18);
  position: relative;
}
.btn-gradient {
  background: linear-gradient(90deg, #1f8ef1 0%, #3fc1c9 80%);
  color: #fff !important;
  border: none;
  border-radius: 24px;
  transition: box-shadow .2s, transform .2s;
}
.btn-gradient:hover {
  box-shadow: 0 3px 12px #3fc1c97c;
  transform: translateY(-2px) scale(1.03);
}
.form-control-lg {
  font-size: 1.1rem;
  padding: 0.7rem 1rem;
  border-radius: 14px;
  background: #f6f8fa;
}
.table th, .table td {
  vertical-align: middle;
  text-align: center;
}
.table thead {
  background: linear-gradient(90deg, #1f8ef1 0%, #3fc1c9 100%);
  color: #fff;
}
.table-hover tbody tr:hover {
  background: #e3f6fd;
  transition: background 0.18s;
}
</style>
