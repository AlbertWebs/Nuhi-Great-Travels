@extends('layouts.master')

@section('content')
        <!-- Main Slider Start -->
        @include('components.slider')

        <!--Main Slider Start -->



        <!-- Sliding Text One Start -->
        <section class="sliding-text-one">
            <div class="sliding-text-one__wrap">
                <ul class="sliding-text__list list-unstyled marquee_modes">
                    <li>
                        <h2 data-hover="Ride" class="sliding-text__title">Ride
                            </h2>
                    </li>
                    <li>
                        <h2 data-hover="With" class="sliding-text__title">With</h2>
                    </li>
                    <li>
                        <h2 data-hover="a" class="sliding-text__title">a
                           </h2>
                    </li>
                    <li>
                        <h2 data-hover="Touch" class="sliding-text__title">Touch</h2>
                    </li>
                    <li>
                        <h2 data-hover="of" class="sliding-text__title">of </h2>
                    </li>
                    <li>
                        <h2 data-hover="Class" class="sliding-text__title">Class</h2>
                    </li>
                </ul>
            </div>
        </section>
        <!-- Sliding Text One End -->

        <!-- Services One Start -->
        <section class="services-one">
            <div class="services-one__shape-1"></div>
            <div class="services-one__shape-2"></div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box justify-content-center">
                        <div class="section-title__tagline-shape">
                            <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="">
                        </div>
                        <span class="section-title__tagline">What We’re Offering</span>
                    </div>
                    <h2 class="section-title__title title-animation">Tailored <strong>Luxury</strong> Experience<br> for Every Journey</h2>
                </div>
                <div class="row">
                    <!--Services One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms"
                        data-wow-duration="1500ms">
                        <div class="services-one__single">
                            <div class="services-one__single-shape-1"></div>
                            <div class="services-one__single-shape-2"></div>
                            <div class="services-one__single-shape-3"></div>
                            <div class="services-one__count"></div>
                            <div class="services-one__icon">
                                <span class="icon-car"></span>
                            </div>
                            <h3 class="services-one__title"><a href="services.html">Corporate car rental</a>
                            </h3>
                            <p class="services-one__text" style="min-height:100px">
                                Corporate car rental ensures reliable, professional, and comfortable transportation for business needs.
                            </p>
                        </div>
                    </div>
                    <!--Services One Single End-->
                    <!--Services One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="300ms"
                        data-wow-duration="1500ms">
                        <div class="services-one__single">
                            <div class="services-one__single-shape-1"></div>
                            <div class="services-one__single-shape-2"></div>
                            <div class="services-one__single-shape-3"></div>
                            <div class="services-one__count"></div>
                            <div class="services-one__icon">
                                <span class="icon-car-insurance"></span>
                            </div>
                            <h3 class="services-one__title"><a href="services.html">Car rental with driver</a>
                            </h3>
                            <p class="services-one__text" style="min-height:100px">Car rental with driver offers safe, convenient, and professional travel for clients.</p>
                        </div>
                    </div>
                    <!--Services One Single End-->
                    <!--Services One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="500ms"
                        data-wow-duration="1500ms">
                        <div class="services-one__single">
                            <div class="services-one__single-shape-1"></div>
                            <div class="services-one__single-shape-2"></div>
                            <div class="services-one__single-shape-3"></div>
                            <div class="services-one__count"></div>
                            <div class="services-one__icon">
                                <span class="icon-car-insurance"></span>
                            </div>
                            <h3 class="services-one__title"><a href="services.html">Airport transfer</a></h3>
                            <p class="services-one__text" style="min-height:100px">Reliable airport transfer ensures timely, comfortable, and hassle-free travel for passengers.</p>
                        </div>
                    </div>
                    <!--Services One Single End-->
                    <!--Services One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="700ms"
                        data-wow-duration="1500ms">
                        <div class="services-one__single">
                            <div class="services-one__single-shape-1"></div>
                            <div class="services-one__single-shape-2"></div>
                            <div class="services-one__single-shape-3"></div>
                            <div class="services-one__count"></div>
                            <div class="services-one__icon">
                                <span class="icon-car-insurance"></span>
                            </div>
                            <h3 class="services-one__title"><a href="services.html">Fleet leasing</a></h3>
                            <p class="services-one__text" style="min-height:100px">Fleet leasing provides businesses affordable, flexible, and efficient vehicle solutions long-term.</p>
                        </div>
                    </div>
                    <!--Services One Single End-->
                </div>
            </div>
        </section>
        <!-- Services One End -->

        <!-- About One Start -->
        <section class="about-one">
            <div class="container">
                <div class="row flex flex-wrap items-stretch">
                    <!-- Image Side -->
                    <div class="col-xl-6 flex">
                        <div class="about-one__lefts wow slideInLeft flex-1 flex flex-col justify-center"
                            data-wow-delay="100ms" data-wow-duration="2500ms">
                            <div class="about-one__img-box">
                                <div class="about-one__img">
                                    <img style="max-height:740px; object-fit:cover" class="border-3 border-white w-full h-auto" src="{{ asset('storage/' . $About->featured_image) }}" alt="">
                                </div>
                                <div class="about-one__experience mt-4">
                                    <div class="about-one__experience-count">
                                        <h3 class="odometer" data-count="10">00</h3>
                                        <span>+</span>
                                    </div>
                                    <p class="about-one__experience-text">Years of <br>Experience</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Text Side -->
                    <div class="col-xl-6 flex">
                        <div class="about-one__right wow slideInRight flex-1 flex flex-col justify-center">
                            <div class="section-title text-left sec-title-animation animation-style1">
                                <div class="section-title__tagline-box">
                                    <div class="section-title__tagline-shape">
                                        <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="Nuhi Great Travels">
                                    </div>
                                    <span class="section-title__tagline">About Nuhi Great Travels</span>
                                </div>
                                <h2 class="section-title__title title-animation">Luxury car rental company</h2>
                            </div>
                            <p class="about-one__text-1">Dedicated to delivering exceptional service to every customer.</p>
                            <p class="about-one__text-2">
                                {!! \Illuminate\Support\Str::limit($About->description, 1000, '...') !!}
                            </p>
                            <div class="about-one__btn-box-and-call-box mt-6 flex items-center gap-4">
                                <div class="about-one__btn-box">
                                    <a href="{{route('about')}}" class="about-one__btn thm-btn">Read More
                                        <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="about-one__call-box flex items-center gap-2">
                                    <div class="about-one__call-box-icon">
                                        <span class="icon-call-2"></span>
                                    </div>
                                    <div class="about-one__call-box-content">
                                        <p>Call Anytime</p>
                                        <h4><a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About One End -->

        <!--Booking Two Start -->
        <section class="booking-two pb-100" id="booking">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="booking-two__left">
                            <div class="booking-one__content">
                                <div class="booking-one__title-box">
                                    <div class="booking-one__title-shape"
                                        style="background-image: url(assets/images/shapes/book-one-title-shape-1.png);">
                                    </div>
                                    <h3 class="booking-one__title">Book a car</h3>
                                </div>
                                <form class="contact-form-validated booking-one__form" action="https://dreamlayout.mnsithub.com/html/gorent/main-html/assets/inc/sendemail.php"
                                    method="post" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title"> <span class="icon-pin-2"></span>
                                                    Pickup</p>
                                                <div class="select-box">
                                                    <select class="selectmenu wide">
                                                        <option selected="selected">Enter a Location</option>
                                                        <option>Enter a Location 01</option>
                                                        <option>Enter a Location 02</option>
                                                        <option>Enter a Location 03</option>
                                                        <option>Enter a Location 04</option>
                                                        <option>Enter a Location 05</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title"> <span class="icon-pin-2"></span>
                                                    Drop of</p>
                                                <div class="select-box">
                                                    <select class="selectmenu wide">
                                                        <option selected="selected">Enter a Location</option>
                                                        <option>Enter a Location 01</option>
                                                        <option>Enter a Location 02</option>
                                                        <option>Enter a Location 03</option>
                                                        <option>Enter a Location 04</option>
                                                        <option>Enter a Location 05</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title"> <span class="icon-cuv"></span>
                                                    Your car type</p>
                                                <div class="select-box">
                                                    <select class="selectmenu wide">
                                                        <option selected="selected">Your Car Type
                                                        </option>
                                                        <option>Your Car Type 01</option>
                                                        <option>Your Car Type 02</option>
                                                        <option>Your Car Type 03</option>
                                                        <option>Your Car Type 04</option>
                                                        <option>Your Car Type 05</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title"> <span class="icon-date"></span>
                                                    Date</p>
                                                <input type="text" placeholder="mm/dd/yyy" name="date" id="datepicker">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="booking-one__btn-box">
                                                <button type="submit" class="thm-btn">Book Now<span
                                                        class="fas fa-arrow-right"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="result"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="booking-two__right">
                            <div class="booking-two__img reveal">
                                <img src="{{asset('/uploads')}}/chauffeur.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Booking Two Start -->

        <!--Lets Talk Start -->
        <section class="lets-talk">
            <div class="lets-talk__bg" style="background-image: url(assets/images/backgrounds/lets-talk-bg.jpg);"></div>
            <div class="container">
                <div class="lets-talk__inner">
                    <div class="lets-talk__title">
                        <p>Rent Your Car</p>
                        <h2>Interested in Renting?</h2>
                    </div>
                    <div class="lets-talk__btn-boxes">
                        <div class="lets-talk__btn-1">
                            <a href="contact.html" class="thm-btn">Contact Us<span
                                    class="fas fa-arrow-right"></span></a>
                        </div>
                        <div class="lets-talk__btn-2">
                            <a href="car-list-v-1.html" class="thm-btn">Rent Now<span
                                    class="fas fa-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Lets Talk End -->

        <!-- Counter Two Start -->
        <section class="counter-two">
            <div class="container">
                <div class="counter-two__inner">
                    <ul class="list-unstyled counter-two__list">
                        <li class="wow fadeInLeft" data-wow-delay="100ms" data-wow-duration="1500ms">
                            <div class="counter-two__single">
                                <div class="counter-two__shape-1"></div>
                                <div class="counter-two__shape-2"></div>
                                <div class="counter-two__single-inner">
                                    <div class="counter-two__icon">
                                        <span class="icon-car"></span>
                                    </div>
                                    <div class="counter-two__count-box">
                                        <h3 class="odometer" data-count="1000">00</h3>
                                        <span>+</span>
                                    </div>
                                    <p class="counter-two__count-text">Vehicle fleet</p>
                                </div>
                            </div>
                        </li>
                        <li class="wow fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="counter-two__single">
                                <div class="counter-two__shape-1"></div>
                                <div class="counter-two__shape-2"></div>
                                <div class="counter-two__single-inner">
                                    <div class="counter-two__icon">
                                        <span class="icon-mileage"></span>
                                    </div>
                                    <div class="counter-two__count-box">
                                        <h3 class="odometer" data-count="10">00</h3>
                                        <span>M+</span>
                                    </div>
                                    <p class="counter-two__count-text">Miles of drive</p>
                                </div>
                            </div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="300ms" data-wow-duration="1500ms">
                            <div class="counter-two__single">
                                <div class="counter-two__shape-1"></div>
                                <div class="counter-two__shape-2"></div>
                                <div class="counter-two__single-inner">
                                    <div class="counter-two__icon">
                                        <span class="icon-range"></span>
                                    </div>
                                    <div class="counter-two__count-box">
                                        <h3 class="odometer" data-count="15">00</h3>
                                        <span>K+</span>
                                    </div>
                                    <p class="counter-two__count-text">Booking reserved</p>
                                </div>
                            </div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="400ms" data-wow-duration="1500ms">
                            <div class="counter-two__single">
                                <div class="counter-two__shape-1"></div>
                                <div class="counter-two__shape-2"></div>
                                <div class="counter-two__single-inner">
                                    <div class="counter-two__icon">
                                        <span class="icon-pin-2"></span>
                                    </div>
                                    <div class="counter-two__count-box">
                                        <h3 class="odometer" data-count="50">00</h3>
                                        <span>K+</span>
                                    </div>
                                    <p class="counter-two__count-text">Pickup & drop</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Counter Two End -->



        <section class="about-one pb-100">
            <div class="container">
                <div class="row flex flex-wrap items-stretch">
                    <!-- Text Side -->
                    <div class="col-xl-6 position-relative" style="height:640px;">
                        <div class="wow slideInLeft gpt-center-this position-absolute top-50 translate-middle-y">
                            <div class="section-title text-left sec-title-animation animation-style1">
                                <div class="section-title__tagline-box">
                                    <div class="section-title__tagline-shape">
                                        <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="Nuhi Great Travels">
                                    </div>
                                </div>
                                <h2 class="section-title__title title-animation">Self-Drive Rentals</h2>
                            </div>

                            <p class="about-one__text-2 mt-4">
                                Enjoy the freedom to explore at your own pace with our premium self-drive rentals. Choose from our fleet of well-maintained vehicles and experience comfort, privacy, and flexibility on every journey.
                                <br><br>
                                Whether you are on a weekend getaway, business trip, or simply want to enjoy a scenic drive, our self-drive options give you the independence to create your own adventure with confidence and style.
                            </p>

                            <div class="about-one__btn-box-and-call-box mt-6 flex items-center gap-4">
                                <div class="about-one__btn-box">
                                    <a href="#booking" class="about-one__btn thm-btn">Book Now
                                        <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="lets-talk__btn-2">
                                    <a href="car-list-v-1.html" class="thm-btn">Check Fleet<span class="fas fa-arrow-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Side -->
                    <div class="col-xl-6 flex">
                        <div class="about-one__lefts wow slideInRight flex-1 flex items-center justify-center"
                            data-wow-delay="100ms" data-wow-duration="2500ms">
                            <div class="about-one__img-box w-full">
                                <div class="about-one__img">
                                    <img style="max-height:640px; object-fit:cover"
                                        class="border-3 border-white w-full h-auto"
                                        src="{{url('/')}}/uploads/self-drive.jpg" alt="Self Drive Rentals Nuhi Great Travels">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Faq One Start -->
        <section class="faq-one">
            <div class="faq-one__shape-1"></div>
            <div class="faq-one__shape-2"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-5">
                        <div class="faq-one__left">
                            <div class="section-title text-left sec-title-animation animation-style2">
                                <div class="section-title__tagline-box">
                                    <div class="section-title__tagline-shape">
                                        <img src="{{ asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png') }}" alt="">
                                    </div>
                                    <span class="section-title__tagline">Our Faqs</span>
                                </div>
                                <h2 class="section-title__title title-animation">Frequently Asking Any Question</h2>
                            </div>

                            <div class="faq-one__img-box">
                                <div class="faq-one__img reveal">
                                    <img src="{{ asset('uploads/chauffeur.jpg') }}" alt="Nuhi Great Travels">
                                </div>
                                <div class="faq-one__experience-box">
                                    <div class="faq-one__experience-year">
                                        <h2 class="odometer" data-count="10">00</h2>
                                    </div>
                                    <p class="faq-one__experience-text">Year of <br> experience</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-7">
                        <div class="faq-one__right">
                            <div class="accrodion-grp" data-grp-name="faq-one-accrodion">
                                @foreach($faqs as $index => $faq)
                                    <div class="accrodion wow fadeIn{{ $index % 2 == 0 ? 'Left' : 'Right' }}"
                                        data-wow-delay="{{ $index * 100 }}ms" data-wow-duration="1500ms">
                                        <div class="accrodion-title {{ $loop->first ? 'active' : '' }}">
                                            <h4>{{ $faq->question }}</h4>
                                        </div>
                                        <div class="accrodion-content {{ $loop->first ? 'active' : '' }}">
                                            <div class="inner">
                                                <p>{{ $faq->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if($faqs->isEmpty())
                                    <p class="text-gray-500 mt-4">No FAQs available at the moment.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Faq One End -->

        <section class="about-one pb-100">
            <div class="container">
                <div class="row flex flex-wrap items-stretch">
                     <!-- Image Side -->
                    <div class="col-xl-6 flex">
                        <div class="about-one__lefts wow slideInLeft flex-1 flex items-center justify-center"
                            data-wow-delay="100ms" data-wow-duration="2500ms">
                            <div class="about-one__img-box w-full">
                                <div class="about-one__img">
                                    <img style="max-height:640px; object-fit:cover"
                                        class="border-3 border-white w-full h-auto"
                                        src="{{url('/')}}/uploads/airport.jpg" alt="Airport Transfers Nuhi Great Travels">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Text Side -->
                    <div class="col-xl-6 position-relative" style="height:640px;">
                        <div class="wow slideInRight gpt-center-this position-absolute top-50 translate-middle-y">
                            <div class="section-title text-left sec-title-animation animation-style1">
                                <div class="section-title__tagline-box">
                                    <div class="section-title__tagline-shape">
                                        <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="Nuhi Great Travels">
                                    </div>
                                </div>
                                <h2 class="section-title__title title-animation">Airport Tranfers</h2>
                            </div>

                            <p class="about-one__text-2 mt-4">
                                Enjoy the freedom to explore at your own pace with our premium self-drive rentals. Choose from our fleet of well-maintained vehicles and experience comfort, privacy, and flexibility on every journey.
                                <br><br>
                                Whether you are on a weekend getaway, business trip, or simply want to enjoy a scenic drive, our self-drive options give you the independence to create your own adventure with confidence and style.
                            </p>

                            <div class="about-one__btn-box-and-call-box mt-6 flex items-center gap-4">
                                <div class="about-one__btn-box">
                                    <a href="#booking" class="about-one__btn thm-btn">Book Now
                                        <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="lets-talk__btn-2">
                                    <a href="car-list-v-1.html" class="thm-btn">Check Fleet<span class="fas fa-arrow-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>



        <!--Call One Start -->
        <section class="call-one">
            <div class="container">
                <div class="call-one__inner wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="call-one__inner-content">
                        <div class="call-one__bg"
                            style="background-image: url('{{asset('main-html/assets/images/backgrounds/call-one-bg.jpg')}}');">
                        </div>
                        <div class="call-one__left">
                            <p class="call-one__sub-title">Available 24/7</p>
                            <h4 class="call-one__title">Call Any Time For Booking</h4>
                        </div>
                        <div class="call-one__details">
                            <div class="call-one__icon">
                                <span class="icon-call-2"></span>
                            </div>
                            <div class="call-one__content">
                                <p>Call Us Now</p>
                                <h4><a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}}</a></h4>
                            </div>
                        </div>
                        <div class="call-one__btn-box">
                            <a href="car-list-v-1.html" class="thm-btn">Rent Now<span
                                    class="fas fa-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Call One End -->

        <!-- Popular Car One Start -->
        <section class="popular-car-one">
            <div class="popular-car-one__bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
                style="background-image: url('{{asset('main-html/assets/images/backgrounds/popular-car-one-bg.jpg')}}');"></div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box justify-content-center">
                        <div class="section-title__tagline-shape">
                            <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="">
                        </div>
                        <span class="section-title__tagline">Popular Car</span>
                    </div>
                    <h2 class="section-title__title title-animation">Most Popular Cartypes</h2>
                </div>
                <div class="popular-car-one__carousel owl-carousel owl-theme">
                    <?php $Cars = DB::table('cars')->get(); ?>
                    @foreach ($Cars as $cars)
                    <!-- Popular Car One Single Start -->
                    <div class="item">
                        <div class="popular-car-one__single">
                            <div class="popular-car-one__icon">
                                <span class="icon-sports-car"></span>
                            </div>
                            <div class="popular-car-one__single-inner">
                                <h4 class="popular-car-one__title"><a href="car-list-v-1.html">{{$cars->make}}</a></h4>
                            </div>
                            <?php $countFleet = DB::table('fleets')->where('car_id', $cars->id)->count(); ?>
                            <p class="popular-car-one__count">{{$countFleet}} Cars</p>
                        </div>
                    </div>
                    <!-- Popular Car One Single End -->
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Popular Car One End -->

        <!-- Testimonial One Start -->
        <section class="testimonial-one">
            <div class="container">
                <div class="section-title text-left sec-title-animation animation-style2">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape">
                            <img src="{{asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png')}}" alt="">
                        </div>
                        <span class="section-title__tagline">Our Testimonial</span>
                    </div>
                    <h2 class="section-title__title title-animation">What Our Clients Say</h2>
                </div>
               <div class="testimonial-one__carousel owl-theme owl-carousel">
                    @foreach($feedbacks as $feedback)
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__client-info">
                                    <div class="testimonial-one__img">
                                        @if($feedback->photo)
                                            <img src="{{ asset('storage/' . $feedback->photo) }}" alt="{{ $feedback->name }}">
                                        @else
                                            <img src="{{ asset('main-html/assets/images/testimonial/default.jpg') }}" alt="Default">
                                        @endif
                                    </div>
                                    <div class="testimonial-one__content">
                                        <h4 class="testimonial-one__client-name">
                                            <a href="#">{{ $feedback->name }}</a>
                                        </h4>
                                        <p class="testimonial-one__sub-title">
                                            {{ $feedback->position ?? 'Customer' }}
                                            @if($feedback->company)
                                                , {{ $feedback->company }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <p class="testimonial-one__text">{{ $feedback->message }}</p>

                                <div class="testimonial-one__rating">
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                    <span class="icon-star"></span>
                                </div>

                                <div class="testimonial-one__quote">
                                    <span class="icon-quote"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
        <!-- Testimonial One End -->


        <!--Lets Talk Start -->
        <section class="lets-talk">
            <div class="lets-talk__bg" style="background-image: url(assets/images/backgrounds/lets-talk-bg.jpg);"></div>
            <div class="container">
                <div class="lets-talk__inner">
                    <div class="lets-talk__title">
                        <p>We Dont Just Rent</p>
                        <h2>Would You Rather Buy a Car?</h2>
                    </div>
                    <div class="lets-talk__btn-boxes">
                        <div class="lets-talk__btn-1">
                            <a href="tel:+254712675673" class="thm-btn">Call Us<span
                                    class="fas fa-arrow-right"></span></a>
                        </div>
                        <div class="lets-talk__btn-2">
                            <a href="{{route('contact-us')}}" class="thm-btn">Leave Us a Message<span
                                    class="fas fa-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Lets Talk End -->




        <!--Blog One Start-->
        <section class="blog-one">
            <div class="blog-one__shape-1"></div>
            <div class="blog-one__shape-2"></div>
            <div class="container">
                <div class="section-title text-left sec-title-animation animation-style2">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape">
                            <img src="{{ asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png') }}" alt="">
                        </div>
                        <span class="section-title__tagline">Our Blog</span>
                    </div>
                    <h2 class="section-title__title title-animation">Our Latest Blog</h2>
                </div>

                <div class="blog-one__carousel owl-carousel owl-theme">
                    @foreach ($blogs as $blog)
                        <div class="item">
                            <div class="blog-one__single">
                                <div class="blog-one__img-box">
                                    <div class="blog-one__img">
                                        <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('main-html/assets/images/blog/default.jpg') }}" alt="{{ $blog->title }}">
                                        <div class="blog-one__tags">
                                            <span>{{ $blog->category ?? 'General' }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-one__date">
                                        <p>{{ $blog->created_at->format('d') }}</p>
                                        <span>{{ $blog->created_at->format('M') }}</span>
                                    </div>
                                </div>

                                <div class="blog-one__content">
                                    <ul class="blog-one__meta list-unstyled">
                                        <li>
                                            <a href="{{ route('blogs.show', $blog->slug) }}">
                                                <span class="fas fa-user"></span> {{ $blog->author ?? 'Admin' }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('blogs.show', $blog->slug) }}">
                                                <span class="fas fa-comments"></span> 0 Comments
                                            </a>
                                        </li>
                                    </ul>
                                    <h3 class="blog-one__title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">{{ Str::limit($blog->title, 50) }}</a>
                                    </h3>
                                    <p class="blog-one__text">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}</p>
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-one__read-more">
                                        Read More <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--Blog One End-->


@endsection
