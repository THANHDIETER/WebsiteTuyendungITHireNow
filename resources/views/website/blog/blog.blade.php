@extends('website.layouts.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">All Blog Posts</h1>
    @foreach($blogs as $blog)
    <div class="mb-4">
        <h3>{{ $blog->title }}</h3>
        <p>{{ Str::limit($blog->content, 200) }}</p>
       <a href="{{ route('blog.show', $blog->id) }}">Read More</a>

    </div>
    @endforeach
    {{ $blogs->links() }}
</div>
@endsection
