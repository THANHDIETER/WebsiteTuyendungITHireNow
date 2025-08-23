@extends('website.layouts.master')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area sec-overlay sec-overlay-black d-flex justify-content-center align-items-center text-center"
            data-bg-img="{{ asset('client/assets/img/banner/15.png') }}"
            style="max-height: 80px; height: 80px; padding: 0 !important;">
            &nbsp;
        </div>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Contact Area Wrapper ==-->
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
                                        Carolina (NC), 28468
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--== Start Contact Form ==-->
                        <div class="contact-form">
                            <h4 class="contact-form-title">Liên hệ với chúng tôi</h4>
                            <form id="contact-form" action="https://whizthemes.com/mail-php/raju/arden/mail.php"
                                method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="con_name"
                                                placeholder="Họ và tên:">
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
                                            <textarea class="form-control" name="con_message"
                                                placeholder="Tin nhắn"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb--0">
                                            <button class="btn-theme d-block w-100" type="submit">Gửi tin nhắn</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--== End Contact Form ==-->
                        <!--== Message Notification ==-->
                        <div class="form-message"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="map-area">
                            <iframe src="https://maps.google.com/maps?q=Việt%20Nam&t=&z=6&ie=UTF8&iwloc=&output=embed"
                                width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--== End Contact Area Wrapper ==-->
    </main>
@endsection