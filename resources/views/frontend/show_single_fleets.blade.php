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
                    <a href="{{ route('fleets.compare.form') }}">Compare <span class="icon-compress"></span> </a>
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

        {{--  --}}
        <!-- Include Lightbox2 -->
        <!-- Include Lightbox2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

        <style>
            /* Make both columns stretch equally */
            .equal-height {
                display: flex;
                align-items: stretch;
            }

            /* Ensure the card fills its parent height */
            .equal-height .card {
                height: 100%;
            }

            /* Optional: Keep gallery images uniform */
            .gallery-image {
                aspect-ratio: 1 / 1;
                object-fit: cover;
            }
        </style>

        <div class="row g-4 align-items-start equal-height">
            <!-- Left Column: Image Gallery -->
            <div class="col-lg-8">
                <div class="row g-3 h-100">

                    {{-- 🖼️ 1. Main Fleet Image --}}
                    @if ($Fleet->image)
                        <div class="col-12 col-md-4">
                            <a href="{{ asset('storage/' . $Fleet->image) }}"
                            data-lightbox="fleet-gallery"
                            data-title="{{ $Fleet->name }} - Main Image">
                                <img src="{{ asset('storage/' . $Fleet->image) }}"
                                    class="img-fluid rounded shadow-sm w-100 gallery-image"
                                    alt="{{ $Fleet->name }} Main Image">
                            </a>
                        </div>
                    @endif

                    {{-- 🖼️ 2. Additional Fleet Images from fleet_images table --}}
                    @foreach ($Fleet->images as $index => $image)
                        <div class="col-12 col-md-4">
                            <a href="{{ asset('storage/' . $image->image_path) }}"
                            data-lightbox="fleet-gallery"
                            data-title="{{ $Fleet->name }} - Image {{ $index + 2 }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    class="img-fluid rounded shadow-sm w-100 gallery-image"
                                    alt="{{ $Fleet->name }} Image {{ $index + 2 }}">
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>




            <!-- Right Column: Booking Form -->
            <div class="col-lg-4 d-flex">
                <div class="card shadow-sm border-0 flex-fill">
                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="fw-bold mb-3">Book This Car</h4>
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="flex-grow-1 d-flex flex-column">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $Fleet->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $Fleet->price_per_day }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pickup Date</label>
                                <input type="datetime-local" name="pickup_datetime" class="form-control" id="datepicker-2">
                                @error('pickup_datetime') <p class="text-danger small">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Drop-off Date</label>
                                <input type="datetime-local" name="dropoff_datetime" class="form-control" id="datepicker">
                                @error('dropoff_datetime') <p class="text-danger small">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pickup Location</label>
                                <input type="text" name="pickup_location" class="form-control">
                                @error('pickup_location') <p class="text-danger small">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Car Type</label>
                                <select name="car_id" class="form-select">
                                    <option selected disabled>Your Car Type</option>
                                    @foreach (\App\Models\Fleet::all() as $car)
                                        <option value="{{ $car->id }}">{{ $car->name }}</option>
                                    @endforeach
                                </select>
                                @error('car_id') <p class="text-danger small">{{ $message }}</p> @enderror
                            </div>

                            <div class="mt-auto">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                    Confirm Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
