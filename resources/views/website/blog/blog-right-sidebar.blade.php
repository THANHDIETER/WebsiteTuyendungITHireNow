



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
        @endforeach

        <div class="pagination">
            {{ $blogs->links() }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar">
            <h4>Bài viết mới</h4>
            {{-- Có thể truyền thêm biến `$latestBlogs` từ Controller --}}
            @if(isset($latestBlogs))
                <ul class="list-unstyled">
                    @foreach($latestBlogs as $item)
                        <li>
                            <a href="{{ route('blog-details', ['id' => $item->id]) }}">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Chưa có bài viết mới.</p>
            @endif
        </div>
    </div>
</div>
@endsection
