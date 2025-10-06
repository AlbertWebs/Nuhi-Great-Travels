@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>Contact</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

        <!--Contact Info Start-->
        <section class="contact-info">
            <div class="container">
                <div class="row">
                    <!--Contact Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="contact-info__single">
                            <div class="contact-info__icon">
                                <span class="icon-call"></span>
                            </div>
                            <p>Contact Us</p>
                            <h3><a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}}</a></h3>
                        </div>
                    </div>
                    <!--Contact Two Single End-->
                    <!--Contact Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <div class="contact-info__single">
                            <div class="contact-info__icon">
                                <span class="icon-email"></span>
                            </div>
                            <p>Mail Us</p>
                            <h3><a href="mailto:{{$Settings->email}}">{{$Settings->email}}</a></h3>
                        </div>
                    </div>
                    <!--Contact Two Single End-->
                    <!--Contact Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInRight" data-wow-delay="300ms">
                        <div class="contact-info__single">
                            <div class="contact-info__icon">
                                <span class="icon-location"></span>
                            </div>
                            <p>Our Office Location</p>
                            <h3>{{$Settings->location}}</h3>
                        </div>
                    </div>
                    <!--Contact Two Single End-->
                </div>
            </div>
        </section>
        <!--Contact Info End-->

        <!--Contact Page Start-->
        <section class="contact-page">
            <div class="container">
                <div class="contact-page__inner">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="contact-page__left">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8004567847393!2d36.7876407!3d-1.2942407999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f113d23794a97%3A0xb39310a139138d6!2sDesignekta%20Studios!5e0!3m2!1sen!2ske!4v1759746486155!5m2!1sen!2ske"
                                    class="google-map__one" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact-page__right">
                                <h3 class="contact-page__form-title">Leave us a Message</h3>
                               <form id="contact-form" class="contact-form-validated contact-page__form"
                                    action="{{ route('contact.submit') }}" method="POST">

                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-page__input-box">
                                                <input type="text" name="name" placeholder="Your name" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-page__input-box">
                                                <input type="email" name="email" placeholder="Your Email" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-page__input-box">
                                                <input type="text" placeholder="Mobile" name="number" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="contact-page__input-box">
                                                <input type="text" placeholder="Company" name="company" required="">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="contact-page__input-box text-message-box">
                                                <textarea name="message" placeholder="Messege" required=""></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="contact-page__btn-box">
                                                        <button type="submit" class="thm-btn contact-page__btn"
                                                            data-loading-text="Please wait...">
                                                            <span class="thm-btn-text">Send A Message</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <p class="ajax-response mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact Page End-->

@endsection
