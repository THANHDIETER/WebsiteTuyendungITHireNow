@extends('employer.layouts.default')

@section('content')
    <div class="container my-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-building me-2"></i>Thêm Công Ty</h5>
                <a href="{{ route('employer.companies.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('employer.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 1. Thông tin cơ bản --}}
                    <fieldset class="mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <strong class="text-muted">1. Thông tin cơ bản</strong>
                            </div>
                            <div class="card-body">

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Tên công ty" value="{{ old('name') }}">
                                    <label for="name"><i class="bi bi-building me-1"></i>Tên công ty *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                        id="website" name="website" placeholder="https://example.com"
                                        value="{{ old('website') }}">
                                    <label for="website"><i class="bi bi-globe me-1"></i>Website</label>
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="email@domain.com"
                                        value="{{ old('email') }}">
                                    <label for="email"><i class="bi bi-envelope me-1"></i>Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="0123 456 789"
                                        value="{{ old('phone') }}">
                                    <label for="phone"><i class="bi bi-phone me-1"></i>Điện thoại</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    {{-- 2. Địa chỉ --}}
                    <fieldset class="mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <strong class="text-muted">2. Địa chỉ</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="Hà Nội" value="{{ old('city') }}">
                                    <label for="city">Thành phố</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Số nhà, phố, quận" id="address"
                                        name="address" style="height: 100px">{{ old('address') }}</textarea>
                                    <label for="address">Địa chỉ</label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- 3. Thông tin công ty --}}
                    <fieldset class="mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <strong class="text-muted">3. Thông tin công ty</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('company_size') is-invalid @enderror"
                                        id="company_size" name="company_size" placeholder="Quy mô"
                                        value="{{ old('company_size') }}">
                                    <label for="company_size">Quy mô công ty</label>
                                    @error('company_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="number" class="form-control @error('founded_year') is-invalid @enderror"
                                        id="founded_year" name="founded_year" placeholder="2020"
                                        value="{{ old('founded_year') }}">
                                    <label for="founded_year">Năm thành lập</label>
                                    @error('founded_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('industry') is-invalid @enderror"
                                        id="industry" name="industry" placeholder="Ngành nghề"
                                        value="{{ old('industry') }}">
                                    <label for="industry">Ngành nghề</label>
                                    @error('industry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select id="status" class="form-select @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- 4. Mô tả & phúc lợi --}}
                    <fieldset class="mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <strong class="text-muted">4. Mô tả & Phúc lợi</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        style="height: 100px" placeholder="">{{ old('description') }}</textarea>
                                    <label for="description">Mô tả</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <textarea class="form-control @error('benefits') is-invalid @enderror" id="benefits" name="benefits"
                                        style="height: 100px" placeholder="">{{ old('benefits') }}</textarea>
                                    <label for="benefits">Phúc lợi</label>
                                    @error('benefits')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- 5. Hình ảnh --}}
                    <fieldset class="mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <strong class="text-muted">5. Hình ảnh</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo công ty</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" accept="image/*"
                                        onchange="previewImage(this, '#logoPreview')">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img id="logoPreview" class="mt-2 border rounded d-none" style="max-height: 100px;">
                                </div>

                                <div class="mb-3">
                                    <label for="cover_image" class="form-label">Ảnh bìa</label>
                                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                        id="cover_image" name="cover_image" accept="image/*">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i>Lưu
                        </button>
                        <a href="{{ route('employer.companies.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(input, selector) {
                const file = input.files[0];
                const img = document.querySelector(selector);
                if (file) {
                    img.src = URL.createObjectURL(file);
                    img.classList.remove('d-none');
                } else {
                    img.classList.add('d-none');
                }
            }
        </script>
    @endpush
@endsection