@extends('website.layouts.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <h1 class="mb-4">Blog with Right Sidebar</h1>
            @foreach($blogs as $blog)
            <div class="mb-4">
                <h3>{{ $blog->title }}</h3>
                <p>{{ Str::limit($blog->content, 150) }}</p>
                <a href="{{ route('blog.show', $blog->id) }}">Read More</a>

            </div>
            @endforeach
            {{ $blogs->links() }}
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <h4>Categories</h4>
            <ul>
                @foreach($categories as $category)
                <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
