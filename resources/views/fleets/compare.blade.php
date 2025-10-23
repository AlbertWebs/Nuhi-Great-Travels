@extends('layouts.master-page')

@section('title', $fleetA->name . ' vs ' . $fleetB->name . ' | Vehicle Comparison')

@section('content')
<!-- ===== Page Header ===== -->
<section class="page-header" style="background-color: #000;">
    <div class="page-header__bg" style="background-image: url('{{ asset('storage/' . $fleetA->image) }}'); filter: brightness(0.3);"></div>
    <div class="page-header__shape-1" style="background-image: url('{{ asset('uploads/e350.png') }}'); opacity: 0.1;"></div>
    <div class="container">
        <div class="page-header__inner text-gold" style="position: relative; z-index: 10;">
            <h3 class="text-gold fw-bold">Compare Vehicles</h3>
            <div class="thm-breadcrumb__inner">
                <ul class="thm-breadcrumb list-unstyled d-flex gap-2 align-items-center text-gold">
                    <li><a href="{{ url('/') }}" class="text-gold text-decoration-none fw-semibold">Home</a></li>
                    <li><span class="icon-arrow-left text-gold"></span></li>
                    <li>Compare</li>
                    <li><span class="icon-arrow-left text-gold"></span></li>
                    <li>{{ $fleetA->name }} vs {{ $fleetB->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ===== Comparison Section ===== -->
<section class="py-5" style="background-color: #121212;">
    <div class="container">
        <div class="row g-4">
            <!-- Fleet A -->
            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-sm border-0 flex-fill" style="background-color: #1c1c1c;">
                    <div class="card-header sticky-top" style="background-color: #000; border-bottom: 2px solid #FFD700; z-index: 10;">
                        <h4 class="mb-0 text-gold fw-bold">{{ $fleetA->name }}</h4>
                    </div>
                    <div class="card-body d-flex flex-column text-light">
                        <!-- Gallery -->
                        <div class="mb-4">
                            <div class="row g-2">
                                @if ($fleetA->image)
                                    <div class="col-12 mb-3">
                                        <a href="{{ asset('storage/' . $fleetA->image) }}" data-lightbox="galleryA" data-title="{{ $fleetA->name }} - Main Image" class="d-block overflow-hidden rounded shadow-lg">
                                            <img src="{{ asset('storage/' . $fleetA->image) }}" alt="{{ $fleetA->name }} Main Image" class="img-fluid gallery-image w-100" style="aspect-ratio: 4/3; object-fit: cover; transition: transform 0.3s ease;">
                                        </a>
                                    </div>
                                @endif
                                @foreach ($fleetA->images as $image)
                                    <div class="col-6 col-md-3">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="galleryA" data-title="{{ $fleetA->name }}" class="d-block overflow-hidden rounded shadow-sm">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $fleetA->name }} Image" class="img-fluid gallery-image w-100" style="aspect-ratio: 1/1; object-fit: cover; transition: transform 0.3s ease;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specs -->
                        <ul class="list-unstyled mb-4" style="color: #FFD700;">
                            <li><strong>Year:</strong> <span class="text-light">{{ $fleetA->year }}</span></li>
                            <li><strong>Transmission:</strong> <span class="text-light">{{ $fleetA->transmission }}</span></li>
                            <li><strong>Fuel Type:</strong> <span class="text-light">{{ $fleetA->fuel_type }}</span></li>
                            <li><strong>Seats:</strong> <span class="text-light">{{ $fleetA->seats }}</span></li>
                            <li><strong>Type:</strong> <span class="text-light">{{ $fleetA->type }}</span></li>
                            <li><strong>Status:</strong> <span class="text-light">{{ $fleetA->status }}</span></li>
                            <li><strong>Price per day:</strong> <span class="fw-bold">KES {{ number_format($fleetA->price_per_day, 2) }}</span></li>
                        </ul>

                        <!-- Description -->
                        <div class="mb-4 text-light">
                            {!! $fleetA->content !!}
                        </div>

                        <!-- Booking -->
                        <?php $car_id = $fleetA->car_id; $CarType = DB::table('cars')->where('id', $car_id)->first(); ?>
                        <!-- Booking -->
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $fleetA->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $fleetA->price_per_day }}">
                            <a href="{{ route('single_fleets', ['car' => $CarType->slug, 'fleet' => $fleetA->slug]) }}" type="submit" class="btn btn-gold-outline w-100 fw-semibold py-2 hover-scale">
                                Book {{ $fleetA->name }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Fleet B -->
            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-sm border-0 flex-fill" style="background-color: #1c1c1c;">
                    <div class="card-header sticky-top" style="background-color: #000; border-bottom: 2px solid #FFD700; z-index: 10;">
                        <h4 class="mb-0 text-gold fw-bold">{{ $fleetB->name }}</h4>
                    </div>
                    <div class="card-body d-flex flex-column text-light">
                        <!-- Gallery -->
                        <div class="mb-4">
                            <div class="row g-2">
                                @if ($fleetB->image)
                                    <div class="col-12 mb-3">
                                        <a href="{{ asset('storage/' . $fleetB->image) }}" data-lightbox="galleryB" data-title="{{ $fleetB->name }} - Main Image" class="d-block overflow-hidden rounded shadow-lg">
                                            <img src="{{ asset('storage/' . $fleetB->image) }}" alt="{{ $fleetB->name }} Main Image" class="img-fluid gallery-image w-100" style="aspect-ratio: 4/3; object-fit: cover; transition: transform 0.3s ease;">
                                        </a>
                                    </div>
                                @endif
                                @foreach ($fleetB->images as $image)
                                    <div class="col-6 col-md-3">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="galleryB" data-title="{{ $fleetB->name }}" class="d-block overflow-hidden rounded shadow-sm">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $fleetB->name }} Image" class="img-fluid gallery-image w-100" style="aspect-ratio: 1/1; object-fit: cover; transition: transform 0.3s ease;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specs -->
                        <ul class="list-unstyled mb-4" style="color: #FFD700;">
                            <li><strong>Year:</strong> <span class="text-light">{{ $fleetB->year }}</span></li>
                            <li><strong>Transmission:</strong> <span class="text-light">{{ $fleetB->transmission }}</span></li>
                            <li><strong>Fuel Type:</strong> <span class="text-light">{{ $fleetB->fuel_type }}</span></li>
                            <li><strong>Seats:</strong> <span class="text-light">{{ $fleetB->seats }}</span></li>
                            <li><strong>Type:</strong> <span class="text-light">{{ $fleetB->type }}</span></li>
                            <li><strong>Status:</strong> <span class="text-light">{{ $fleetB->status }}</span></li>
                            <li><strong>Price per day:</strong> <span class="fw-bold">KES {{ number_format($fleetB->price_per_day, 2) }}</span></li>
                        </ul>

                        <!-- Description -->
                        <div class="mb-4 text-light">
                            {!! $fleetB->content !!}
                        </div>

                        <?php $car_id = $fleetB->car_id; $CarType = DB::table('cars')->where('id', $car_id)->first(); ?>
                        <!-- Booking -->
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $fleetB->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $fleetB->price_per_day }}">
                            <a href="{{ route('single_fleets', ['car' => $CarType->slug, 'fleet' => $fleetB->slug]) }}" type="submit" class="btn btn-gold-outline w-100 fw-semibold py-2 hover-scale">
                                Book {{ $fleetB->name }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox2 CSS/JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <style>
        /* Colors */
        .text-gold {
            color: #FFD700 !important;
        }
        .btn-gold {
            background-color: #FFD700;
            color: #000;
            border: none;
        }
        .btn-gold:hover {
            background-color: #e6c200;
            color: #000;
        }
        .btn-gold-outline {
            background-color: transparent;
            color: #FFD700;
            border: 2px solid #FFD700;
        }
        .btn-gold-outline:hover {
            background-color: #FFD700;
            color: #000;
        }

        /* Image hover zoom */
        .gallery-image:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        /* Button hover scale */
        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Breadcrumb styles */
        .thm-breadcrumb li {
            font-weight: 600;
        }
        .thm-breadcrumb li a {
            text-decoration: none;
        }

        /* Adjust sticky headers */
        .card-header.sticky-top {
            top: 70px; /* Adjust if you have a fixed navbar */
        }

        /* Responsive tweaks */
        @media (max-width: 767px) {
            .card-header.sticky-top {
                position: relative !important;
                top: auto !important;
            }
        }
    </style>
</section>
@endsection
