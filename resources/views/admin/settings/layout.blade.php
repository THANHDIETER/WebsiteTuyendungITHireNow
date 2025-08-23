@extends('admin.layouts.default')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Sidebar trái --}}
        <div class="col-md-3">
            @include('admin.settings.sidebar')
        </div>

        {{-- Nội dung phải --}}
        <div class="col-md-9">
            @yield('settings-content')
            
        </div>
        
    </div>
</div>

@endsection
