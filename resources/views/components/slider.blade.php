<section class="main-slider">
            <div class="main-slider__carousel owl-carousel owl-theme">
                @foreach($carousels as $slide)
                    <div class="item">
                        <div class="main-slider__bg" 
                            style="background-image: url({{ asset('storage/'.$slide->image) }});">
                        </div>
                        <div class="container">
                            <div class="main-slider__content">
                                <div class="main-slider__sub-title-box">
                                    <p class="main-slider__sub-title">{{ $slide->subtitle }}</p>
                                </div>
                                <h2 class="main-slider__title">{!! $slide->title !!}</h2>
                                <p class="main-slider__sub-title-two">{{ $slide->subtitle_two }}</p>

                                <div class="main-slider__btn-and-video-box">
                                    @if($slide->button_link)
                                        <div class="main-slider__btn-box">
                                            <a href="{{ $slide->button_link }}" class="thm-btn">
                                                {{ $slide->button_text ?? 'Read More' }}
                                                <span class="fas fa-arrow-right"></span>
                                            </a>
                                        </div>
                                    @endif

                                    @if($slide->video_link)
                                        <div class="main-slider__video-link">
                                            <a href="{{ $slide->video_link }}" class="video-popup">
                                                <div class="main-slider__video-icon">
                                                    <span class="icon-play-2"></span>
                                                    <i class="ripple"></i>
                                                </div>
                                            </a>
                                            <h4 class="main-slider__video-title">Watch Video</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>