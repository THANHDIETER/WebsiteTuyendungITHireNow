<template>
    <div class="container mb-5 bg-light rounded shadow-sm">
        <h3 class="text-center fw-bold display-4 text-primary">📂 Danh sách hồ sơ ứng viên</h3>

        <!-- Bộ lọc -->
        <div class="card p-3 mb-4 shadow-sm border-0 rounded">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <input v-model="search" @input="changePage(1)" class="form-control shadow-sm"
                        placeholder="🔍 Tìm theo tên ứng viên..." />
                </div>
                <div class="col-md-4">
                    <select v-model="filter" @change="changePage(1)" class="form-select shadow-sm">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1">✅ Đã duyệt</option>
                        <option value="0">⛔ Chưa duyệt</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select v-model.number="perPage" @change="changePage(1)" class="form-select shadow-sm">
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

        <!-- Loading -->
        <div v-if="loading" class="text-center text-muted fs-5 mb-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
        </div>

        <!-- Bảng dữ liệu -->
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
                        <th>CV</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="profile in paginatedProfiles" :key="profile.id" class="align-middle">
                        <td class="text-center">{{ profile.id }}</td>
                        <td>{{ profile.headline.length > 20 ? profile.headline.slice(0, 20) + '...' : profile.headline
                            }}</td>
                        <td>{{ profile.user?.name ?? 'N/A' }}</td>
                        <td>{{ profile.summary.length > 20 ? profile.summary.slice(0, 20) + '...' : profile.summary }}
                        </td>
                        <td class="text-center">{{ profile.years_of_experience }} năm</td>
                        <td>{{ profile.location }}</td>
                        <td class="text-center">
                            <a :href="profile.cv_url" class="btn btn-sm btn-outline-primary" target="_blank">CV</a>
                        </td>
                        <td class="text-center">
                            <span :class="profile.is_visible ? 'badge bg-success' : 'badge bg-danger'">
                                {{ profile.is_visible ? 'Đã duyệt' : 'Chưa duyệt' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-info me-2" @click="openDetail(profile)"
                                title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button v-if="!profile.is_visible" class="btn btn-sm btn-outline-success"
                                @click="confirmApprove(profile)" title="Duyệt hồ sơ">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Phân trang & Hiển thị tổng cộng -->
            <div class="row align-items-center m-2">
                <!-- Hiển thị tổng bên trái -->
                <div class="col-md-6 text-start text-muted small">
                    Hiển thị {{ startEntry }} đến {{ endEntry }} trên tổng {{ total }} hồ sơ
                </div>

                <!-- Phân trang bên phải -->
                <div class="col-md-6">
                    <nav v-if="totalPages > 1">
                        <ul class="pagination justify-content-end mb-0">
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

        <!-- Modal chi tiết -->
        <div class="modal fade" tabindex="-1" ref="modalRef">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">📄 Chi tiết hồ sơ — ID #{{ selected?.id }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <ul v-if="selected" class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Tiêu đề:</strong> {{ selected.headline }}</li>
                            <li class="list-group-item"><strong>Tóm tắt:</strong> {{ selected.summary }}</li>
                            <li class="list-group-item"><strong>CV:</strong> <a :href="selected.cv_url"
                                    target="_blank">Xem CV</a></li>
                            <li class="list-group-item"><strong>LinkedIn:</strong> {{ selected.linkedin_url }}</li>
                            <li class="list-group-item"><strong>GitHub:</strong> {{ selected.github_url }}</li>
                            <li class="list-group-item"><strong>Portfolio:</strong> {{ selected.portfolio_url }}</li>
                            <li class="list-group-item"><strong>Học vấn:</strong> {{ selected.education }}</li>
                            <li class="list-group-item"><strong>Kinh nghiệm:</strong> {{ selected.work_experience }}
                            </li>
                            <li class="list-group-item"><strong>Kỹ năng ngoại ngữ:</strong> {{ selected.language_skills
                                }}</li>
                        </ul>
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
        if (profile.is_visible) return
        if (!confirm(`Bạn có chắc chắn muốn duyệt hồ sơ ID #${profile.id}?`)) return
        try {
            await axios.put(`/api/seeker-profiles/${profile.id}`, { is_visible: true })
            profile.is_visible = true
            fetchProfiles()
        } catch (err) {
            console.error('Lỗi cập nhật:', err)
        }
    }

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