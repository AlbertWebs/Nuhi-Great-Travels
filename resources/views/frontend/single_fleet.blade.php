@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>Our FLeet</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>Our FLeet</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

    <!-- Cars Page Start -->
    <section class="cars-page">
        <div class="container-fluid">
            <div class="row">
                @foreach($Fleet as $fleet)
                    <?php
                        $car = DB::table('cars')->where('id', $fleet->car_id)->first();
                    ?>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="listing-one__single">
                            <div class="listing-one__img">
                                <img style="height:350px; width:100%; object-fit:cover" src="{{ asset('storage/' . $fleet->image) }}" alt="{{ $fleet->make }}">
                                <div class="listing-one__brand-name">
                                    {{-- <p>{{ $car->make }}</p> --}}
                                </div>
                            </div>

                            <div class="listing-one__content">
                                <h3 class="listing-one__title">
                                    <a href="{{ route('single_fleets', ['car' => $car->slug, 'fleet' => $fleet->slug]) }}">
                                        {{ $fleet->name }}
                                    </a>

                                </h3>



                                <div class="listing-one__car-rent-box">
                                    <p class="listing-one__car-rent">Starting From
                                        <span>Ksh {{ number_format($fleet->price_per_day) }}/</span> Day
                                    </p>
                                </div>

                                <div class="listing-one__btn-box">
                                    <a href="{{ route('single_fleets', ['car' => $car->slug, 'fleet' => $fleet->slug]) }}" class="thm-btn">
                                        Details Now <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($Fleet->isEmpty())
                    <div class="col-12 text-center py-5">
                        <h4>No cars available at the moment.</h4>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Cars Page End -->


@endsection
