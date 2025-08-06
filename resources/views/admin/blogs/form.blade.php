<!-- Modal overlay -->
<div id="blogModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <!-- Modal content -->
    <div class="bg-white w-full max-w-2xl rounded shadow-lg p-4 relative animate-fadeInUp">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-bold">Thêm Bài Blog</h2>
            <button onclick="toggleModal()" class="text-gray-500 hover:text-red-600 text-2xl leading-none">&times;</button>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.blogs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Tiêu đề *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nội dung *</label>
                <textarea name="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ảnh (link)</label>
                <input type="text" name="image" class="form-control" value="{{ old('image') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tác giả</label>
                <input type="text" name="author" class="form-control" value="{{ old('author') }}">
            </div>

            <div class="d-flex justify-end mt-4">
                <button type="button" onclick="toggleModal()" class="btn btn-secondary me-2">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu bài viết</button>
            </div>
        </form>
    </div>
</div>

<!-- Script bật/tắt modal -->
<script>
    function toggleModal() {
        const modal = document.getElementById('blogModal');
        modal.classList.toggle('hidden');
    }
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.3s ease-out;
    }
</style>