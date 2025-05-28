@extends('admin.layouts.default')

@section('content')
<div id="app" class="container mt-5">
  <h2 class="mb-4">Quản lý hồ sơ ứng tuyển</h2>

  <div v-if="loading" class="alert alert-info">Đang tải danh sách hồ sơ...</div>

  <table v-else class="table table-bordered table-striped">
    <thead class="table-dark">
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
      <tr v-for="resume in resumes" :key="resume.id">
        <td>@{{ resume.id }}</td>
        <td>@{{ resume.title }}</td>
        <td>
          <a v-if="resume.file_url" :href="resume.file_url" class="btn btn-sm btn-outline-primary" target="_blank">Tải về</a>
          <span v-else class="text-muted">Không có</span>
        </td>
        <td>
          <span class="badge bg-success" v-if="resume.is_approved">Đã duyệt</span>
          <span class="badge bg-secondary" v-else>Chờ duyệt</span>
        </td>
        <td>@{{ new Date(resume.created_at).toLocaleDateString() }}</td>
        <td>
          <button @click="approveResume(resume.id)" class="btn btn-success btn-sm me-1" :disabled="resume.is_approved">
            Duyệt
          </button>
          <button @click="deleteResume(resume.id)" class="btn btn-danger btn-sm">
            Xoá
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection

@push('scripts')
<!-- Vue & Axios CDN -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      resumes: [],
      loading: true,
      token: localStorage.getItem('access_token') || 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzQ4NDU5MDYxLCJleHAiOjE3NDg0NjI2NjEsIm5iZiI6MTc0ODQ1OTA2MSwianRpIjoidU9CQ1ByWm54elBLT0FUZCIsInN1YiI6IjEyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsInJvbGUiOiJhZG1pbiIsInBlcm1pc3Npb25zIjpbXX0.LBDc6J9WAy_Q87iBZ5KAgE2Op26fj7uAxXEkfQj0etE'
    };
  },
  mounted() {
    this.fetchResumes();
  },
  methods: {
    async fetchResumes() {
      try {
        const res = await axios.get('/api/admin/resumes', {
          headers: { Authorization: `Bearer ${this.token}` }
        });
        this.resumes = res.data;
      } catch (err) {
        console.error('Lỗi tải danh sách hồ sơ', err);
        alert('Không thể tải dữ liệu. Vui lòng đăng nhập lại.');
      } finally {
        this.loading = false;
      }
    },
    async approveResume(id) {
      try {
        await axios.patch(`/api/admin/resumes/${id}/approve`, {}, {
          headers: { Authorization: `Bearer ${this.token}` }
        });
        this.fetchResumes();
      } catch (err) {
        console.error('Lỗi duyệt hồ sơ', err);
        alert('Duyệt hồ sơ thất bại.');
      }
    },
    async deleteResume(id) {
      if (!confirm('Bạn có chắc chắn muốn xoá hồ sơ này?')) return;
      try {
        await axios.delete(`/api/admin/resumes/${id}/delete`, {
          headers: { Authorization: `Bearer ${this.token}` }
        });
        this.fetchResumes();
      } catch (err) {
        console.error('Lỗi xoá hồ sơ', err);
        alert('Xoá hồ sơ thất bại.');
      }
    }
  }
}).mount('#app');
</script>
@endpush
