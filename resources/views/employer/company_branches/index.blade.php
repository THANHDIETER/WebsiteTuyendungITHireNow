@extends('employer.layouts.default')

@section('content')
<div class="container py-4">
    <h3 class="ms-2">Danh sách chi nhánh của {{ $company->name }}</h3>

    <!-- Nút mở popup thêm -->
    <button class="btn btn-primary mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#createBranchModal">
        + Thêm chi nhánh
    </button>

    <!-- Bảng danh sách -->
    <table class="table table-bordered ms-2 me-2">
        <thead class="table-light">
            <tr>
                <th>Tên</th>
                <th>Địa chỉ</th>
                <th>Thành phố</th>
                <th>Điện thoại</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($company->branches as $branch)
            <tr>
                <td>{{ $branch->name }}</td>
                <td>{{ $branch->address }}</td>
                <td>{{ $branch->city?->name }}</td> {{-- fix: lấy từ quan hệ --}}
                <td>{{ $branch->phone }}</td>
                <td class="text-center">
                    <!-- Nút sửa -->
                    <button class="btn btn-sm btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editBranchModal{{ $branch->id }}">
                        Sửa
                    </button>

                    <!-- Nút xóa -->
                    <button class="btn btn-sm btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteBranchModal{{ $branch->id }}">
                        Xóa
                    </button>
                </td>
            </tr>

            <!-- Modal sửa -->
            <div class="modal fade" id="editBranchModal{{ $branch->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('employer.company.branches.update', [$company->id, $branch->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title">Sửa chi nhánh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ $branch->name }}">
                                </div>
                                <div class="mb-3">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{ $branch->address }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city_id">Thành phố</label>
                                    <select name="city_id" class="form-select select2-city" data-parent="#editBranchModal{{ $branch->id }}">
                                        <option value="">-- Chọn thành phố --</option>
                                        @foreach($locations as $loc)
                                            <option value="{{ $loc->id }}" 
                                                {{ old('city_id', $branch->city_id) == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $branch->phone }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal xóa -->
            <div class="modal fade" id="deleteBranchModal{{ $branch->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('employer.company.branches.destroy', [$company->id, $branch->id]) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Xóa chi nhánh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn xóa chi nhánh <b>{{ $branch->name ?? 'Không tên' }}</b>?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal thêm -->
<div class="modal fade" id="createBranchModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('employer.company.branches.store', $company->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm chi nhánh mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tên</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Địa chỉ</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="city_id">Thành phố</label>
                        <select name="city_id" class="form-select select2-city" data-parent="#createBranchModal">
                            <option value="">-- Chọn thành phố --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ old('city_id') == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Điện thoại</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-city').each(function() {
            let parent = $(this).data('parent') || 'body';
            $(this).select2({
                placeholder: "Tìm kiếm thành phố...",
                allowClear: true,
                width: '100%',
                dropdownParent: $(parent) // fix cho modal
            });
        });
    });
</script>
@endpush
