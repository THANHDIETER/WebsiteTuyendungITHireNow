@extends('employer.layouts.default')

@section('content')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-building me-1"></i>Thêm mới Công ty</h5>
                <a href="{{ route('employer.companies.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('employer.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Thông tin cơ bản --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">1. Thông tin cơ bản</legend>

                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Tên công ty <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Tên công ty" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="website" class="col-sm-3 col-form-label">Website</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                        id="website" name="website" placeholder="https://example.com"
                                        value="{{ old('website') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="email@domain.com"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-sm-3 col-form-label">Điện thoại</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="0123 456 789"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Địa chỉ --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">2. Địa chỉ</legend>

                        <div class="row mb-3">
                            <label for="city" class="col-sm-3 col-form-label">Thành phố</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    id="city" name="city" placeholder="Hà Nội" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-sm-3 col-form-label">Địa chỉ</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                                    placeholder="Số nhà, phố, quận">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Thông tin công ty --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">3. Chi tiết công ty</legend>

                        <div class="row mb-3">
                            <label for="company_size" class="col-sm-3 col-form-label">Quy mô</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('company_size') is-invalid @enderror"
                                    id="company_size" name="company_size" placeholder="50-100 nhân sự"
                                    value="{{ old('company_size') }}">
                                @error('company_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="founded_year" class="col-sm-3 col-form-label">Năm thành lập</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('founded_year') is-invalid @enderror"
                                    id="founded_year" name="founded_year" placeholder="2020"
                                    value="{{ old('founded_year') }}">
                                @error('founded_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="industry" class="col-sm-3 col-form-label">Ngành nghề</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('industry') is-invalid @enderror"
                                    id="industry" name="industry" placeholder="Công nghệ thông tin"
                                    value="{{ old('industry') }}">
                                @error('industry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-sm-3 col-form-label">Trạng thái</label>
                            <div class="col-sm-9">
                                <select id="status" class="form-select @error('status') is-invalid @enderror"
                                    name="status">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Banned
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Mô tả & Phúc lợi --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">4. Mô tả & Phúc lợi</legend>

                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Giới thiệu về công ty">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="benefits" class="col-sm-3 col-form-label">Phúc lợi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('benefits') is-invalid @enderror" id="benefits" name="benefits"
                                    rows="3" placeholder="Các chế độ đãi ngộ">{{ old('benefits') }}</textarea>
                                @error('benefits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Hình ảnh --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">5. Hình ảnh</legend>

                        <div class="row mb-3">
                            <label for="logo" class="col-sm-3 col-form-label">Logo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                    id="logo" name="logo">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cover_image" class="col-sm-3 col-form-label">Cover ảnh</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                    id="cover_image" name="cover_image">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i>Lưu
                        </button>
                        <a href="{{ route('employer.companies.index') }}" class="btn btn-outline-secondary">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
