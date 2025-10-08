<!DOCTYPE html>
<html lang="en">
{{-- fetch setting --}}
<?php
  $Settings = DB::table('settings')->first();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Primary Meta Tags -->
    <title>Nuhi Great Travels | Ride with a Touch of Class – Luxury Car Rental & Chauffeur Services in Kenya</title>
    <meta name="description" content="Ride with a touch of class. Nuhi Great Travels offers premium Car Rental, airport transfers, and executive chauffeur services in Kenya. Travel in unmatched comfort, elegance, and VIP style.">
    <meta name="keywords" content="Nuhi Great Travels, Luxury Car Rental Kenya, Executive Transfers Nairobi, Chauffeur Services Kenya, VIP Transport Services, Airport Transfers Kenya, Premium Car Rental Nairobi, Corporate Travel Kenya, Wedding Car Rental Nairobi, High-End Vehicle Rentals Kenya, Ride with a Touch of Class">
    <meta name="author" content="Nuhi Great Travels">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Nuhi Great Travels | Ride with a Touch of Class">
    <meta property="og:description" content="Premium Car Rental, chauffeur-driven services, and executive airport transfers in Kenya. Experience VIP travel with Nuhi Great Travels.">
    <meta property="og:url" content="https://www.nuhigreattravels.com/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.nuhigreattravels.com/IMG-20250506-WA0000.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Nuhi Great Travels | Luxury Car Rental & Chauffeur Services in Kenya">
    <meta name="twitter:description" content="Ride with a touch of class. Chauffeur-driven luxury cars, VIP transfers, and premium rentals across Kenya.">
    <meta name="twitter:image" content="https://www.nuhigreattravels.com/IMG-20250506-WA0000.jpg">

    <!-- Schema.org Markup (JSON-LD) -->

    @push('scripts')
        @verbatim
        <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "TravelAgency",
        "name": "Nuhi Great Travels",
        "url": "https://www.nuhigreattravels.com/",
        "logo": "https://www.nuhigreattravels.com/IMG-20250506-WA0000.jpg",
        "description": "Luxury car hire, airport transfers, and executive chauffeur services in Kenya.",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "KE"
        },
        "sameAs": [
            "https://www.instagram.com/nuhigreattravels",
            "https://www.facebook.com/nuhiluxurytravel"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+254 700 000000",
            "contactType": "Customer Support",
            "areaServed": "KE"
        }
        }
        </script>
        @endverbatim
    @endpush



    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('main-html/assets/images/favicons/apple-touch-icon.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('main-html/assets/images/favicons/favicon-32x32.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('main-html/assets/images/favicons/favicon-16x16.png')}}" />
    <link rel="manifest" href="{{asset('main-html/assets/images/favicons/site.webmanifest')}}" />
    <meta name="description" content="Gorent HTML 5 Template " />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">


    <link
        href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&amp;family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="{{asset('main-html/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/custom-animate.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/swiper.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/font-awesome-all.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/jarallax.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/jquery.magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('main-html/assets/css/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/owl.theme.default.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/nice-select.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/aos.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/odometer.min.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/timePicker.css')}}" />


    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/slider.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/footer.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/sliding-text.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/services.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/about.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/booking.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/counter.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/listing.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/video.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/pricing.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/popular-car.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/testimonial.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/faq.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/team.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/call.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/download-app.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/brand.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/blog.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/lets-talk.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/process.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/why-choose.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/module-css/gallery.css')}}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{asset('main-html/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('main-html/assets/css/responsive.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('main-html/assets/css/dark.css')}}" /> --}}
</head>

<body class="custom-cursor">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <!--Start Preloader-->
    <div class="loader js-preloader">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <!--End Preloader-->







    <?php
      $Settings = \App\Models\Setting::first();
    ?>
    <!-- Start sidebar widget content -->
    <div class="xs-sidebar-group info-group info-sidebar">
        <div class="xs-overlay xs-bg-black"></div>
        <div class="xs-sidebar-widget">
            <div class="sidebar-widget-container">
                <div class="widget-heading">
                    <a href="#" class="close-side-widget">X</a>
                </div>
                <div class="sidebar-textwidget">
                    <div class="sidebar-info-contents">
                        <div class="content-inner">
                            <div class="logo">
                                <a href="index.html"><img src="assets/images/resources/logo-2.png" alt="" /></a>
                            </div>
                            <div class="content-box">
                                <h4>About Us</h4>
                                <div class="inner-text">
                                    <p>
                                        Nuhi Great Travels is your trusted partner in reliable and comfortable transportation solutions. We specialize in corporate car rentals, airport transfers, fleet leasing, and chauffeured services tailored to meet the unique needs of individuals and businesses.
                                    </p>
                                </div>
                            </div>

                            <div class="form-inner">
                                <h4>Get a free quote</h4>
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Name" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email" required="">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Message..."></textarea>
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="thm-btn form-inner__btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>

                            <div class="sidebar-contact-info">
                                <h4>Contact Info</h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="icon-pin"></span> {{$Settings->location}}
                                    </li>
                                    <li>
                                        <span class="icon-call"></span>
                                        <a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}} </a>
                                    </li>
                                    <li>
                                        <span class="icon-envelope"></span>
                                        <a href="mailto:{{$Settings->email}}">{{$Settings->email}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="thm-social-link1">
                                <ul class="social-box list-unstyled">
                                    <li>
                                        <a href="#"><i class="icon-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon-twitter" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon-linkedin" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon-dribble-big-logo" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End sidebar widget content -->








    <div class="page-wrapper">
        {{-- header --}}
        @include('components.header')
        {{-- end header --}}

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->



        @yield('content')

        <!--Site Footer Start-->
       @include('components.footer')
        <!--Site Footer End-->




    </div><!-- /.page-wrapper -->


    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assets/images/resources/logo-2.png" width="140"
                        alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:{{$Settings->email}}">{{$Settings->email}}</a>
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <a href="tel:{{$Settings->mobile}}">{{$Settings->mobile}}</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="{{$Settings->twitter}}" class="fab fa-twitter"></a>
                    <a href="{{$Settings->facebook}}" class="fab fa-facebook-square"></a>
                    <a href="{{$Settings->youtube}}" class="fab fa-youtube"></a>
                    <a href="{{$Settings->instagram}}" class="fab fa-instagram"></a>
                    <a href="{{$Settings->linkedin}}" class="fab fa-linkedin"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->



        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> Go Back Top</span>
    </a>


    <script src="{{asset('main-html/assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jarallax.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.appear.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/swiper.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.circle-progress.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/knob.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/wNumb.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/wow.js')}}"></script>
    <script src="{{asset('main-html/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/jquery-sidebar-content.js')}}"></script>
    <script src="{{asset('main-html/assets/js/gsap/gsap.js')}}"></script>
    <script src="{{asset('main-html/assets/js/gsap/ScrollTrigger.js')}}"></script>
    <script src="{{asset('main-html/assets/js/gsap/SplitText.js')}}"></script>
    <script src="{{asset('main-html/assets/js/marquee.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/odometer.min.js')}}"></script>
    <script src="{{asset('main-html/assets/js/timePicker.js')}}"></script>
    <script src="{{asset('main-html/assets/js/typed-2.0.11.js')}}"></script>
    <script src="{{asset('main-html/assets/js/aos.js')}}"></script>




    <!-- template js -->
    <script src="{{asset('main-html/assets/js/script.js')}}"></script>
    @include('layouts.scripts')
</body>


</html>
