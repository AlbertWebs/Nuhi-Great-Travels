@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>Updates & Travel Guides</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>Updates & Travel Guides</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

<!-- Blog Page Start -->
<section class="blog-page">
    <div class="container">
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 100 }}ms"
                    data-wow-duration="1500ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img-box">
                            <div class="blog-one__img">
                                <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('main-html/assets/images/blog/default.jpg') }}" alt="{{ $blog->title }}">
                                @if($blog->category)
                                    <div class="blog-one__tags">
                                        <span>{{ $blog->category->name ?? 'General' }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="blog-one__date">
                                <p>{{ $blog->created_at->format('d') }}</p>
                                <span>{{ $blog->created_at->format('M') }}</span>
                            </div>
                        </div>

                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <a href="#">
                                        <span class="fas fa-user"></span> Admin
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('blogs.show', $blog->slug) }}">
                                        <span class="fas fa-comments"></span> {{ $blog->comments_count ?? 0 }} Comments
                                    </a>
                                </li>
                            </ul>

                            <h3 class="blog-one__title">
                                <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>

                            <p class="blog-one__text">
                                {{ Str::limit(strip_tags($blog->content), 120, '...') }}
                            </p>

                            <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-one__read-more">
                                Read More <span class="fas fa-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="car-listing__pagination mt-4">
            {{ $blogs->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>
<!-- Blog Page End -->


@endsection
