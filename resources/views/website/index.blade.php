@extends('website.layouts.master')

@section('content')
<main class="main-content">

      <!--== Start Hero Area Wrapper ==-->
      <section class="home-slider-area">
        <div class="home-slider-container default-slider-container">
          <div class="home-slider-wrapper slider-default">
            <div class="slider-content-area" data-bg-img="../client/assets/img/slider/slider-bg.webp">
              <div class="container pt--0 pb--0">
                <div class="slider-container">
                  <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-lg-8">
                      <div class="slider-content">
                        <h2 class="title"><span class="counter" data-counterup-delay="80">2,568</span> việc làm đang tuyển
                          <br>Bạn có thể chọn công việc mơ ước của mình</h2>
                        <p class="desc">Tìm việc làm phù hợp để xây dựng sự nghiệp tươi sáng. Nhiều cơ hội việc làm đang chờ bạn tại nền tảng này.
                        </p>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="job-search-wrap">
                        <div class="job-search-form">
                          <form action="index.html#">
                            <div class="row row-gutter-10">
                              <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Tên công việc hoặc từ khóa">
                                </div>
                              </div>
                              <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                <div class="form-group">
                                  <select class="form-control">
                                    <option value="1" selected>Chọn thành phố</option>
                                    <option value="2">Hà Nội</option>
                                    <option value="3">TP. Hồ Chí Minh</option>
                                    <option value="4">Đà Nẵng</option>
                                    <option value="5">Cần Thơ</option>
                                    <option value="6">Khác</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-auto col-sm-6 col-12 flex-grow-1">
                                <div class="form-group">
                                  <select class="form-control">
                                    <option value="1" selected>Ngành nghề</option>
                                    <option value="2">Lập trình Web</option>
                                    <option value="3">Phát triển phần mềm</option>
                                    <option value="4">Thiết kế đồ họa</option>
                                    <option value="5">Phát triển ứng dụng</option>
                                    <option value="6">UI/UX</option>
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
          </div>
        </div>
        <div class="container pt--0 pb--0">
          <div class="row">
            <div class="col-12">
              <div class="play-video-btn">
                <a href="https://www.youtube.com/mcvqOUtcAJg" class="video-popup">
                  <img src="../client/assets/img/icons/play.webp" alt="Hình ảnh - HasTech">
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="home-slider-shape">
          <img class="shape1" data-aos="fade-down" data-aos-duration="1500" src="../client/assets/img/slider/vector1.webp"
            width="270" height="234" alt="Hình ảnh - HasTech">
          <img class="shape2" data-aos="fade-left" data-aos-duration="2000" src="../client/assets/img/slider/vector2.webp"
            width="201" height="346" alt="Hình ảnh - HasTech">
          <img class="shape3" data-aos="fade-right" data-aos-duration="2000" src="../client/assets/img/slider/vector3.webp"
            width="276" height="432" alt="Hình ảnh - HasTech">
          <img class="shape4" data-aos="flip-left" data-aos-duration="1500" src="../client/assets/img/slider/vector4.webp"
            width="127" height="121" alt="Hình ảnh - HasTech">
        </div>
      </section>
      <!--== End Hero Area Wrapper ==-->

      <!--== Start Job Category Area Wrapper ==-->
      <section class="job-category-area">
        <div class="container" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Ngành nghề nổi bật</h3>
                <div class="desc">
                  <p>Nhiều ngành nghề được tuyển dụng trên nền tảng</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row row-gutter-20">
            @forelse($categories as $category)
            <div class="col-sm-6 col-lg-3">
              <div class="job-category-item">
                <div class="content">
                  <h3 class="title">
                    <a href="{{ route('jobs.index', ['category' => $category->id]) }}">
                      {{ $category->name }} <span>({{ $category->jobs_count }})</span>
                    </a>
                  </h3>
                </div>
                <a class="overlay-link" href="{{ route('jobs.index', ['category' => $category->id]) }}"></a>
              </div>
            </div>
            @empty
            <div class="col-12">
              <div class="alert alert-info text-center">
                Chưa có danh mục ngành nghề nào.
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </section>
      <!--== End Job Category Area Wrapper ==-->

      <!--== Start Recent Job Area Wrapper ==-->
      <section class="recent-job-area bg-color-gray">
        <div class="container" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Việc làm mới nhất</h3>
                <div class="desc">
                  <p>Nhiều cơ hội việc làm được cập nhật liên tục</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            @forelse($jobs as $job)
            <div class="col-md-6 col-lg-4">
              <div class="recent-job-item">
                <div class="company-info">
                  <div class="logo">
                    <a href="#">
                      @if($job->company && $job->company->logo_url)
                        <img src="{{ $job->company->logo_url }}" width="75" height="75" alt="{{ $job->company->name }}">
                      @else
                        <img src="../client/assets/img/companies/1.webp" width="75" height="75" alt="Company Logo">
                      @endif
                    </a>
                  </div>
                  <div class="content">
                    <h4 class="name"><a href="#">{{ $job->company->name ?? 'N/A' }}</a></h4>
                    <p class="address">{{ $job->address ?? 'N/A' }}</p>
                  </div>
                </div>
                <div class="main-content">
                  <h3 class="title"><a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a></h3>
                  <h5 class="work-type">{{ ucfirst($job->job_type) }}</h5>
                  <p class="desc">{{ Str::limit($job->description, 100) }}</p>
                </div>
                <div class="recent-job-info">
                  <div class="salary">
                    <h4>{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</h4>
                    <p>{{ $job->currency }}/tháng</p>
                  </div>
                  <a class="btn-theme btn-sm" href="{{ route('jobs.show', $job->slug) }}">Ứng tuyển ngay</a>
                </div>
              </div>
            </div>
            @empty
            <div class="col-12">
              <div class="alert alert-info text-center">
                Chưa có tin tuyển dụng nào.
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </section>
      <!--== End Recent Job Area Wrapper ==-->

      <!--== Start Work Process Area Wrapper ==-->
      <section class="work-process-area">
        <div class="container" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Quy trình tìm việc</h3>
                <div class="desc">
                  <p>Nhanh chóng - Đơn giản - Hiệu quả</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="working-process-content-wrap">
                <div class="working-col">
                  <div class="working-process-item">
                    <div class="icon-box">
                      <div class="inner">
                        <img class="icon-img" src="../client/assets/img/icons/w1.webp" alt="Hình ảnh - HasTech">
                        <img class="icon-hover" src="../client/assets/img/icons/w1-hover.webp" alt="Hình ảnh - HasTech">
                      </div>
                    </div>
                    <div class="content">
                      <h4 class="title">Tạo tài khoản</h4>
                      <p class="desc">Bắt đầu hành trình việc làm với một tài khoản miễn phí.</p>
                    </div>
                    <div class="shape-arrow-icon">
                      <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp" alt="Hình ảnh - HasTech">
                      <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp" alt="Hình ảnh - HasTech">
                    </div>
                  </div>
                </div>
                <div class="working-col">
                  <div class="working-process-item">
                    <div class="icon-box">
                      <div class="inner">
                        <img class="icon-img" src="../client/assets/img/icons/w2.webp" alt="Hình ảnh - HasTech">
                        <img class="icon-hover" src="../client/assets/img/icons/w2-hover.webp" alt="Hình ảnh - HasTech">
                      </div>
                    </div>
                    <div class="content">
                      <h4 class="title">Tạo CV/Hồ sơ</h4>
                      <p class="desc">Hoàn thiện hồ sơ cá nhân để gây ấn tượng với nhà tuyển dụng.</p>
                    </div>
                    <div class="shape-arrow-icon">
                      <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp" alt="Hình ảnh - HasTech">
                      <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp" alt="Hình ảnh - HasTech">
                    </div>
                  </div>
                </div>
                <div class="working-col">
                  <div class="working-process-item">
                    <div class="icon-box">
                      <div class="inner">
                        <img class="icon-img" src="../client/assets/img/icons/w3.webp" alt="Hình ảnh - HasTech">
                        <img class="icon-hover" src="../client/assets/img/icons/w3-hover.webp" alt="Hình ảnh - HasTech">
                      </div>
                    </div>
                    <div class="content">
                      <h4 class="title">Tìm việc phù hợp</h4>
                      <p class="desc">Tìm kiếm và lựa chọn công việc đúng với đam mê và năng lực.</p>
                    </div>
                    <div class="shape-arrow-icon">
                      <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp" alt="Hình ảnh - HasTech">
                      <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp" alt="Hình ảnh - HasTech">
                    </div>
                  </div>
                </div>
                <div class="working-col">
                  <div class="working-process-item">
                    <div class="icon-box">
                      <div class="inner">
                        <img class="icon-img" src="../client/assets/img/icons/w4.webp" alt="Hình ảnh - HasTech">
                        <img class="icon-hover" src="../client/assets/img/icons/w4-hover.webp" alt="Hình ảnh - HasTech">
                      </div>
                    </div>
                    <div class="content">
                      <h4 class="title">Lưu & Ứng tuyển</h4>
                      <p class="desc">Lưu việc yêu thích và ứng tuyển chỉ với một cú nhấp chuột.</p>
                    </div>
                    <div class="shape-arrow-icon d-none">
                      <img class="shape-icon" src="../client/assets/img/icons/right-arrow.webp" alt="Hình ảnh - HasTech">
                      <img class="shape-icon-hover" src="../client/assets/img/icons/right-arrow2.webp" alt="Hình ảnh - HasTech">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--== End Work Process Area Wrapper ==-->

      <!--== Start Divider Area Wrapper ==-->
      <section class="sec-overlay sec-overlay-theme bg-img" data-bg-img="../client/assets/img/photos/bg1.webp">
        <div class="container pt--0 pb--0">
          <div class="row justify-content-center divider-style1">
            <div class="col-lg-10 col-xl-7">
              <div class="divider-content text-center">
                <h4 class="sub-title" data-aos="fade-down">Dùng thử miễn phí</h4>
                <h2 class="title" data-aos="fade-down">Tải ứng dụng di động của chúng tôi.<br>Bạn có thể tạo CV & ứng tuyển mọi lúc mọi nơi.
                </h2>
                <div class="divider-btn-group">
                  <a class="btn-divider" data-aos="fade-down" href="page-not-found.html">
                    <img src="../client/assets/img/photos/google-play.webp" width="201" height="63" class="icon"
                      alt="Google Play">
                  </a>
                  <a class="btn-divider btn-divider-app-store" data-aos="fade-down" href="page-not-found.html">
                    <img src="../client/assets/img/photos/mac-os.webp" width="201" height="63" class="icon" alt="App Store">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-layer-style1"></div>
        <div class="bg-layer-style2"></div>
      </section>
      <!--== End Divider Area Wrapper ==-->

      <!--== Start Team Area Wrapper ==-->
      <section class="team-area">
        <div class="container" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Ứng viên tiêu biểu</h3>
                <div class="desc">
                  <p>Nhiều ứng viên tiềm năng với kỹ năng đa dạng</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Giữ nguyên cấu trúc, chỉ dịch nội dung -->
            <div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="team-item">
                <div class="thumb">
                  <a href="candidate-details.html">
                    <img src="../client/assets/img/team/1.webp" width="160" height="160" alt="Hình ảnh - HasTech">
                  </a>
                </div>
                <div class="content">
                  <h4 class="title"><a href="candidate-details.html">Lauran Benitez</a></h4>
                  <h5 class="sub-title">Nhà thiết kế web</h5>
                  <div class="rating-box">
                    <i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
                  </div>
                  <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                  <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                </div>
                <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Bookmark"></div>
                <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp" alt="Bookmark"></div>
              </div>
            </div>
            <!-- Lặp lại các item khác tương tự -->
          </div>
        </div>
      </section>
      <!--== End Team Area Wrapper ==-->

      <!--== Start Brand Logo Area Wrapper ==-->
      <div class="brand-logo-area">
        <div class="container pt--0 pb--0" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="brand-logo-content">
                <div class="swiper brand-logo-slider-container">
                  <div class="swiper-wrapper">
                    <!-- giữ nguyên hình ảnh -->
                  </div>
                </div>
                <div class="swiper-btn-wrap">
                  <div class="brand-swiper-btn-prev">
                    <i class="icofont-long-arrow-left"></i>
                  </div>
                  <div class="brand-swiper-btn-next">
                    <i class="icofont-long-arrow-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--== End Brand Logo Area Wrapper ==-->

      <!--== Start Testimonial Area Wrapper ==-->
      <section class="testimonial-area bg-color-gray">
        <div class="container" data-aos="fade-down">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Khách hàng hài lòng</h3>
                <div class="desc">
                  <p>Hàng nghìn khách hàng tin tưởng và lựa chọn</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="swiper testi-slider-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="testi-inner-content">
                        <div class="testi-author">
                          <div class="testi-thumb">
                            <img src="../client/assets/img/testimonial/1.webp" width="75" height="75" alt="Khách hàng">
                          </div>
                          <div class="testi-info">
                            <h4 class="name">Roselia Hamets</h4>
                            <span class="designation">Quản lý tuyển dụng</span>
                          </div>
                        </div>
                        <div class="testi-content">
                          <p class="desc">Dịch vụ hỗ trợ rất tốt, giúp tôi nhanh chóng tuyển được ứng viên phù hợp cho công ty.</p>
                          <div class="rating-box">
                            <i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
                          </div>
                          <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp" alt="Quote"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Lặp lại các slide khác, chỉ đổi tên và nội dung -->
                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--== End Testimonial Area Wrapper ==-->

      <!--== Start Blog Area Wrapper ==-->
      <section class="blog-area blog-home-area">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-center">
                <h3 class="title">Tin tức mới nhất</h3>
                <div class="desc">
                  <p>Cập nhật những thông tin thị trường việc làm mới nhất</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center post-home-style row-gutter-40">
            <div class="col-md-6 col-lg-4" data-aos="fade-right">
              <div class="post-item">
                <div class="thumb">
                  <a href="blog-details.html"><img src="../client/assets/img/blog/1.webp" alt="Tin tức" width="370"
                      height="270"></a>
                </div>
                <div class="content">
                  <div class="author">Bởi <a href="blog.html">Walter Houston</a></div>
                  <h4 class="title"><a href="blog-details.html">Những lưu ý khi tìm việc online an toàn, hiệu quả.</a></h4>
                  <div class="meta">
                    <span class="post-date">03 Tháng 4, 2022</span>
                    <span class="dots"></span>
                    <span class="post-time">10 phút đọc</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Lặp lại các post khác tương tự -->
          </div>
        </div>
      </section>
      <!--== End Blog Area Wrapper ==-->
    </main>
@endsection
