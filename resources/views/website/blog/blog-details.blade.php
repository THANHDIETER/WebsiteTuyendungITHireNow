@extends('website.layouts.master')

@section('content')
<div class="container py-5">
    <h1>{{ $blog->title }}</h1>
    <img src="{{ asset('storage/'.$blog->image) }}" class="img-fluid mb-4" alt="{{ $blog->title }}">
    <div>
        {!! $blog->content !!}
    </div>
    <a href="{{ route('blog-grid') }}">Back to Blog Grid</a>

</div>
@endsection
