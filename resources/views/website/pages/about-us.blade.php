@extends('website.layouts.master')

@section('content')
    <main class="main-content">

        <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
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
    <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title">Về Chúng Tôi</h2>
              <nav class="breadcrumb-area">
                <ul class="breadcrumb justify-content-center">
                  <li><a href="index.html">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Về Chúng Tôi</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== Kết thúc header trang ==-->

    <!--== Bắt đầu khu vực giới thiệu ==-->
    <section class="about-area about-default-wrapper">
      <div class="container">
        <div class="about-item">
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="about-thumb" data-aos="fade-down" data-aos-duration="1000">
                <img src="../client/assets/img/about/1.webp" alt="Về chúng tôi">
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="about-thumb about-thumb-two" data-aos="fade-down" data-aos-duration="1200">
                <img src="../client/assets/img/about/2.webp" alt="Về chúng tôi">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="about-content" data-aos="fade-down" data-aos-duration="1000">
                <h4 class="sub-title">// Giới thiệu Finate</h4>
                <h3 class="title">Finate giúp bạn tìm kiếm công việc mơ ước và xây dựng sự nghiệp vững chắc.</h3>
                <p class="desc">
                  Chúng tôi là nền tảng tuyển dụng hiện đại, kết nối hàng ngàn ứng viên và nhà tuyển dụng mỗi ngày. Đội ngũ Finate cam kết mang lại trải nghiệm tìm việc nhanh chóng, minh bạch và hiệu quả nhất.
                </p>
                <div class="member-join-content" data-aos="fade-right" data-aos-duration="1200">
                  <div class="member-join-thumb">
                    <ul>
                      <li>
                        <a href="candidate-details.html">
                          <img src="../client/assets/img/about/member1.webp" width="50" height="50" alt="Ứng viên">
                        </a>
                      </li>
                      <li>
                        <a href="candidate-details.html">
                          <img src="../client/assets/img/about/member2.webp" width="50" height="50" alt="Ứng viên">
                        </a>
                      </li>
                      <li>
                        <a href="candidate-details.html">
                          <img src="../client/assets/img/about/member3.webp" width="50" height="50" alt="Ứng viên">
                        </a>
                      </li>
                      <li>
                        <a href="candidate-details.html">
                          <img src="../client/assets/img/about/member4.webp" width="50" height="50" alt="Ứng viên">
                        </a>
                      </li>
                      <li>
                        <a href="candidate-details.html">
                          <img src="../client/assets/img/about/member4.webp" width="50" height="50" alt="Ứng viên">
                          <span>+</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="member-join-btn">
                    <a class="join-now-btn" href="job-details.html"><span>+</span> Tham gia ngay</a>
                  </div>
            </div>
        </div>

        <!--== Start About Area Wrapper ==-->
        <section class="about-area about-default-wrapper">
            <div class="container">
                <div class="about-item">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="about-thumb" data-aos="fade-down" data-aos-duration="1000">
                                <img src="../client/assets/img/about/1.webp" alt="Image-HasTech">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="about-thumb about-thumb-two" data-aos="fade-down" data-aos-duration="1200">
                                <img src="../client/assets/img/about/2.webp" alt="Image-HasTech">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-content" data-aos="fade-down" data-aos-duration="1000">
                                <h4 class="sub-title">// Giới thiệu Finate</h4>
                                <h3 class="title">
                                    Finate giúp bạn tìm công việc mơ ước và xây dựng sự nghiệp tươi sáng.
                                </h3>
                                <p class="desc">
                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể đọc được trên
                                    trang khi nhìn vào bố cục. Điểm khác biệt của Lorem Ipsum là nó có phân bố chữ cái khá
                                    tự nhiên, trái ngược với việc sử dụng các gói xuất bản nội dung hay trình chỉnh sửa
                                    trang web.
                                </p>
                                <div class="member-join-content" data-aos="fade-right" data-aos-duration="1200">
                                    <div class="member-join-thumb">
                                        <ul>
                                            <li>
                                                <a href="candidate-details.html">
                                                    <img src="../client/assets/img/about/member1.webp" width="50"
                                                        height="50" alt="Image-HasTech">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="candidate-details.html">
                                                    <img src="../client/assets/img/about/member2.webp" width="50"
                                                        height="50" alt="Image-HasTech">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="candidate-details.html">
                                                    <img src="../client/assets/img/about/member3.webp" width="50"
                                                        height="50" alt="Image-HasTech">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="candidate-details.html">
                                                    <img src="../client/assets/img/about/member4.webp" width="50"
                                                        height="50" alt="Image-HasTech">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="candidate-details.html">
                                                    <img src="../client/assets/img/about/member4.webp" width="50"
                                                        height="50" alt="Image-HasTech">
                                                    <span>+</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="member-join-btn">
                                        <a class="join-now-btn" href="job-details.html"><span>+</span> Tham gia ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End About Area Wrapper ==-->

        <!--== Start Funfact Area Wrapper ==-->
        <section class="funfact-area bg-color-gray">
            <div class="container">
                <div class="row no-gutter">
                    <div class="col-12">
                        <div class="funfact-content-wrap">
                            <div class="funfact-col">
                                <!--== Start Funfact Item ==-->
                                <div class="funfact-item" data-aos="fade-down">
                                    <h2 class="counter-number"><span class="counter"
                                            data-counterup-delay="50">5689</span></h2>
                                    <h6 class="counter-title">Tổng số việc làm</h6>
                                </div>
                                <!--== End Funfact Item ==-->
                            </div>
                            <div class="funfact-col">
                                <!--== Start Funfact Item ==-->
                                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1500">
                                    <h2 class="counter-number"><span class="counter"
                                            data-counterup-delay="50">8567</span></h2>
                                    <h6 class="counter-title">Ứng viên</h6>
                                </div>
                                <!--== End Funfact Item ==-->
                            </div>
                            <div class="funfact-col">
                                <!--== Start Funfact Item ==-->
                                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1700">
                                    <h2 class="counter-number"><span class="counter"
                                            data-counterup-delay="50">7457</span></h2>
                                    <h6 class="counter-title">Hồ sơ</h6>
                                </div>
                                <!--== End Funfact Item ==-->
                            </div>
                            <div class="funfact-col">
                                <!--== Start Funfact Item ==-->
                                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1900">
                                    <h2 class="counter-number"><span class="counter"
                                            data-counterup-delay="50">6483</span></h2>
                                    <h6 class="counter-title">Các công ty</h6>
                                </div>
                                <!--== End Funfact Item ==-->
                            </div>
                            <div class="funfact-col">
                                <!--== Start Funfact Item ==-->
                                <div class="funfact-item" data-aos="fade-down" data-aos-duration="2200">
                                    <h2 class="counter-number"><span class="counter" data-counterup-delay="50">358</span>
                                    </h2>
                                    <h6 class="counter-title">Quốc gia</h6>
                                </div>
                                <!--== End Funfact Item ==-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Funfact Area Wrapper ==-->

        <!--== Start Team Area Wrapper ==-->
        <section class="team-area team-inner-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center" data-aos="fade-down">
                            <h3 class="title">Ứng viên xuất sắc</h3>
                            <div class="desc">
                                <p>Nhiều gói xuất bản bản in và trình chỉnh sửa trang web</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-down">
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <!--== Start Team Item ==-->
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/1.webp" width="160" height="160"
                                        alt="Image-HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Lauran Benitez</a></h4>
                                <h5 class="sub-title">Web Designer</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Image-HasTech"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Image-HasTech"></div>
                        </div>
                        <!--== End Team Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <!--== Start Team Item ==-->
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/2.webp" width="160" height="160"
                                        alt="Image-HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Valentine Anders</a></h4>
                                <h5 class="sub-title">UI/UX Designer</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Image-HasTech"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Image-HasTech"></div>
                        </div>
                        <!--== End Team Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <!--== Start Team Item ==-->
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/3.webp" width="160" height="160"
                                        alt="Image-HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Shakia Aguilera</a></h4>
                                <h5 class="sub-title">Web Designer</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Image-HasTech"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Image-HasTech"></div>
                        </div>
                        <!--== End Team Item ==-->
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <!--== Start Team Item ==-->
                        <div class="team-item">
                            <div class="thumb">
                                <a href="candidate-details.html">
                                    <img src="../client/assets/img/team/4.webp" width="160" height="160"
                                        alt="Image-HasTech">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="candidate-details.html">Assunta Manson</a></h4>
                                <h5 class="sub-title">App. Developer</h5>
                                <div class="rating-box">
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </div>
                                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, jQuery</p>
                                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
                            </div>
                            <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp"
                                    alt="Image-HasTech"></div>
                            <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp"
                                    alt="Image-HasTech"></div>
                        </div>
                        <!--== End Team Item ==-->
                    </div>
                </div>
            </div>
        </section>
        <!--== End Team Area Wrapper ==-->

        <!--== Start Divider Area Wrapper ==-->
        {{-- <section class="sec-overlay sec-overlay-theme bg-img" data-bg-img="../client/assets/img/photos/bg1.webp">
            <div class="container pt--0 pb--0">
                <div class="row justify-content-center divider-style1">
                    <div class="col-lg-7">
                        <div class="divider-content text-center">
                            <h4 class="sub-title" data-aos="fade-down">Có phiên bản dùng thử</h4>
                            <h2 class="title" data-aos="fade-down">
                                Tải ứng dụng di động của chúng tôi.<br>Bạn có thể xem trước hồ sơ &amp; ứng tuyển ngay.
                            </h2>
                            <div class="divider-btn-group">
                                <a class="btn-divider" data-aos="fade-down" href="page-not-found.html">
                                    <img src="../client/assets/img/photos/google-play.webp" width="201" height="63"
                                        class="icon" alt="Image-HasTech">
                                </a>
                                <a class="btn-divider btn-divider-app-store" data-aos="fade-down"
                                    href="page-not-found.html">
                                    <img src="../client/assets/img/photos/mac-os.webp" width="201" height="63"
                                        class="icon" alt="Image-HasTech">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-layer-style1"></div>
            <div class="bg-layer-style2"></div>
        </section> --}}
        <!--== End Divider Area Wrapper ==-->

        <!--== Start Testimonial Area Wrapper ==-->
        <section class="testimonial-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center" data-aos="fade-down">
                            <h3 class="title">Khách hàng hài lòng của chúng tôi</h3>
                            <div class="desc">
                                <p>Nhiều gói xuất bản bản in và trình chỉnh sửa trang web</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" data-aos="fade-down">
                        <div class="swiper testi-slider-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <!--== Start Testimonial Item ==-->
                                    <div class="testimonial-item testimonial-style2-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author d-flex align-items-center">
                                                <div class="testi-thumb me-3">
                                                    <img src="../client/assets/img/testimonial/1.webp" width="75"
                                                        height="75" alt="Image-HasTech">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Roselia Hamets</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">
                                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể
                                                    đọc được trên trang khi nhìn vào bố cục của nó.
                                                </p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote">
                                                    <img src="../client/assets/img/icons/quote1.webp" alt="Image-HasTech">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--== End Testimonial Item ==-->
                                </div>
                                <div class="swiper-slide">
                                    <!--== Start Testimonial Item ==-->
                                    <div class="testimonial-item testimonial-style2-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author d-flex align-items-center">
                                                <div class="testi-thumb me-3">
                                                    <img src="../client/assets/img/testimonial/2.webp" width="75"
                                                        height="75" alt="Image-HasTech">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Assunta Manson</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">
                                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể
                                                    đọc được trên trang khi nhìn vào bố cục của nó.
                                                </p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote">
                                                    <img src="../client/assets/img/icons/quote1.webp" alt="Image-HasTech">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--== End Testimonial Item ==-->
                                </div>
                                <div class="swiper-slide">
                                    <!--== Start Testimonial Item ==-->
                                    <div class="testimonial-item testimonial-style2-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author d-flex align-items-center">
                                                <div class="testi-thumb me-3">
                                                    <img src="../client/assets/img/testimonial/3.webp" width="75"
                                                        height="75" alt="Image-HasTech">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Amira Shepard</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">
                                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể
                                                    đọc được trên trang khi nhìn vào bố cục của nó.
                                                </p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote">
                                                    <img src="../client/assets/img/icons/quote1.webp" alt="Image-HasTech">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--== End Testimonial Item ==-->
                                </div>
                                <div class="swiper-slide">
                                    <!--== Start Testimonial Item ==-->
                                    <div class="testimonial-item testimonial-style2-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author d-flex align-items-center">
                                                <div class="testi-thumb me-3">
                                                    <img src="../client/assets/img/testimonial/4.webp" width="75"
                                                        height="75" alt="Image-HasTech">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Joshua George</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">
                                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể
                                                    đọc được trên trang khi nhìn vào bố cục của nó.
                                                </p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote">
                                                    <img src="../client/assets/img/icons/quote1.webp" alt="Image-HasTech">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--== End Testimonial Item ==-->
                                </div>
                                <div class="swiper-slide">
                                    <!--== Start Testimonial Item ==-->
                                    <div class="testimonial-item testimonial-style2-item">
                                        <div class="testi-inner-content">
                                            <div class="testi-author d-flex align-items-center">
                                                <div class="testi-thumb me-3">
                                                    <img src="../client/assets/img/testimonial/5.webp" width="75"
                                                        height="75" alt="Image-HasTech">
                                                </div>
                                                <div class="testi-info">
                                                    <h4 class="name">Rosie Patton</h4>
                                                    <span class="designation">Quản lý tuyển dụng</span>
                                                </div>
                                            </div>
                                            <div class="testi-content">
                                                <p class="desc">
                                                    Đã là sự thật từ lâu rằng người đọc sẽ bị phân tâm bởi nội dung có thể
                                                    đọc được trên trang khi nhìn vào bố cục của nó.
                                                </p>
                                                <div class="rating-box">
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i><i class="icofont-star"></i>
                                                    <i class="icofont-star"></i>
                                                </div>
                                                <div class="testi-quote">
                                                    <img src="../client/assets/img/icons/quote1.webp" alt="Image-HasTech">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--== End Testimonial Item ==-->
                                </div>
                            </div>
                            <!--== Add Swiper Pagination ==-->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Testimonial Area Wrapper ==-->

        <!--== Start Brand Logo Area Wrapper ==-->
        <div class="brand-logo-area">
            <div class="container pt--0 pb--0" data-aos="fade-down">
                <div class="row">
                    <div class="col-12">
                        <div class="brand-logo-content">
                            <div class="swiper brand-logo-slider-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/1.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/2.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/3.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/4.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/5.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/6.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!--== Start Brand Logo Item ==-->
                                        <div class="brand-logo-item">
                                            <img src="../client/assets/img/brand-logo/1.webp" alt="Image-HasTech">
                                        </div>
                                        <!--== End Brand Logo Item ==-->
                                    </div>
                                </div>
                            </div>
                            <!--== Add Swiper Arrows ==-->
                            <div class="swiper-btn-wrap">
                                <div class="brand-swiper-btn-prev"><i class="icofont-long-arrow-left"></i></div>
                                <div class="brand-swiper-btn-next"><i class="icofont-long-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </section>
    <!--== Kết thúc khu vực giới thiệu ==-->

    <!--== Bắt đầu thống kê nổi bật ==-->
    <section class="funfact-area bg-color-gray">
      <div class="container">
        <div class="row no-gutter">
          <div class="col-12">
            <div class="funfact-content-wrap">
              <div class="funfact-col">
                <div class="funfact-item" data-aos="fade-down">
                  <h2 class="counter-number"><span class="counter" data-counterup-delay="50">5689</span></h2>
                  <h6 class="counter-title">Tổng số việc làm</h6>
                </div>
              </div>
              <div class="funfact-col">
                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1500">
                  <h2 class="counter-number"><span class="counter" data-counterup-delay="50">8567</span></h2>
                  <h6 class="counter-title">Ứng viên</h6>
                </div>
              </div>
              <div class="funfact-col">
                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1700">
                  <h2 class="counter-number"><span class="counter" data-counterup-delay="50">7457</span></h2>
                  <h6 class="counter-title">Hồ sơ ứng tuyển</h6>
                </div>
              </div>
              <div class="funfact-col">
                <div class="funfact-item" data-aos="fade-down" data-aos-duration="1900">
                  <h2 class="counter-number"><span class="counter" data-counterup-delay="50">6483</span></h2>
                  <h6 class="counter-title">Nhà tuyển dụng</h6>
                </div>
              </div>
              <div class="funfact-col">
                <div class="funfact-item" data-aos="fade-down" data-aos-duration="2200">
                  <h2 class="counter-number"><span class="counter" data-counterup-delay="50">358</span></h2>
                  <h6 class="counter-title">Quốc gia</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== Kết thúc thống kê nổi bật ==-->

    <!--== Bắt đầu khu vực ứng viên tiêu biểu ==-->
    <section class="team-area team-inner-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center" data-aos="fade-down">
              <h3 class="title">Ứng viên nổi bật</h3>
              <div class="desc">
                <p>Rất nhiều ứng viên tiềm năng & chuyên nghiệp trên nền tảng</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row" data-aos="fade-down">
          <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="team-item">
              <div class="thumb">
                <a href="candidate-details.html">
                  <img src="../client/assets/img/team/1.webp" width="160" height="160" alt="Ứng viên">
                </a>
              </div>
              <div class="content">
                <h4 class="title"><a href="candidate-details.html">Lauran Benitez</a></h4>
                <h5 class="sub-title">Thiết kế web</h5>
                <div class="rating-box">
                  <i class="icofont-star"></i>
                  <i class="icofont-star"></i>
                  <i class="icofont-star"></i>
                  <i class="icofont-star"></i>
                  <i class="icofont-star"></i>
                </div>
                <p class="desc">CSS3, HTML5, Javascript, Bootstrap, Jquery</p>
                <a class="btn-theme btn-white btn-sm" href="candidate-details.html">Xem hồ sơ</a>
              </div>
              <div class="bookmark-icon"><img src="../client/assets/img/icons/bookmark1.webp" alt="Lưu"></div>
              <div class="bookmark-icon-hover"><img src="../client/assets/img/icons/bookmark2.webp" alt="Lưu"></div>
            </div>
          </div>
          <!-- Lặp lại các team-item tương tự, chỉ dịch nội dung -->
        </div>
      </div>
    </section>
    <!--== Kết thúc khu vực ứng viên tiêu biểu ==-->

    <!--== Bắt đầu khối CTA tải app ==-->
    <section class="sec-overlay sec-overlay-theme bg-img" data-bg-img="../client/assets/img/photos/bg1.webp">
      <div class="container pt--0 pb--0">
        <div class="row justify-content-center divider-style1">
          <div class="col-lg-7">
            <div class="divider-content text-center">
              <h4 class="sub-title" data-aos="fade-down">Có phiên bản dùng thử</h4>
              <h2 class="title" data-aos="fade-down">Tải ứng dụng di động<br>Bạn có thể tạo hồ sơ & ứng tuyển mọi lúc, mọi nơi.</h2>
              <div class="divider-btn-group">
                <a class="btn-divider" data-aos="fade-down" href="page-not-found.html">
                  <img src="../client/assets/img/photos/google-play.webp" width="201" height="63" class="icon" alt="Google Play">
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
    <!--== Kết thúc khối CTA tải app ==-->

    <!--== Bắt đầu nhận xét khách hàng ==-->
    <section class="testimonial-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center" data-aos="fade-down">
              <h3 class="title">Khách hàng hài lòng</h3>
              <div class="desc">
                <p>Hàng nghìn doanh nghiệp & ứng viên đã lựa chọn Finate</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12" data-aos="fade-down">
            <div class="swiper testi-slider-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="testimonial-item testimonial-style2-item">
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
                        <p class="desc">Finate đã giúp chúng tôi kết nối với những ứng viên chất lượng chỉ trong thời gian ngắn!</p>
                        <div class="rating-box">
                          <i class="icofont-star"></i>
                          <i class="icofont-star"></i>
                          <i class="icofont-star"></i>
                          <i class="icofont-star"></i>
                          <i class="icofont-star"></i>
                        </div>
                        <div class="testi-quote"><img src="../client/assets/img/icons/quote1.webp" alt="Quote"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Lặp lại các testimonial khác tương tự, chỉ dịch nội dung -->
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== Kết thúc nhận xét khách hàng ==-->

    <!--== Bắt đầu khu vực logo đối tác ==-->
    <div class="brand-logo-area">
      <div class="container pt--0 pb--0" data-aos="fade-down">
        <div class="row">
          <div class="col-12">
            <div class="brand-logo-content" >
              <div class="swiper brand-logo-slider-container">
                <div class="swiper-wrapper">
                  <!-- giữ nguyên hình ảnh logo -->
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
    <!--== Kết thúc khu vực logo đối tác ==-->

        <!--== End Brand Logo Area Wrapper ==-->

    </main>
@endsection
