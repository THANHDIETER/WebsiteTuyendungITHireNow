@extends('admin.settings.layout')

@section('settings-content')
<div class="container-fluid px-4">
    <h4 class="mb-4">Logo & Hình ảnh</h4>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @php
                    $fields = [
                        'site'   => 'site',
                        'header' => 'header',
                        'footer' => 'footer',
                        'client' => 'client',
                        'admin'  => 'admin',
                    ];
                @endphp

                @foreach($fields as $type => $label)
                    @php
                        $logo = $logos->firstWhere('type', $type);
                    @endphp

                    <div class="col-md-4 mb-4 text-center">
                        <form action="{{ route('admin.logos.updateSingle', $type) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-label fw-bold d-block">{{ $label }}</label>

                            <input type="file" name="image" class="form-control mb-2">

                            @if($logo)
                                <img src="{{ asset('storage/' . $logo->image_path) }}"
                                     class="img-thumbnail mb-2"
                                     style="max-height:120px;">
                                <div class="small text-muted">{{ $logo->name ?? '' }}</div>
                            @else
                                <div class="text-muted small mb-2">Chưa có logo</div>
                            @endif

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Lưu
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
