@extends('website.layouts.master')

@section('content')
  <main class="main-content">
    <!--== Bắt đầu header trang ==-->
    <div class="page-header-area sec-overlay sec-overlay-black" data-bg-img="../client/assets/img/photos/bg2.webp">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title">Liên hệ</h2>
              <nav class="breadcrumb-area">
                <ul class="breadcrumb justify-content-center">
                  <li><a href="index.html">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Liên hệ</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== Kết thúc header trang ==-->

    <!--== Bắt đầu khu vực liên hệ ==-->
    <section class="contact-area contact-page-area">
      <div class="container">
        <div class="row contact-page-wrapper">
          <div class="col-lg-12">
            <div class="contact-info-wrap">
              <div class="info-item">
                <div class="icon">
                  <img src="../client/assets/img/icons/c1.webp" alt="Hình ảnh" width="42" height="42">
                </div>
                <div class="info">
                  <h5 class="title">Gọi cho chúng tôi:</h5>
                  <p>
                    <a href="tel://568975468">(00) 568 975 468</a><br>
                    <a href="tel://+88465748937">+88 465 748 937</a>
                  </p>
                </div>
              </div>
              <div class="info-item">
                <div class="icon">
                  <img src="../client/assets/img/icons/c2.webp" alt="Hình ảnh" width="43" height="73">
                </div>
                <div class="info">
                  <h5 class="title">Email:</h5>
                  <p>
                    <a href="mailto://youremail@gmail.com">youremail@gmail.com</a><br>
                    <a href="mailto://demomail@gmail.com">demomail@gmail.com</a>
                  </p>
                </div>
              </div>
              <div class="info-item">
                <div class="icon">
                  <img src="../client/assets/img/icons/c3.webp" alt="Hình ảnh" width="36" height="46">
                </div>
                <div class="info">
                  <h5 class="title">Địa chỉ:</h5>
                  <p>
                    Sunset Beach, North <br>
                    Carolina(NC), 28468
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <!--== Bắt đầu Form Liên Hệ ==-->
            <div class="contact-form">
              <h4 class="contact-form-title">Liên hệ với chúng tôi</h4>
              <form id="contact-form" action="https://whizthemes.com/mail-php/raju/arden/mail.php" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input class="form-control" type="text" name="con_name" placeholder="Họ và tên:">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input class="form-control" type="email" name="con_email" placeholder="Email:">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input class="form-control" type="text" placeholder="Tiêu đề:">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea class="form-control" name="con_message" placeholder="Nội dung"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group mb--0">
                      <button class="btn-theme d-block w-100" type="submit">Gửi liên hệ</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!--== Kết thúc Form Liên Hệ ==-->

            <!--== Thông báo sau khi gửi ==-->
            <div class="form-message"></div>
          </div>
          <div class="col-lg-6">
            <div class="map-area">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1912972.6636523942!2d144.28416561146162!3d-38.05127959850456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad646b5d2ba4df7%3A0x4045675218ccd90!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sbd!4v1634028820404!5m2!1sen!2sbd"></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== Kết thúc khu vực liên hệ ==-->
  </main>
@endsection
