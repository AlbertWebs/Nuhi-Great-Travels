@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>{{$Services->title}}</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>{{$Services->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

           <!-- About One Start -->
        <section class="about-one" style="margin-bottom:100px">
            <div class="container">
                <div class="row flex flex-wrap items-stretch">

                     <div class="col-xl-6 flex">
                        <div class="about-one__lefts wow slideInLeft flex-1 flex flex-col justify-center"
                            data-wow-delay="100ms" data-wow-duration="2500ms">
                            <div class="about-one__img-box">
                                <div class="about-one__img" style="height:640px;">
                                    <img style="object-fit:cover" class="border-3 border-white w-full h-auto" src="{{ asset('storage/' . $Services->image) }}" alt="Nuhi Great Travels">
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Text Side -->
                    <div class="col-xl-6 flex">
                        <div class="about-one__right wow slideInRight flex-1 flex flex-col justify-center">
                            <div class="section-title text-left sec-title-animation animation-style1">

                                <h2 class="section-title__title title-animation">{{$Services->title}}</h2>
                            </div>

                            <p class="about-one__text-2">
                                {!! \Illuminate\Support\Str::limit($Services->description, 1000, '...') !!}
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




@endsection
