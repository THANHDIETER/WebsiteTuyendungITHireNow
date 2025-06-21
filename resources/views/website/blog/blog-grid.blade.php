
@extends('website.layouts.master')

@section('content')
<style>
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding: 20px;
    }

    .blog-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-5px);
    }

    .blog-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .blog-card h2 {
        font-size: 1.1rem;
        margin: 16px;
        margin-bottom: 8px;
        color: #222;
    }

    .blog-card p {
        font-size: 0.95rem;
        margin: 0 16px 10px;
        color: #555;
    }

    .blog-card small {
        color: #888;
        margin: 0 16px;
    }

    .blog-card a {
        margin: 12px 16px 16px;
        align-self: flex-start;
        color: #0c7b93;
        font-weight: bold;
        text-decoration: none;
    }

    .pagination {
        margin-top: 30px;
        text-align: center;
    }
</style>

<div class="container">
    <h1 style="text-align: center; margin-bottom: 30px;">Danh sách bài viết</h1>

    <div class="blog-grid">
        @foreach($blogs as $blog)
            <div class="blog-card">
                <img src="{{ asset($blog->image ?? 'images/default.jpg') }}" alt="Blog Image">
                <h2>{{ $blog->title }}</h2>
                <p>{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                <p><small>Tác giả: {{ $blog->author }} | {{ $blog->created_at->format('d M, Y') }}</small></p>
                <a href="{{ route('blog-details', ['id' => $blog->id]) }}">Xem chi tiết →</a>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
