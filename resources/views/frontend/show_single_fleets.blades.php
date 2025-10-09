@extends('layouts.master-page')

@section('title', $Fleet->name . ' | Vehicle Details')

@section('content')
<!-- ===== Page Header (Keep your existing header) ===== -->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('storage/' . $Fleet->image) }}');"></div>
    <div class="page-header__shape-1" style="background-image: url('{{ asset('uploads/e350.png') }}');"></div>
    <div class="container text-center text-white py-5">
        <h1 class="display-5 fw-bold">{{ $Fleet->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page">{{ $Fleet->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- ===== Vehicle Gallery + Booking Section ===== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- Left Column: Image Gallery -->
            <div class="col-lg-8">
                <div class="row g-3">
                    <!-- Main Image -->
                    <div class="col-12 col-md-8">
                        <img src="{{ asset('storage/' . $Fleet->image) }}"
                             class="img-fluid rounded shadow-sm w-100 h-100 object-fit-cover"
                             alt="{{ $Fleet->name }}" style="height: 450px;">
                    </div>
                    <!-- Side Images -->
                    <div class="col-12 col-md-4 d-flex flex-column gap-3">
                        @for ($i = 0; $i < 4; $i++)
                            <img src="{{ asset('storage/' . $Fleet->image) }}"
                                 class="img-fluid rounded shadow-sm"
                                 alt="Gallery Image">
                        @endfor
                    </div>
                </div>

                <!-- Title and Details -->
                <div class="mt-4">
                    <h2 class="fw-bold">{{ $Fleet->name }}</h2>
                    <p class="text-muted mb-2">
                        {{ $Fleet->year }} | {{ $Fleet->transmission }} | {{ $Fleet->fuel_type }} | {{ $Fleet->seats }} Seats
                    </p>
                    <h3 class="text-primary fw-semibold mb-3">KES {{ number_format($Fleet->price_per_day, 0) }} / Day</h3>
                    <div class="mb-4 text-secondary">
                        {!! $Fleet->description !!}
                    </div>
                    <div class="mb-4">
                        <h5 class="fw-semibold">More Details:</h5>
                        <ul class="list-unstyled small text-muted">
                            <li><i class="bi bi-check-circle text-success"></i> Type: {{ $Fleet->type }}</li>
                            <li><i class="bi bi-check-circle text-success"></i> Status: {{ $Fleet->status }}</li>
                            <li><i class="bi bi-check-circle text-success"></i> Year: {{ $Fleet->year }}</li>
                        </ul>
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

                            <div class="mb-3">
                                <label for="pickup_date" class="form-label fw-semibold">Pick-Up Date & Time</label>
                                <input type="datetime-local" id="pickup_date" name="pickup_date"
                                       class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="dropoff_date" class="form-label fw-semibold">Drop-Off Date & Time</label>
                                <input type="datetime-local" id="dropoff_date" name="dropoff_date"
                                       class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="pickup_location" class="form-label fw-semibold">Pick-Up Location</label>
                                <input type="text" id="pickup_location" name="pickup_location"
                                       class="form-control" placeholder="Enter location" required>
                            </div>

                            <div class="mb-3">
                                <label for="full_name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" id="full_name" name="full_name"
                                       class="form-control" placeholder="Your name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" id="email" name="email"
                                       class="form-control" placeholder="example@email.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="mpesa_number" class="form-label fw-semibold">Mpesa Number</label>
                                <input type="text" id="mpesa_number" name="mpesa_number"
                                       class="form-control" placeholder="07XXXXXXXX" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="col-xl-4 col-lg-5">
                            <div class="listing-single__sidebar">
                                <div class="listing-single__rent-car listing-single__single-box">

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
@endsection
