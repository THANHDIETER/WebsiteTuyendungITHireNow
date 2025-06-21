


@extends('website.layouts.master')

@section('content')



<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }
    .blog-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .blog-card:hover {
        transform: translateY(-5px);
    }
    .blog-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .blog-card-body {
        padding: 15px;
    }
    .blog-card-body h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    .blog-card-body p {
        font-size: 0.95rem;
        color: #555;
    }
    .read-more {
        display: inline-block;
        margin-top: 10px;
        color: #0c7b93;
        font-weight: bold;
        text-decoration: none;
    }
</style>

<div class="blog-list">
    <h1 style="margin-bottom: 20px;">Danh sách bài viết</h1>

    <div class="grid-container">
        @foreach($blogs as $blog)
            <div class="blog-card">
                <img src="{{ asset($blog->thumbnail ?? 'default.jpg') }}" alt="Ảnh bài viết">
                <div class="blog-card-body">
                    <h2>{{ $blog->title }}</h2>
                    <p><small>Tác giả: {{ $blog->author }} | {{ $blog->created_at->format('d-m-Y') }}</small></p>
                    <p>{{ Str::limit($blog->content, 100) }}</p>
                    <a class="read-more" href="{{ route('blog-details', ['id' => $blog->id]) }}">Đọc tiếp →</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination" style="margin-top: 30px;">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
