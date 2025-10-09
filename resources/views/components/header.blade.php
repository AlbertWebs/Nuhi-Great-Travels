<header class="main-header">
            <div class="main-menu__top">
                <div class="main-menu__top-inner">
                    <ul class="list-unstyled main-menu__contact-list">
                        <li>
                            <div class="icon">
                                <i class="icon-call-2"></i>
                            </div>
                            <div class="text">
                                <p><a href="tel: {{$Settings->mobile}}">{{$Settings->mobile}}</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="icon-envelope-2"></i>
                            </div>
                            <div class="text">
                                <p><a href="mailto:{{$Settings->email}}">{{$Settings->email}}</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="icon-pin-2"></i>
                            </div>
                            <div class="text">
                                <p> {{$Settings->location}}</p>
                            </div>
                        </li>
                    </ul>
                    <div class="main-menu__top-right">
                        <div class="main-menu__top-login-reg-box">
                            <a href="login.html">Login</a>
                            <p>or</p>
                            <a href="sign-up.html">Register</a>
                        </div>
                        <div class="main-menu__social">
                            <a href="{{$Settings->facebook}}"><i class="icon-facebook"></i></a>
                            <a href="{{$Settings->twitter}}"><i class="icon-twitter"></i></a>
                            <a href="{{$Settings->instagram}}"><i class="icon-instagram"></i></a>
                            <a href="{{$Settings->youtube}}"><i class="icon-youtube"></i></a>
                            <a href="{{$Settings->tiktok}}"><i class="fab fa-tiktok"></i></a>
                            <a href="{{$Settings->linkedin}}"><i class="icon-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main-menu">
                <div class="main-menu__wrapper">
                    <div class="main-menu__wrapper-inner">
                        <div class="main-menu__left">
                            <div class="main-menu__logo" style="padding:0">
                                <a href="{{url('/')}}"><img style="width:130px; object-fit:cover;" src="{{ asset('storage/'.$Settings->logo) }}" alt=""></a>
                            </div>
                        </div>
                        <div class="main-menu__middle-box">
                            <div class="main-menu__main-menu-box">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                                <ul class="main-menu__list">
                                     <li class="@if($page_title=='Home') current @endif">
                                        <a href="{{route('home')}}">Home</a>
                                    </li>
                                    <li  class="@if($page_title=='About Us') current @endif">
                                        <a href="{{route('about')}}">About Us</a>
                                    </li>

                                    <?php
                                       $Cars = \App\Models\Car::all();
                                    ?>
                                    <li class="dropdown @if($page_title=='Fleet') current @endif">
                                        <a href="#">Our Fleet</a>
                                        <ul class="shadow-box">
                                            @foreach($Cars as $car)
                                              <li>
                                                    <a href="{{ url('fleet') }}/{{$car->slug}}">
                                                        {{ $car->make }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    {{--  --}}
                                    <li class="dropdown megamenu">
                                        <a href="#">Featured Cars </a>
                                        <ul>
                                            <li>
                                                <section class="home-showcase">
                                                    <div class="container">
                                                        <div class="home-showcase__inner">
                                                            <?php $Fleet = DB::table('fleets')->inRandomOrder()->limit('4')->get();  ?>
                                                            <div class="row">
                                                                @foreach($Fleet as $fleets)
                                                                <?php $car_id = $fleets->car_id; $CarType = DB::table('cars')->where('id', $car_id)->first(); ?>
                                                                <div class="col-lg-3">
                                                                    <div class="home-showcase__item">
                                                                        <div class="home-showcase__image">
                                                                            <img style="max-height:200px; width:100%; object-fit:cover" src="{{ asset('storage/'.$fleets->image) }}" alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="{{route('single_fleet', $CarType->slug)}}" class="thm-btn home-showcase__buttons__item">View More <span class="fas fa-arrow-right"></span></a>
                                                                                <a href="{{ route('single_fleets', ['car' => $car->slug, 'fleet' => $fleets->slug]) }}" class="thm-btn home-showcase__buttons__item"> Details <span class="fas fa-arrow-right"></span></a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                        <h3 class="home-showcase__title">{{$fleets->name}}</h3>
                                                                        <!-- /.home-showcase__title -->
                                                                    </div><!-- /.home-showcase__item -->
                                                                </div><!-- /.col-lg-3 -->
                                                                @endforeach

                                                            </div><!-- /.row -->
                                                        </div><!-- /.home-showcase__inner -->

                                                    </div><!-- /.container -->
                                                </section>
                                            </li>
                                        </ul>
                                    </li>
                                    {{--  --}}
                                    <li class="dropdown @if($page_title=='Services') current @endif">
                                        <a href="#">Services</a>
                                        <ul class="shadow-box">
                                            <?php $Services = \App\Models\Service::all(); ?>
                                            @foreach($Services as $service)
                                            <li><a href="{{ route('services-single', $service->slug) }}">{{ $service->title }}</a></li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    <li class="@if($page_title=='Bookings') current @endif">
                                        <a href="{{url('/')}}/#booking">Booking</a>

                                    </li>
                                    <li>
                                        <a href="{{route('updates')}}">Updates & Travel Guides</a>
                                    </li>
                                    <li  class="@if($page_title=='Contact Us') current @endif">
                                        <a href="{{route('contact-us')}}">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="main-menu__search-cart-box">
                                <div class="main-menu__search-box">
                                    <a href="#" class="main-menu__search search-toggler icon-search"></a>
                                </div>

                            </div>
                        </div>
                        <div class="main-menu__right">
                            <div class="main-menu__call">
                                <div class="main-menu__call-icon">
                                    <i class="icon-call-3"></i>
                                </div>
                                <div class="main-menu__call-content">
                                    <p class="main-menu__call-sub-title">Call Anytime</p>
                                    <h5 class="main-menu__call-number"><a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}}</a>
                                    </h5>
                                </div>
                            </div>
                            <div class="main-menu__nav-sidebar-icon">
                                <a class="navSidebar-button" href="#">
                                    <span class="icon-dots-menu-one"></span>
                                    <span class="icon-dots-menu-two"></span>
                                    <span class="icon-dots-menu-three"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
