@extends('admin.layouts.default')

@section('content')
<div id="app" class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">📂 Quản lý hồ sơ ứng tuyển</h2>
    <div class="d-flex align-items-center">
      <label class="me-2 mb-0">Hiển thị:</label>
      <select class="form-select w-auto" v-model="perPage" @change="changePage(1)">
        <option :value="10">10</option>
        <option :value="20">20</option>
        <option :value="50">50</option>
        <option :value="100">100</option>
        <option :value="200">200</option>
        <option :value="500">500</option>
      </select>
    </div>
  </div>

  <div v-if="loading" class="alert alert-info">Đang tải danh sách hồ sơ...</div>

  <div v-else>
    <table class="table table-hover table-bordered align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Tiêu đề</th>
          <th>File CV</th>
          <th>Trạng thái</th>
          <th>Ngày nộp</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="resume in paginatedResumes" :key="resume.id">
          <td class="text-center">@{{ resume.id }}</td>
          <td>@{{ resume.title }}</td>
          <td class="text-center">
            <a v-if="resume.file_url" :href="resume.file_url" class="btn btn-sm btn-outline-primary" target="_blank">Tải về</a>
            <span v-else class="text-muted">Không có</span>
          </td>
          <td class="text-center">
          <span class="badge bg-danger" v-if="resume.is_deleted">Đã xoá</span>
          <span class="badge bg-success" v-else-if="resume.is_approved">Đã duyệt</span>
          <span class="badge bg-secondary" v-else>Chờ duyệt</span>
          </td>
          <td class="text-center">@{{ new Date(resume.created_at).toLocaleDateString() }}</td>
         <td class="text-center">
        <template v-if="!resume.is_deleted">
          <button @click="approveResume(resume.id)" class="btn btn-success btn-sm me-1" 
          :disabled="resume.is_approved"> Duyệt </button>
          <button @click="deleteResume(resume.id)" class="btn btn-danger btn-sm" 
          :disabled="resume.is_approved">Xoá</button>
        </template>
        <span v-else class="text-muted">Đã xóa</span>
      </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav v-if="lastPage > 1" class="d-flex justify-content-center mt-4">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: page === 1 }">
          <button class="page-link" @click="changePage(page - 1)">«</button>
        </li>
        <li class="page-item disabled">
          <span class="page-link">@{{ page }} / @{{ lastPage }}</span>
        </li>
        <li class="page-item" :class="{ disabled: page === lastPage }">
          <button class="page-link" @click="changePage(page + 1)">»</button>
        </li>
      </ul>
    </nav>
  </div>
</div>
@endsection

@push('scripts')
<!-- Vue 3 & Axios -->
<script src="https://unpkg.com/vue@3"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const { createApp, ref, computed, onMounted } = Vue;

createApp({
  setup() {
    const allResumes = ref([]);
    const loading = ref(true);
    const page = ref(1);
    const perPage = ref(10);
    const token = localStorage.getItem('access_token');
    const fetchResumes = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/admin/resumes', {
        headers: { 
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
      allResumes.value = response.data;
    } catch (error) {
      if (error.response) {
        if (error.response.status === 401) {
          window.location.href = '/login';
          alert('Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại');
        } else if (error.response.data && error.response.data.message) {
          alert(error.response.data.message);
        } else {
          alert('Đã có lỗi xảy ra');
        }
      } else {
        alert('Đã có lỗi xảy ra');
      }
    } finally {
      loading.value = false;
    }
  };


    const paginatedResumes = computed(() => {
      const start = (page.value - 1) * perPage.value;
      return allResumes.value.slice(start, start + perPage.value);
    });

    const lastPage = computed(() => {
      return Math.ceil(allResumes.value.length / perPage.value);
    });

    const changePage = (newPage) => {
      if (newPage >= 1 && newPage <= lastPage.value) {
        page.value = newPage;
      }
    };

    const approveResume = async (id) => {
    try {
      await axios.patch(`/api/admin/resumes/${id}`, {}, {
        headers: { 
           Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json'
         }
      });

      const resume = allResumes.value.find(r => r.id === id);
      if (resume) {
        resume.is_approved = true;
      }
    } catch (error) {
      if (error.response && error.response.data && error.response.data.message) {
      alert(error.response.data.message);
    } else {
      alert('Đã có lỗi xảy ra');
    }
    }
  };

    const deleteResume = async (id) => {
    if (!confirm('Bạn có chắc chắn muốn xoá hồ sơ này?')) return;
    try {
      await axios.delete(`/api/admin/resumes/${id}`, {
        headers: { 
          Authorization: `Bearer ${token}`, 
          'Content-Type': 'application/json'
        }
      });

     const resume = allResumes.value.find(r => r.id === id);
    if (resume) {
      resume.is_deleted = true;
    }
    } catch (error) {
      if (error.response && error.response.data && error.response.data.message) {
      alert(error.response.data.message);
    } else {
      alert('Đã có lỗi xảy ra');
    }
    }
  };

    onMounted(fetchResumes);

    return {
      allResumes,
      paginatedResumes,
      loading,
      page,
      perPage,
      lastPage,
      changePage,
      approveResume,
      deleteResume
    };
  }
}).mount('#app');
</script>
@endpush
