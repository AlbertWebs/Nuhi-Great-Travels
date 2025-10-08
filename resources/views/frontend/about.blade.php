@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>About Us</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>About Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

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
                                    <a href="{{route('single_fleet', 'suv')}}" class="about-one__btn thm-btn">Our Fleet
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

        <section class="feature-one">
            <div class="container">
                <div class="feature-one__inner">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="feature-one__inner-single wow slideInLeft animated" data-wow-delay="100ms" data-wow-duration="2500ms" style="visibility: visible; animation-duration: 2500ms; animation-delay: 100ms; animation-name: slideInLeft;">
                                <div class="feature-one__inner-single-bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/feature-one-bg-1.jpg')}}');">
                                </div>
                                <h3 class="feature-one__inner-title">Are You Looking <br>to Rent a Car ?</h3>
                                <p class="feature-one__inner-text">
                                     Kenya's premier luxury and executive rental service. We provide a modern, safe fleet and tailored services—from corporate leasing to airport transfers—to ensure your journey is always comfortable and seamless
                                </p>
                                <div class="feature-one__inner-btn-box">
                                    <a href="{{route('single_fleet', 'suv')}}" class="thm-btn">Get Started</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="feature-one__inner-single feature-one__inner-single--two wow slideInRight animated" data-wow-delay="100ms" data-wow-duration="2500ms" style="visibility: visible; animation-duration: 2500ms; animation-delay: 100ms; animation-name: slideInRight;">
                                <div class="feature-one__inner-single-bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/feature-one-bg-2.jpg')}}');">
                                </div>
                                <h3 class="feature-one__inner-title">Would you rather Buy <br> the Car ?</h3>
                                <p class="feature-one__inner-text">
                                    Beyond our premium rentals, perhaps a long-term strategy suits you better.
                                     We specialize in corporate fleet solutions and customized leasing plans, offering a straightforward path to permanent acquisition for your business or executive requirements.
                                </p>
                                <div class="feature-one__inner-btn-box">
                                    <a href="tel:+254 712 675 673" class="thm-btn">
                                        Call Now
                                        <i class="fa fa-phone"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       <section class="brand-two">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="brand-two__left">
                            <p class="brand-two__text">We have <span>over 10 trusted</span> <br> brands worldwide</p>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <div class="brand-two__right">
                            <div class="brand-two__carousel owl-theme owl-carousel owl-loaded owl-drag">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage" style="transform: translate3d(-1485px, 0px, 0px); transition: 0.5s; width: 3218px;">
                                    {{-- @foreach($clients as $client)
                                    <div class="owl-item cloned" style="width: 217.5px; margin-right: 30px;">
                                        <div class="item">
                                            <div class="brand-two__single">
                                                <div class="brand-two__img">
                                                <a href="#"> <img src="{{ $client->image ? asset('storage/' . $client->image) : asset('images/default-logo.png') }}" alt="{{ $client->name }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach --}}
                                    @foreach($clients as $client)
                                    <div class="owl-item cloned" style="width: 217.5px; margin-right: 30px;">
                                        <div class="item">
                                            <div class="brand-two__single">
                                                <div class="brand-two__img">
                                                <a href="#"><img style="width:256px; height:150px; object-fit:cover;" src="{{ $client->image ? asset('storage/' . $client->image) : asset('images/default-logo.png') }}" alt="{{ $client->name }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span class="icon-left-arrow"></span></button><button type="button" role="presentation" class="owl-next"><span class="icon-next"></span></button></div>
                                <div class="owl-dots disabled"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



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
