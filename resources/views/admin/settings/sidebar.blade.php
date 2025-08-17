@extends('admin.layouts.default')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Sidebar trái --}}
        <div class="col-md-3">
            <div class="list-group list-group-flush shadow-sm">
                <a href="{{ route('admin.settings.index') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                    <i class="bi bi-sliders me-2"></i> Cài đặt chung
                </a>
                <a href="{{ route('admin.logos.index') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.settings.logos') ? 'active' : '' }}">
                    <i class="bi bi-image me-2"></i> Logo & Hình ảnh
                </a>
                <!-- <a href=""
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.settings.theme') ? 'active' : '' }}">
                    <i class="bi bi-palette me-2"></i> Giao diện
                </a>
                <a href="
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.settings.scripts') ? 'active' : '' }}">
                    <i class="bi bi-code-slash me-2"></i> Scripts
                </a>
                <a href=""
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.settings.maintenance') ? 'active' : '' }}">
                    <i class="bi bi-tools me-2"></i> Bảo trì
                </a> -->
            </div>
        </div>

        {{-- Nội dung chính --}}
        <div class="col-md-9">
            @yield('settings-content')
        </div>
    </div>
</div>
@endsection
