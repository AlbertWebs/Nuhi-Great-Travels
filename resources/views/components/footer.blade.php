 <footer class="site-footer">
            <div class="site-footer__bg" style="background-image: url(assets/images/backgrounds/site-footer-bg.jpg);">
            </div>

            <div class="site-footer__top text-center">
                <div class="container">
                    <div class="site-footer__top-inner flex justify-center items-center">
                        <div class="col-xl-12 col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="100ms">
                            <div class="footer-widget__about mx-auto">
                                <div class="footer-widget__about-logo mb-4">
                                    <a href="index.html">
                                        <img style="width:400px" src="{{url('/')}}/uploads/LQkKWUQZq1uxJpIeluEyc7Br0pudhpnvNF6FWXf7.png" alt="Footer Logo" class="mx-auto">
                                    </a>
                                </div>

                                <p class="footer-widget__about-text text-lg text-gray-200 mb-6" style="max-width:600px; margin:0 auto;">
                                        Don't miss a thing. <strong>Subscribe today</strong> to have all the
                                        <strong>latest offers, fleet news, and exclusive car sale deals</strong>
                                        delivered straight to your inbox the moment they're announced.
                                </p>

                               <form id="newsletter-form" class="footer-widget__form flex justify-center items-center max-w-md mx-auto">
                                    <div class="footer-widget__input w-full relative">
                                        <input name="email" type="email" required placeholder="Your Email Here"
                                            class="w-full py-3 px-4 rounded-full border border-gray-300 focus:outline-none focus:ring focus:ring-yellow-400 text-center"
                                            style="color:#666666;">
                                    </div>
                                    <button type="submit"
                                        id="subscribe-btn"
                                        class="footer-widget__btn ml-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-full flex items-center justify-center">
                                        <span class="btn-text far fa-paper-plane"></span>
                                        <svg class="spinner hidden ml-2 w-4 h-4 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                        </svg>
                                    </button>
                                </form>

                                <div id="subscribe-message" class="text-center mt-4 text-sm font-medium text-gray-600"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-footer__bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="site-footer__bottom-inner">
                                <div class="site-footer__copyright">
                                    <p class="site-footer__copyright-text">Copyright © {{date('Y')}} Nuhi Great Travels All Rights Reserved. | Powered By <a href="https://designekta.com">Designekta Studios .</a> </p>
                                </div>
                                <div class="site-footer__bottom-menu-box">
                                    <ul class="list-unstyled site-footer__bottom-menu">
                                        <li><a href="about.html">Terms of Service</a></li>
                                        <li><a href="about.html">Privacy policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


