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
                        class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.logos.index') ? 'active' : '' }}">
                        <i class="bi bi-image me-2"></i> Logo & Hình ảnh
                    </a>

                    <a href="{{ route('admin.ai-configs.index') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.ai-configs.index') ? 'active' : '' }}">
                        <i class="bi bi-cpu me-2"></i> AI Configs Cron job
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('settings-content')
            </div>
        </div>
    </div>
@endsection