@extends('website.layouts.master') <!-- nếu bạn có layout master -->

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Blog Grid</h1>
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/'.$blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                   <a href="{{ route('blog.show', $blog->id) }}">Read More</a>

                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $blogs->links() }} <!-- Pagination -->
    </div>
</div>
@endsection
