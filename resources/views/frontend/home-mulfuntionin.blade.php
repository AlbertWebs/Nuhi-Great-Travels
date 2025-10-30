@extends('layouts.master')

@section('content')
    <!-- Main Slider -->
    @include('components.slider')

    <!-- Sliding Text -->
    <section class="sliding-text-one d-none d-md-block">
        <div class="sliding-text-one__wrap">
            <ul class="sliding-text__list list-unstyled marquee_modes">
                @foreach(['Ride', 'With', 'a', 'Touch', 'of', 'Class'] as $word)
                    <li><h2 data-hover="{{ $word }}" class="sliding-text__title">{{ $word }}</h2></li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Services -->
    <section class="services-one">
        <div class="services-one__shape-1"></div>
        <div class="services-one__shape-2"></div>
        <div class="container">
            <div class="section-title text-center sec-title-animation animation-style1">
                <div class="section-title__tagline-box justify-content-center">
                    <div class="section-title__tagline-shape">
                        <img src="{{ asset('main-html/assets/images/shapes/section-title-tagline-shape-2.png') }}" alt="">
                    </div>
                    <span class="section-title__tagline">Your No #1 Car Rental Partner</span>
                </div>
                <h2 class="section-title__title title-animation">
                    Tailored <strong>Luxury</strong> Experience<br> for Every Journey
                </h2>
            </div>

            <div class="row">
                @php
                    $services = [
                        ['icon' => 'icon-car', 'title' => 'Corporate car rental', 'text' => 'Corporate car rental ensures reliable, professional, and comfortable transportation for business needs.'],
                        ['icon' => 'icon-car-insurance', 'title' => 'Car rental with driver', 'text' => 'Car rental with driver offers safe, convenient, and professional travel for clients.'],
                        ['icon' => 'icon-car-insurance', 'title' => 'Airport transfer', 'text' => 'Reliable airport transfer ensures timely, comfortable, and hassle-free travel for passengers.'],
                        ['icon' => 'icon-car-insurance', 'title' => 'Fleet leasing', 'text' => 'Fleet leasing provides businesses affordable, flexible, and efficient vehicle solutions long-term.']
                    ];
                @endphp

                @foreach ($services as $index => $service)
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeIn{{ $index < 2 ? 'Left' : 'Right' }}" data-wow-delay="{{ ($index + 1) * 200 }}ms" data-wow-duration="1500ms">
                        <div class="services-one__single">
                            <div class="services-one__icon"><span class="{{ $service['icon'] }}"></span></div>
                            <h3 class="services-one__title"><a href="#">{{ $service['title'] }}</a></h3>
                            <p class="services-one__text" style="min-height:100px">{{ $service['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="about-one">
        <div class="container">
            <div class="row flex flex-wrap items-stretch">
                <!-- Image -->
                <div class="col-xl-6 flex">
                    <div class="about-one__lefts wow slideInLeft flex-1 flex flex-col justify-center">
                        <div class="about-one__img-box">
                            <div class="about-one__img">
                                <img style="max-height:740px; object-fit:cover" 
                                     src="{{ $About?->featured_image ? asset('storage/' . $About->featured_image) : asset('main-html/assets/images/default-about.jpg') }}" 
                                     alt="About Nuhi Great Travels">
                            </div>
                            <div class="about-one__experience mt-4">
                                <div class="about-one__experience-count">
                                    <h3 class="odometer" data-count="10">00</h3><span>+</span>
                                </div>
                                <p class="about-one__experience-text">Years of <br>Experience</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text -->
                <div class="col-xl-6 flex">
                    <div class="about-one__right wow slideInRight flex-1 flex flex-col justify-center">
                        <div class="section-title text-left">
                            <div class="section-title__tagline-box">
                                <span class="section-title__tagline">About Nuhi Great Travels</span>
                            </div>
                            <h2 class="section-title__title">Luxury car rental company</h2>
                        </div>
                        <p class="about-one__text-1">Dedicated to delivering exceptional service to every customer.</p>
                        <p class="about-one__text-2">
                            {!! \Illuminate\Support\Str::limit($About?->description ?? 'Information coming soon...', 1000, '...') !!}
                        </p>

                        <div class="about-one__btn-box-and-call-box mt-6 flex items-center gap-4">
                            <a href="{{ route('about') }}" class="about-one__btn thm-btn">Read More <span class="fas fa-arrow-right"></span></a>
                            @if ($Settings?->mobile)
                                <div class="about-one__call-box flex items-center gap-2">
                                    <span class="icon-call-2"></span>
                                    <div>
                                        <p>Call Anytime</p>
                                        <h4><a href="tel:{{ $Settings->mobile }}">{{ $Settings->mobile }}</a></h4>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking -->
    <section class="booking-two pb-100" id="booking">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                    <div class="booking-one__content">
                        <h3 class="booking-one__title">Book a car</h3>
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="booking-one__form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Pickup Date</label>
                                    <input type="datetime-local" name="pickup_datetime">
                                    @error('pickup_datetime') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Dropoff Date</label>
                                    <input type="datetime-local" name="dropoff_datetime">
                                    @error('dropoff_datetime') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Pickup Location</label>
                                    <input type="text" name="pickup_location">
                                    @error('pickup_location') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Your Car Type</label>
                                    <select name="car_id" class="selectmenu wide">
                                        <option value="">Select Car</option>
                                        @forelse (\App\Models\Fleet::all() as $car)
                                            <option value="{{ $car->id }}">{{ $car->name }}</option>
                                        @empty
                                            <option disabled>No cars available</option>
                                        @endforelse
                                    </select>
                                    @error('car_id') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="thm-btn">Book Now <span class="fas fa-arrow-right"></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <img src="{{ asset('/uploads/chauffeur.jpg') }}" alt="Booking Image">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs -->
    <section class="faq-one">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="{{ asset('uploads/chauffeur.jpg') }}" alt="FAQs">
                </div>
                <div class="col-lg-6">
                    <h2>Frequently Asked Questions</h2>
                    @forelse ($faqs as $faq)
                        <div class="accrodion">
                            <h4>{{ $faq->question }}</h4>
                            <p>{{ $faq->answer }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 mt-4">No FAQs available at the moment.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonial-one">
        <div class="container">
            <h2>What Our Clients Say</h2>
            <div class="testimonial-one__carousel owl-carousel owl-theme">
                @forelse ($feedbacks as $feedback)
                    <div class="item">
                        <div class="testimonial-one__single">
                            <div class="testimonial-one__client-info">
                                <img src="{{ $feedback->photo ? asset('storage/' . $feedback->photo) : asset('main-html/assets/images/testimonial/default.jpg') }}" alt="{{ $feedback->name }}">
                                <div>
                                    <h4>{{ $feedback->name }}</h4>
                                    <p>{{ $feedback->position ?? 'Customer' }} {{ $feedback->company ? ', ' . $feedback->company : '' }}</p>
                                </div>
                            </div>
                            <p>{{ $feedback->message }}</p>
                        </div>
                    </div>
                @empty
                    <p>No testimonials yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section class="blog-one">
        <div class="container">
            <h2>Our Latest Blog</h2>
            <div class="blog-one__carousel owl-carousel owl-theme">
                @forelse ($blogs as $blog)
                    <div class="item">
                        <div class="blog-one__single">
                            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('main-html/assets/images/blog/default.jpg') }}" alt="{{ $blog->title }}">
                            <h3><a href="{{ route('blogs.show', $blog->slug) }}">{{ Str::limit($blog->title, 50) }}</a></h3>
                            <p>{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}</p>
                            <a href="{{ route('blogs.show', $blog->slug) }}">Read More</a>
                        </div>
                    </div>
                @empty
                    <p>No blog posts available.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
