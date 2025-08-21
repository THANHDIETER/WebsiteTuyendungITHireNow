@extends('admin.settings.layout')

@section('settings-content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.logos.updateAll') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @php
                            $fields = [
                                'site' => 'site',
                                'header' => 'header',
                                'footer' => 'footer',
                                'client' => 'client',
                                'admin' => 'admin',
                            ];
                        @endphp

                        @foreach($fields as $type => $label)
                            @php
                                $logo = $logos->firstWhere('type', $type);
                            @endphp

                            <div class="col-md-4 mb-4 text-center">
                                <label class="form-label fw-bold d-block text-capitalize">{{ $label }}</label>
                                <input type="file" name="logos[{{ $type }}]" class="form-control mb-2">

                                @if($logo)
                                    <img src="{{ asset('storage/' . $logo->image_path) }}" class="img-thumbnail mb-2"
                                        style="max-height:120px;">
                                    <div class="small text-muted">{{ $logo->name ?? '' }}</div>
                                @else
                                    <div class="text-muted small mb-2">Chưa có logo</div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-lg btn-success shadow-sm px-4">
                            <i class="bi bi-save me-2"></i> Lưu tất cả
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection