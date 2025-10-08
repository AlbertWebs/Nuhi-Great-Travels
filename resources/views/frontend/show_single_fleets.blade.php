@extends('layouts.master-page')

@section('content')

        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{ asset('storage/' . $Fleet->image) }}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>{{$Fleet->name}}</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>{{$Fleet->name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

         <!--Listing Single Start-->
        <section class="listing-single">
            <div class="container">
                <div class="listing-single__top">
                    <div class="listing-single__top-left">
                        <h3 class="listing-single__title">{{$Fleet->name}}</h3>
                        <p class="listing-single__sub-title">{{$Fleet->name}}</p>
                        <div class="listing-single__car-details-box">
                            <ul class="list-unstyled listing-single__car-details">
                                <li>
                                    <span class="icon-date"></span>
                                    <p>{{$Fleet->year}}</p>
                                </li>
                                <li>
                                    <span class="icon-mileage"></span>
                                    <p>80 Miles</p>
                                </li>
                                <li>
                                    <span class="icon-Carrier"></span>
                                    <p>{{$Fleet->transmission}}</p>
                                </li>
                                <li>
                                    <span class="icon-fuel-type"></span>
                                    <p>{{$Fleet->fuel_type}}</p>
                                </li>
                            </ul>
                            <ul class="list-unstyled listing-single__car-details">
                                <li>
                                    <span class="icon-seat"></span>
                                    <p>{{$Fleet->seats}}</p>
                                </li>
                                <li>
                                    <span class="icon-door"></span>
                                    <p>{{$Fleet->type}}</p>
                                </li>
                                <li>
                                    <span class="icon-check"></span>
                                    <p>{{$Fleet->status}}</p>
                                </li>
                                {{-- <li>
                                    <span class="icon-car-insurance"></span>
                                    <p>3 Large bags</p>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="listing-single__top-right">
                        <div class="listing-single__tag">
                            <a href="#">Share <span class="icon-arrow-up-from"></span> </a>
                            <a href="#">Save <span class="icon-bookmark"></span> </a>
                            <a href="#">Compare <span class="icon-compress"></span> </a>
                        </div>
                        <h2 class="listing-single__price">kes {{$Fleet->price_per_day}}</h2>
                        <div class="listing-single__offer-price">
                            <div class="icon">
                                <span class="icon-tag-2"></span>
                            </div>
                            <div class="text">
                                <p>Price Per Day</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listing-single__inner">
                    <div class="listing-single__main-content">
                        <div class="swiper-container" id="listing-single__carousels">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="listing-single__main-content-inner">
                                        <div class="row">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="listing-single__left">
                                                    <div class="listing-single__img">
                                                        <img style="max-height: 523px; object-fit:cover" src="{{ asset('storage/' . $Fleet->image) }}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-7 col-lg-7">
                                                <div class="listing-single__right">

                                                    <p class="listing-single__text"> {!! $Fleet->description !!}</p>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.swiper-slide -->
                            </div>
                        </div>

                    </div>

                    <div class="listing-single__thumb-box">
                        <div class="swiper-container" id="listing-single__thumb">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="listing-single__img-holder-box">
                                        <div class="listing-single__img-holder">
                                            <img src="{{ asset('storage/' . $Fleet->image) }}" alt="">
                                        </div>
                                    </div>
                                </div><!-- /.swiper-slide -->
                                <div class="swiper-slide">
                                    <div class="listing-single__img-holder-box">
                                        <div class="listing-single__img-holder">
                                            <img src="{{ asset('storage/' . $Fleet->image) }}" alt="">
                                        </div>
                                    </div>
                                </div><!-- /.swiper-slide -->
                                <div class="swiper-slide">
                                    <div class="listing-single__img-holder-box">
                                        <div class="listing-single__img-holder">
                                            <img src="{{ asset('storage/' . $Fleet->image) }}" alt="">
                                        </div>
                                    </div>
                                </div><!-- /.swiper-slide -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listing-single__bottom">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="listing-single__bottom-left">
                                <div class="listing-single__description">
                                    <h3 class="listing-single__description-title">Description</h3>
                                    <p class="listing-single__description-text-1">
                                        {!! $Fleet->content !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="listing-single__sidebar">
                                <div class="listing-single__rent-car listing-single__single-box">
                                    <h3 class="listing-single__rent-car-title">Rent This Car</h3>
                                    <div class="listing-single__rent-car-content">
                                        <div class="listing-single__rent-car-content-form">
                                            <div class="listing-single__rent-car-date-box">
                                                <p class="listing-single__rent-car-date-title">Pick-Up
                                                </p>
                                                <div class="listing-single__rent-car-date-time-box">
                                                    <input type="text" placeholder="mm/dd/yyy" name="date"
                                                        id="datepicker">
                                                    <input type="text" name="time" placeholder="Time"
                                                        class="listing-single__rent-car-time-box">
                                                </div>
                                            </div>
                                            <div class="listing-single__rent-car-date-box">
                                                <p class="listing-single__rent-car-date-title">Drop-Off
                                                </p>
                                                <div class="listing-single__rent-car-date-time-box">
                                                    <input type="text" placeholder="mm/dd/yyy" name="date"
                                                        id="datepicker-2">
                                                    <input type="text" name="time" placeholder="Time"
                                                        class="listing-single__rent-car-time-box">
                                                </div>
                                            </div>
                                            <br>
                                            <hr>

                                            <div class="listing-single__rent-car-price-box">
                                                <ul class="list-unstyled">

                                                    <li>
                                                        <div class="title">
                                                            <p>Total Payable</p>
                                                        </div>
                                                        <div class="price">
                                                            <p>kes {{$Fleet->price_per_day}}</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="listing-single__btn-box-2">
                                        <a href="listing-single.html" class="thm-btn">Rent Now<span
                                                class="fas fa-arrow-right"></span></a>
                                    </div>
                                </div>
                                <div class="listing-single__contact-info listing-single__single-box">
                                    <div class="listing-single__contact-phone">
                                        <a href="tel:15502505260" class="listing-single__contact-phone-number"> <span
                                                class="icon-call-3"></span> {{$Settings->mobile}}</a>
                                        <p class="listing-single__contact-phone-text">We are available
                                        </p>
                                    </div>
                                    <div class="listing-single__contact-btn-box">
                                        <a href="tel:{{$Settings->mobile}}"> <i class="icon-phone"></i>Dial a Hire </a>
                                        <a href="{{$Settings->whatsapp}}"> <i class="fab fa-whatsapp"></i>Whatsapp</a>
                                        <a href="{{$Settings->email}}"> <i class="far fa-envelope"></i>Email Address</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Listing Single End-->



@endsection
