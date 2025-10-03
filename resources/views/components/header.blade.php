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
                                     <li>
                                        <a href="{{route('home')}}">Home</a>
                                    </li>
                                    <li>
                                        <a href="{{route('about')}}">About Us</a>
                                    </li>
                                   
                                    <li class="dropdown">
                                        <a href="#">Our Fleet</a>
                                        <ul class="shadow-box">
                                            <li><a href="#">SUV</a></li>
                                            <li><a href="#">Compact SUV</a></li>
                                            <li><a href="#">Saloon</a></li>
                                            <li><a href="#">Limousine</a></li>
                                            <li><a href="#">Chopper </a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#">Services</a>
                                        <ul class="shadow-box">
                                            <li><a href="products.html">Airport Transfers</a></li>
                                            <li><a href="product-details.html">Chauffeur Services</a></li>
                                            <li><a href="cart.html">Corporate & VIP Travel</a></li>
                                            <li><a href="checkout.html">Wedding & Events Car Hire</a></li>
                                            <li><a href="wishlist.html">Long-Term Leasing</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">Pricing</a>
                                        
                                    </li>
                                    <li>
                                        <a href="contact.html">Updates & Travel Guides</a>
                                    </li>
                                    <li>
                                        <a href="contact.html">Contact Us</a>
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