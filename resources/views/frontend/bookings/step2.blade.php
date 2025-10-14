@extends('layouts.master-page')

@section('content')
<br><br><br>

        <!--Booking Two Start -->
        <section class="booking-two pb-100" id="booking">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-6">
                        <div class="booking-two__lefts">
                            <div class="booking-one__content">
                                <div class="booking-one__title-box">
                                    <div class="booking-one__title-shape"
                                        style="background-image: url(assets/images/shapes/book-one-title-shape-1.png);">
                                    </div>
                                    <h3 class="booking-one__title">Your Info</h3>
                                </div>
                                <form class="contact-form-validateds booking-one__form"
                                    action="{{ route('bookings.storeStep2') }}"
                                    method="POST"
                                    novalidate="novalidate">
                                    @csrf
                                    <div class="row">
                                        {{-- Full Name --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title">
                                                    <span class="icon-user"></span> Full Name
                                                </p>
                                                <input type="text" name="full_name"
                                                    value="{{ old('full_name', session('booking.step2.full_name')) }}"
                                                    required
                                                    placeholder="Enter your full name">
                                                @error('full_name')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Email Address --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title">
                                                    <span class="icon-email"></span> Email Address
                                                </p>
                                                <input type="email" name="email"
                                                    value="{{ old('email', session('booking.step2.email')) }}"
                                                    required
                                                    placeholder="Enter your email">
                                                @error('email')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Mobile Number --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title">
                                                    <span class="icon-phone"></span> Mobile Number
                                                </p>
                                                <input type="text" name="mobile"
                                                    value="{{ old('mobile', session('booking.step2.mobile')) }}"
                                                    required
                                                    placeholder="Enter your mobile number">
                                                @error('mobile')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Auto-calculated Total Price (read-only) --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="booking-one__input-box">
                                                <p class="booking-one__input-title">
                                                    <span class="icon-cash"></span> Total Price({{ session('booking.step1.car') ?? '' }} For {{ session('booking.step1.days') ?? '' }})
                                                </p>
                                                <input type="text" name="total_price"
                                                    value="{{ session('booking.step1.total_price') ?? '' }}"
                                                    readonly
                                                    class="bg-gray-100">
                                            </div>
                                        </div>

                                        {{-- Submit --}}
                                        <div class="col-xl-12">
                                            <div class="booking-one__btn-box">
                                                <button type="submit" class="thm-btn">
                                                    Next Step(KYC) <span class="fas fa-arrow-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="result"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--Booking Two Start -->

@endsection
