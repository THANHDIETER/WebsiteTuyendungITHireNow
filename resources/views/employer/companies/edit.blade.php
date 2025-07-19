@extends('employer.layouts.default')

@section('content')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Sửa Công ty</h5>
                <a href="{{ route('employer.companies.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('employer.companies.update', $company) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- 1. Thông tin cơ bản --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">1. Thông tin cơ bản</legend>
                        @foreach (['name' => 'Tên công ty*', 'website' => 'Website', 'email' => 'Email', 'phone' => 'Điện thoại'] as $field => $label)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="{{ $field }}">{{ $label }}</label>
                                <div class="col-sm-9">
                                    <input id="{{ $field }}" name="{{ $field }}"
                                        type="{{ $field == 'email' ? 'email' : ($field == 'website' ? 'url' : 'text') }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field, $company->$field) }}" placeholder="{{ $label }}">
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </fieldset>

                    {{-- 2. Địa chỉ --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">2. Địa chỉ</legend>
                        @foreach (['city' => 'Thành phố', 'address' => 'Địa chỉ'] as $field => $label)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label"
                                    for="{{ $field }}">{{ $label }}</label>
                                <div class="col-sm-9">
                                    @if ($field == 'address')
                                        <textarea id="address" name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                            placeholder="{{ $label }}...">{{ old('address', $company->address) }}</textarea>
                                    @else
                                        <input id="city" name="city" type="text"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city', $company->city) }}" placeholder="{{ $label }}">
                                    @endif
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </fieldset>

                    {{-- 3. Chi tiết công ty --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">3. Chi tiết công ty</legend>
                        @foreach (['company_size' => 'Quy mô', 'founded_year' => 'Năm thành lập', 'industry' => 'Ngành nghề'] as $field => $label)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label"
                                    for="{{ $field }}">{{ $label }}</label>
                                <div class="col-sm-9">
                                    <input id="{{ $field }}" name="{{ $field }}"
                                        type="{{ $field == 'founded_year' ? 'number' : 'text' }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field, $company->$field) }}" placeholder="{{ $label }}">
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="status">Trạng thái</label>
                            <div class="col-sm-9">
                                <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'banned' => 'Banned'] as $val => $text)
                                        <option value="{{ $val }}"
                                            {{ old('status', $company->status) == $val ? 'selected' : '' }}>{{ $text }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- 4. Mô tả & Phúc lợi --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">4. Mô tả & Phúc lợi</legend>
                        @foreach (['description' => 'Mô tả', 'benefits' => 'Phúc lợi'] as $field => $label)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label"
                                    for="{{ $field }}">{{ $label }}</label>
                                <div class="col-sm-9">
                                    <textarea id="{{ $field }}" name="{{ $field }}" rows="4"
                                        class="form-control @error($field) is-invalid @enderror" placeholder="{{ $label }}...">{{ old($field, is_array($company->$field) ? implode(', ', $company->$field) : $company->$field) }}</textarea>
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </fieldset>

                    {{-- 5. Hình ảnh --}}
                    <fieldset class="mb-4">
                        <legend class="h6 text-secondary">5. Hình ảnh</legend>
                        @foreach (['logo' => 'Logo', 'cover_image' => 'Ảnh bìa'] as $field => $label)
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label"
                                    for="{{ $field }}">{{ $label }}</label>
                                <div class="col-sm-9">
                                    <input type="file" id="{{ $field }}" name="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror">
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @php $url = $field.'_url'; @endphp
                                    @if ($company->$url)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $company->$url) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $company->$url) }}"
                                                    alt="{{ $label }} hiện tại"
                                                    style="max-height:120px; object-fit:cover;">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </fieldset>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-save me-1"></i>Lưu thay đổi
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
