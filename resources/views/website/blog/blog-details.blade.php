@extends('website.layouts.master')

@section('content')
    <div class="blog-detail">
        <h1>{{ $blog->title }}</h1>
        <p><em>By {{ $blog->author }} | {{ $blog->created_at->format('d M, Y') }}</em></p>
        <img src="{{ $blog->image }}" alt="Ảnh blog" width="600">
        <div class="content">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <a href="{{ route('blog-grid') }}">← Quay lại danh sách</a>
    </div>
@endsection
