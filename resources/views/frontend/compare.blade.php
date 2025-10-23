@extends('layouts.master-page')

@section('title', $fleetA->name . ' vs ' . $fleetB->name . ' | Vehicle Comparison')

@section('content')
<!-- ===== Page Header ===== -->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('storage/' . $fleetA->image) }}');"></div>
    <div class="page-header__shape-1" style="background-image: url('{{ asset('uploads/e350.png') }}');"></div>
    <div class="container">
        <div class="page-header__inner">
            <h3>Compare Vehicles</h3>
            <div class="thm-breadcrumb__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><span class="icon-arrow-left"></span></li>
                    <li>Compare</li>
                    <li><span class="icon-arrow-left"></span></li>
                    <li>{{ $fleetA->name }} vs {{ $fleetB->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ===== Comparison Section ===== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Fleet A -->
            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-sm border-0 flex-fill">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ $fleetA->name }}</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <!-- Gallery -->
                        <div class="mb-4">
                            <div class="row g-2">
                                @if ($fleetA->image)
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="{{ asset('storage/' . $fleetA->image) }}" data-lightbox="galleryA" data-title="{{ $fleetA->name }} - Main Image">
                                            <img src="{{ asset('storage/' . $fleetA->image) }}" alt="{{ $fleetA->name }} Main Image" class="img-fluid rounded shadow-sm w-100 gallery-image" style="aspect-ratio: 1/1; object-fit: cover;">
                                        </a>
                                    </div>
                                @endif
                                @foreach ($fleetA->images as $image)
                                    <div class="col-6 col-md-3 mb-2">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="galleryA" data-title="{{ $fleetA->name }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $fleetA->name }} Image" class="img-fluid rounded shadow-sm w-100 gallery-image" style="aspect-ratio: 1/1; object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specs -->
                        <ul class="list-unstyled mb-3">
                            <li><strong>Year:</strong> {{ $fleetA->year }}</li>
                            <li><strong>Transmission:</strong> {{ $fleetA->transmission }}</li>
                            <li><strong>Fuel Type:</strong> {{ $fleetA->fuel_type }}</li>
                            <li><strong>Seats:</strong> {{ $fleetA->seats }}</li>
                            <li><strong>Type:</strong> {{ $fleetA->type }}</li>
                            <li><strong>Status:</strong> {{ $fleetA->status }}</li>
                            <li><strong>Price per day:</strong> KES {{ number_format($fleetA->price_per_day, 2) }}</li>
                        </ul>

                        <!-- Description -->
                        <div class="mb-3">
                            {!! $fleetA->content !!}
                        </div>

                        <!-- Booking -->
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $fleetA->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $fleetA->price_per_day }}">
                            <button type="submit" class="btn btn-primary w-100">
                                Book {{ $fleetA->name }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Fleet B -->
            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-sm border-0 flex-fill">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">{{ $fleetB->name }}</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <!-- Gallery -->
                        <div class="mb-4">
                            <div class="row g-2">
                                @if ($fleetB->image)
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="{{ asset('storage/' . $fleetB->image) }}" data-lightbox="galleryB" data-title="{{ $fleetB->name }} - Main Image">
                                            <img src="{{ asset('storage/' . $fleetB->image) }}" alt="{{ $fleetB->name }} Main Image" class="img-fluid rounded shadow-sm w-100 gallery-image" style="aspect-ratio: 1/1; object-fit: cover;">
                                        </a>
                                    </div>
                                @endif
                                @foreach ($fleetB->images as $image)
                                    <div class="col-6 col-md-3 mb-2">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="galleryB" data-title="{{ $fleetB->name }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $fleetB->name }} Image" class="img-fluid rounded shadow-sm w-100 gallery-image" style="aspect-ratio: 1/1; object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specs -->
                        <ul class="list-unstyled mb-3">
                            <li><strong>Year:</strong> {{ $fleetB->year }}</li>
                            <li><strong>Transmission:</strong> {{ $fleetB->transmission }}</li>
                            <li><strong>Fuel Type:</strong> {{ $fleetB->fuel_type }}</li>
                            <li><strong>Seats:</strong> {{ $fleetB->seats }}</li>
                            <li><strong>Type:</strong> {{ $fleetB->type }}</li>
                            <li><strong>Status:</strong> {{ $fleetB->status }}</li>
                            <li><strong>Price per day:</strong> KES {{ number_format($fleetB->price_per_day, 2) }}</li>
                        </ul>

                        <!-- Description -->
                        <div class="mb-3">
                            {!! $fleetB->content !!}
                        </div>

                        <!-- Booking -->
                        <form action="{{ route('bookings.storeStep1') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $fleetB->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $fleetB->price_per_day }}">
                            <button type="submit" class="btn btn-secondary w-100">
                                Book {{ $fleetB->name }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox2 CSS/JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</section>
@endsection
