@extends('layouts.master-page')

@section('content')



        <!--Page Header Start -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url('{{asset('main-html/assets/images/backgrounds/page-header-bg.jpg')}}');">
            </div>
            <div class="page-header__shape-1" style="background-image: url('{{asset('uploads/e350.png')}}');"></div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>{{$blogs->title}}</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><span class="icon-arrow-left"></span></li>
                            <li>{{$blogs->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End -->

<!-- Blog Details Start -->
<section class="blog-details">
    <div class="container">
        <div class="row">
            <!-- Left Blog Content -->
            <div class="col-xl-8 col-lg-7">
                <div class="blog-details__left">
                    <div class="blog-details__img relative">

                        <img src="{{ $blogs->featured_image ? asset('storage/' . $blogs->featured_image) : asset('main-html/assets/images/blog/default.jpg') }}" alt="{{ $blogs->title }}">

                        <div class="blog-details__date absolute top-2 left-2 bg-gold text-white px-3 py-1 rounded">
                            <p class="text-center text-sm font-semibold">
                                {{ \Carbon\Carbon::parse($blogs->created_at)->format('d') }}<br>
                                {{ \Carbon\Carbon::parse($blogs->created_at)->format('M') }}
                            </p>
                        </div>
                    </div>

                    <div class="blog-details__content mt-4">
                        <div class="blog-details__user-and-meta mb-3">
                            <div class="blog-details__user inline-block mr-3">
                                {{-- <p><span class="icon-user"></span> By {{ $blogs->author ?? 'Admin' }}</p> --}}
                            </div>
                            <ul class="blog-details__meta list-unstyled inline-flex gap-4">
                                <li><span class="icon-clock"></span> {{ $blogs->created_at->diffForHumans() }}</li>
                            </ul>
                        </div>

                        <h3 class="blog-details__title text-2xl font-bold mb-3">{{ $blogs->title }}</h3>

                        <div class="prose max-w-none text-gray-700">
                            {!! $blogs->content !!}
                        </div>

                        @if($blogs->quote)
                        <div class="blog-details__author-box bg-gray-50 border-l-4 border-gold p-4 my-5 rounded">
                            <h4 class="italic text-gray-600">“{{ $blogs->quote }}”</h4>
                            @if($blogs->quoted_by)
                                <p class="font-semibold mt-2">{{ $blogs->quoted_by }}</p>
                            @endif
                        </div>
                        @endif

                        <div class="blog-details__tag-and-share border-t border-gray-200 pt-4 mt-6 flex justify-between">
                            <div class="blog-details__tag">
                                <h3 class="blog-details__tag-title font-semibold">Tags :</h3>
                                <ul class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $blogs->tags ?? '') as $tag)
                                        <li><a href="#" class="text-gold hover:underline">{{ trim($tag) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="blog-details__share-box">
                                <h3 class="font-semibold mb-2">Share :</h3>
                                <div class="flex gap-2 text-gold">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->fullUrl()) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-5">
                <div class="sidebar">
                    <!-- Search -->


                    <!-- Recent Posts -->
                    <div class="sidebar__single sidebar__post wow fadeInUp" data-wow-delay=".1s">
                        <h3 class="sidebar__title">Recent Posts</h3>
                        <div class="sidebar__post-box">
                            @foreach(\App\Models\Blog::latest()->take(3)->get() as $recent)
                                <div class="sidebar__post-single flex gap-3 mb-3">
                                    <div class="sidebar-post__img w-1/3">
                                        <img src="{{ asset('storage/' . $recent->featured_image) }}" alt="{{ $recent->title }}" class="rounded">
                                    </div>
                                    <div class="sidebar__post-content-box w-2/3">
                                        <h3 class="text-sm font-semibold">
                                            <a href="{{ route('blogs.show', $recent->slug) }}" class="hover:text-gold">
                                                {{ $recent->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags -->

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details End -->



@endsection
