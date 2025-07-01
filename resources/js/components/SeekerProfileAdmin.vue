<template>
  <div class="container mb-5 bg-light rounded shadow-sm">
    <h3 class="text-center fw-bold display-5 text-primary"> Danh sách hồ sơ ứng viên</h3>

    <div class="card p-3 mb-4 shadow-sm border-0 rounded">
      <div class="row g-3 align-items-center">
        <div class="col-md-5 col-lg-5">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input v-model="search" @input="changePage(1)" class="form-control shadow-sm border-start-0"
              placeholder="Tìm theo tên ứng viên..." />
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel-fill"></i></span>
            <select v-model="filter" @change="changePage(1)" class="form-select shadow-sm border-start-0">
              <option value="">Tất cả trạng thái</option>
              <option value="1">✅ Đã duyệt</option>
              <option value="0">⛔ Chưa duyệt</option>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-lg-3">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-list-ol"></i></span>
            <select v-model.number="perPage" @change="changePage(1)" class="form-select shadow-sm border-start-0">
              <option value="10">Hiển thị 10</option>
              <option value="20">Hiển thị 20</option>
              <option value="50">Hiển thị 50</option>
              <option value="100">Hiển thị 100</option>
              <option value="200">Hiển thị 200</option>
              <option value="500">Hiển thị 500</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="text-center text-muted fs-5 mb-3 py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Đang tải...</span>
      </div>
      <p class="mt-2">Đang tải dữ liệu hồ sơ...</p>
    </div>

    <div v-else class="table-responsive">
      <table class="table table-bordered table-hover align-middle shadow-sm rounded">
        <thead class="table-light text-center">
          <tr>
            <th>ID</th>
            <th><i class="bi bi-file-earmark-text"></i> Tiêu đề</th>
            <th><i class="bi bi-person-circle"></i> Ứng viên</th>
            <th><i class="bi bi-card-text"></i> Tóm tắt</th>
            <th><i class="bi bi-briefcase"></i> Kinh nghiệm</th>
            <th><i class="bi bi-geo-alt"></i> Địa điểm</th>
            <th><i class="bi bi-file-earmark-arrow-down-fill"></i> CV</th>
            <th><i class="bi bi-check-circle"></i> Trạng thái</th>
            <th><i class="bi bi-sliders"></i> Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="profile in paginatedProfiles" :key="profile.id" class="align-middle">
            <td class="text-center">{{ profile.id }}</td>
            <td>
              <span :title="profile.headline">{{ profile.headline.length > 20 ? profile.headline.slice(0, 20) + '...' :
                profile.headline }}</span>
            </td>
            <td>{{ profile.user?.name ?? 'N/A' }}</td>
            <td>
              <span :title="profile.summary">{{ profile.summary.length > 20 ? profile.summary.slice(0, 20) + '...' :
                profile.summary }}</span>
            </td>
            <td class="text-center">{{ profile.years_of_experience ?? 'N/A' }} năm</td>
            <td>{{ profile.location || 'N/A' }}</td>
            <td class="text-center">
              <a v-if="profile.cv_url" :href="profile.cv_url" class="btn btn-sm btn-outline-primary" target="_blank"
                title="Xem CV">
                <i class="bi bi-file-earmark-arrow-down-fill"></i>
              </a>
              <span v-else class="text-muted small">Không có</span>
            </td>
            <td class="text-center">
              <span :class="profile.is_visible ? 'badge bg-success' : 'badge bg-danger'">
                {{ profile.is_visible ? 'Đã duyệt' : 'Chưa duyệt' }}
              </span>
            </td>
            <td class="text-center text-nowrap">
              <button class="btn btn-sm btn-outline-info me-2" @click="openDetail(profile)" title="Xem chi tiết">
                <i class="bi bi-eye-fill"></i>
              </button>
              <button v-if="!profile.is_visible" class="btn btn-sm btn-outline-success" @click="confirmApprove(profile)"
                title="Duyệt hồ sơ">
                <i class="bi bi-check-circle-fill"></i>
              </button>
            </td>
          </tr>
          <tr v-if="paginatedProfiles.length === 0">
            <td colspan="9" class="text-center text-muted py-4">Không tìm thấy hồ sơ nào phù hợp.</td>
          </tr>
        </tbody>
      </table>

      <div class="row align-items-center m-2">
        <div class="col-md-6 col-12 text-center text-md-start text-muted small mb-2 mb-md-0">
          Hiển thị {{ startEntry }} đến {{ endEntry }} trên tổng {{ total }} hồ sơ
        </div>

        <div class="col-md-6 col-12">
          <nav v-if="totalPages > 1">
            <ul class="pagination justify-content-center justify-content-md-end mb-0">
              <li class="page-item" :class="{ disabled: page === 1 }">
                <a class="page-link" href="#" @click.prevent="changePage(page - 1)" aria-label="Previous">«</a>
              </li>
              <li class="page-item" v-for="p in totalPages" :key="p" :class="{ active: page === p }">
                <a class="page-link" href="#" @click.prevent="changePage(p)">{{ p }}</a>
              </li>
              <li class="page-item" :class="{ disabled: page === totalPages }">
                <a class="page-link" href="#" @click.prevent="changePage(page + 1)" aria-label="Next">»</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" ref="modalRef">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-light d-flex align-items-center justify-content-between">
            <h5 class="modal-title mb-0 text-primary">
              <i class="bi bi-file-earmark-person-fill me-2"></i> Chi tiết hồ sơ — ID #{{ selected?.id }}
            </h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div v-if="selected">
              <div class="row g-4">
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-person-fill me-2"></i>Ứng viên:</strong> {{
                    selected.user?.name || 'N/A' }} (ID: {{ selected.user_id }})</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-card-heading me-2"></i>Tiêu đề:</strong> {{
                    selected.headline }}</p>
                </div>

                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-journal-text me-2"></i>Tóm tắt:</strong> {{
                    selected.summary || '—' }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-file-earmark-arrow-down-fill me-2"></i>CV: </strong>
                    <template v-if="selected.cv_url">
                      <a :href="selected.cv_url" target="_blank" class="text-decoration-none">Xem
                        CV <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                    </template>
                    <span v-else class="text-muted">Chưa có</span>
                  </p>
                </div>

                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-linkedin me-2"></i>LinkedIn: </strong>
                    <template v-if="selected.linkedin_url">
                      <a :href="selected.linkedin_url" target="_blank" class="text-decoration-none">{{
                        selected.linkedin_url }} <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                    </template>
                    <span v-else class="text-muted">Chưa có</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-github me-2"></i>GitHub: </strong>
                    <template v-if="selected.github_url">
                      <a :href="selected.github_url" target="_blank" class="text-decoration-none">{{
                        selected.github_url }} <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                    </template>
                    <span v-else class="text-muted">Chưa có</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-globe me-2"></i>Portfolio: </strong>
                    <template v-if="selected.portfolio_url">
                      <a :href="selected.portfolio_url" target="_blank" class="text-decoration-none">{{
                        selected.portfolio_url }} <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                    </template>
                    <span v-else class="text-muted">Chưa có</span>
                  </p>
                </div>

                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-geo-alt-fill me-2"></i>Địa điểm:</strong> {{
                    selected.location || 'Chưa cập nhật' }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-currency-dollar me-2"></i>Mức lương mong muốn:</strong>
                    {{ selected.salary_expectation ? selected.salary_expectation.toLocaleString() +
                      ' VNĐ' : 'Chưa cập nhật' }}
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-briefcase-fill me-2"></i>Số năm kinh
                      nghiệm:</strong> {{ selected.years_of_experience ?? 'Chưa cập nhật' }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-person-workspace me-2"></i>Loại công
                      việc:</strong> {{ selected.job_types || 'Chưa cập nhật' }}</p>
                </div>

                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-mortarboard-fill me-2"></i>Trình độ học
                      vấn:</strong> {{ selected.education || '—' }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-building me-2"></i>Kinh nghiệm làm
                      việc:</strong> {{ selected.work_experience || '—' }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong><i class="bi bi-translate me-2"></i>Kỹ năng ngoại
                      ngữ:</strong> {{ selected.language_skills || '—' }}</p>
                </div>

                <div class="col-md-6">
                  <p class="mb-1">
                    <strong><i class="bi bi-check-circle-fill me-2"></i>Trạng thái: </strong>
                    <span :class="selected.is_visible ? 'badge bg-success' : 'badge bg-danger'">
                      {{ selected.is_visible ? 'Đã duyệt' : 'Chưa duyệt' }}
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-end">
            <button type="button" class="btn btn-outline-secondary" @click="closeModal">
              <i class="bi bi-x-lg me-2"></i>Đóng
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
    import { ref, computed, onMounted, nextTick, watch } from 'vue'
    import axios from 'axios'
    import { Modal } from 'bootstrap'

    // Tự động đính kèm token từ localStorage
    axios.interceptors.request.use(config => {
        const token = localStorage.getItem('access_token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    })

    const profiles = ref([])
    const total = ref(0)
    const loading = ref(false)

    const search = ref('')
    const filter = ref('')
    const page = ref(1)
    const perPage = ref(10)

    const selected = ref(null)
    const modalRef = ref(null)
    let modalInstance = null

    const fetchProfiles = async () => {
        loading.value = true
        try {
            const res = await axios.get('/api/seeker-profiles', {
                params: {
                    per_page: perPage.value,
                    page: page.value,
                    is_visible: filter.value !== '' ? filter.value : undefined,
                    search: search.value.trim() || undefined
                }
            })

            profiles.value = res.data.data
            total.value = res.data.total
        } catch (err) {
            console.error('Lỗi khi tải hồ sơ:', err)
        } finally {
            loading.value = false
        }
    }

    const paginatedProfiles = computed(() => profiles.value)
    const totalPages = computed(() => Math.ceil((total.value || 1) / perPage.value))
    const startEntry = computed(() => (page.value - 1) * perPage.value + 1)
    const endEntry = computed(() => Math.min(startEntry.value + profiles.value.length - 1, total.value))

    const confirmApprove = async (profile) => {
        if (profile.is_visible) return;

        showAlertModal({
            title: 'Xác nhận duyệt',
            message: `Bạn có chắc chắn muốn duyệt hồ sơ ID #${profile.id}?`,
            onConfirm: async () => {
                try {
                    await axios.put(`/api/seeker-profiles/${profile.id}`, { is_visible: true });
                    profile.is_visible = true;

                    showAlertModal({
                        type: 'alert',
                        title: 'Thành công',
                        message: `Hồ sơ ID #${profile.id} đã được duyệt thành công.`
                    });
                } catch (err) {
                    console.error('Lỗi cập nhật:', err);
                    showAlertModal({
                        type: 'alert',
                        title: 'Lỗi',
                        message: 'Có lỗi xảy ra khi duyệt hồ sơ.'
                    });
                }
            }
        });
    };


    const changePage = (newPage) => {
        if (newPage >= 1 && newPage <= totalPages.value) {
            page.value = newPage
        }
    }

    const openDetail = async (profile) => {
        selected.value = null
        await nextTick()
        selected.value = profile
        await nextTick()
        if (!modalInstance) {
            modalInstance = new Modal(modalRef.value)
        }
        modalInstance.show()
    }

    const closeModal = () => {
        if (modalInstance) modalInstance.hide()
    }

    watch([search, filter, perPage], () => {
        page.value = 1
        fetchProfiles()
    })
    watch(page, fetchProfiles)

    onMounted(fetchProfiles)
</script>


<style scoped>
    .table td,
    .table th {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.65em;
    }

    .btn-outline-info,
    .btn-outline-success {
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #fff;
    }

    .btn-outline-success:hover {
        background-color: #198754;
        color: #fff;
    }

    .card {
        background-color: #ffffff;
        border-radius: 12px;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
    }
</style>