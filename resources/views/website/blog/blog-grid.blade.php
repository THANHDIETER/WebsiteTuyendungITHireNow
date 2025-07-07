
@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/banner/15.png">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="job-search-wrap">
                                <div class="job-search-form">
                                    <form action="index.html#">
                                        <div class="row row-gutter-10">
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Tiêu đề việc làm hoặc từ khóa">
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="1" selected>Chọn Thành Phố</option>
                                                        <option value="2">Hà Nội</option>
                                                        <option value="3">Hồ Chí Minh</option>
                                                        <option value="4">Đà Nẵng</option>
                                                        <option value="5">Huế</option>
                                                        <option value="6">Hà Nam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="1" selected>Loại Công Việc</option>
                                                        <option value="2">Web Designer</option>
                                                        <option value="3">Web Developer</option>
                                                        <option value="4">Graphic Designer</option>
                                                        <option value="5">App Developer</option>
                                                        <option value="6">UI &amp; UX Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn-form-search"><i
                                                            class="icofont-search-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Page Header Area Wrapper ==-->
<style>
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
