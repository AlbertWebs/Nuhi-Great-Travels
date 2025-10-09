@extends('layouts.master-page')

@section('title', $Fleet->name . ' | Vehicle Details')

@section('content')
<!-- ===== Page Header (Keep your existing header) ===== -->
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
<!-- ===== Vehicle Gallery + Booking Section ===== -->
<section class="py-5 bg-light">
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
        <div class="row g-4 align-items-start">
            <!-- Left Column: Image Gallery -->
            <div class="col-lg-8">
                <div class="row g-2">
                    <!-- Main Image -->
                    <div class="col-12 col-md-8">
                        <img src="{{ asset('storage/' . $Fleet->image) }}"
                             class="img-fluid rounded shadow-sm w-100 h-100 object-fit-cover"
                             alt="{{ $Fleet->name }}" style="object-fit:cover">
                    </div>
                    <!-- Side Images -->
                    <div class="col-12 col-md-4 d-flex flex-column gap-2">
                        @for ($i = 0; $i < 3; $i++)
                            <img src="{{ asset('storage/' . $Fleet->image) }}"
                                 class="img-fluid rounded shadow-sm"
                                 alt="Gallery Image">
                        @endfor
                    </div>
                </div>


            </div>

            <!-- Right Column: Booking Form -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">Book This Car</h4>
                        <form action="{{ route('bookings.storeStep1') }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $Fleet->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $Fleet->price_per_day }}">

                             <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="booking-one__input-box">
                                    <p class="booking-one__input-title"> <span class="icon-pin-2"></span>
                                        Pickup Date</p>

                                        <input type="datetime-local" placeholder="mm/dd/yyy" name="pickup_datetime"
                                            id="datepicker-2">
                                            @error('pickup_datetime') <p class="text-red-600">{{ $message }}</p> @enderror

                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="booking-one__input-box">
                                    <p class="booking-one__input-title"> <span class="icon-pin-2"></span>
                                        Drop of</p>

                                    <input type="datetime-local" placeholder="mm/dd/yyy" name="dropoff_datetime"
                                            id="datepicker">
                                            @error('dropoff_datetime') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="booking-one__input-box">
                                    <p class="booking-one__input-title"> <span class="icon-pin-2"></span>
                                        Pickup Location</p>
                                    <input type="text"  name="pickup_location">
                                    @error('pickup_location') <p class="text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="booking-one__input-box">
                                    <p class="booking-one__input-title"> <span class="icon-cuv"></span>
                                        Your car type</p>
                                    <div class="select-box">
                                        <select name="car_id" class="selectmenu wide">
                                            <option selected="selected">Your Car Type
                                            </option>
                                            <?php
                                                $Car = \App\Models\Fleet::all();
                                            ?>
                                            @foreach ($Car as $car)
                                                <option value="{{$car->id}}">{{$car->name}}</option>
                                            @endforeach

                                        </select>
                                        @error('car_id') <p class="text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Confirm Booking
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Contact Card -->

            </div>

        </div>
        {{--  --}}
            <div class="col-xl-12 col-lg-12">
                <div class="listing-single__bottom-left">
                    <div class="listing-single__description">
                        <p class="listing-single__description-text-1">
                            {!! $Fleet->content !!}
                        </p>
                    </div>
                </div>
            </div>

            {{--  --}}
    </div>
</section>
@endsection
