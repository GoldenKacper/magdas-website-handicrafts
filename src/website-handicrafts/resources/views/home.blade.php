@extends('layouts.app')

@section('title', __('messages.home_title'))
@section('metaDescription', __('messages.home_description'))
@section('metaKeywords', __('messages.home_keywords'))
@section('metaRobots', 'index, follow')

@section('ogTitle', __('messages.home_og_title'))
@section('ogDescription', __('messages.home_og_description'))
@section('ogImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('ogType', 'website')

@section('twitterCard', 'summary_large_image')
@section('twitterSite', __('messages.home_twitter_site'))
@section('twitterCreator', __('messages.home_twitter_creator'))
@section('twitterTitle', __('messages.home_twitter_title'))
@section('twitterDescription', __('messages.home_twitter_description'))
@section('twitterImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('twitterImageAlt', __('messages.home_twitter_image_alt'))


@section('content')
    {{-- HERO --}}
    <section class="hero position-relative d-flex align-items-center"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_home_bg_27_08_2025_demo.png') }}');"
        role="img" aria-label="{{ __('messages.hero_image_alt', [], app()->getLocale()) }}">
        <div class="hero-content container text-center text-pale">
            <h1 class="display-4 fw-bold mb-3">{{ __('messages.hero_title') }}</h1>
            <p class="lead mb-4">{{ __('messages.hero_subtitle') }}</p>
            <a href="#gallery" class="btn btn-lg btn-gradient--transparent text-size-3/2">
                {{ __('messages.hero_cta') }}
            </a>
        </div>
    </section>

    {{-- Offer Section --}}
    <section class="mb-3 mb-lg-4 pb-5 bg-pale with-divider offer-section">
        <div class="container-fluid">
            <div class="mb-5">
                <h2 class="display-5 fw-bold text-center heading-underline">{{ __('messages.offer_heading') }}:</h2>
            </div>

            {{-- TODO: Add translations (loading from database) --}}
            <div class="row g-3 g-lg-8 justify-content-center mx-lg-9">
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" class="offer-card" aria-label="Oferta — bransoletki">
                        <span class="offer-media">
                            <img src="{{ Vite::asset('resources/images/magdas_website_offer_bracelet_31_08_2025_demo.png') }}"
                                alt="Bransoletki rękodzieło" loading="lazy">
                            <span class="offer-caption-overlay display-6 fw-bold">Bransoletki</span>
                        </span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" class="offer-card" aria-label="Oferta — naszyjniki">
                        <span class="offer-media">
                            <img src="{{ Vite::asset('resources/images/magdas_website_offer_necklace_31_08_2025_demo.png') }}"
                                alt="Naszyjniki rękodzieło" loading="lazy">
                            <span class="offer-caption-overlay display-6 fw-bold">Naszyjniki</span>
                        </span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" class="offer-card" aria-label="Oferta — kolczyki">
                        <span class="offer-media">
                            <img src="{{ Vite::asset('resources/images/magdas_website_offer_earrings_31_08_2025_demo.png') }}"
                                alt="Kolczyki rękodzieło" loading="lazy">
                            <span class="offer-caption-overlay display-6 fw-bold">Kolczyki</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- About Me Section --}}
    <section class="about-section py-4 py-lg-5"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_home_about_me_bg_01_09_2025_demo_v2.webp') }}');"
        aria-label="{{ __('messages.about_section_alt') }}">

        <div class="container">
            <div class="row align-items-center gy-4">
                {{-- Left: author image (col-5 on md+, stacks on small) --}}
                <div class="col-12 col-lg-5 d-flex justify-content-center justify-content-md-start order-2 order-lg-1">
                    <figure class="about-figure mb-0">
                        <img src="{{ Vite::asset('resources/images/magdas_website_home_about_me_author_01_09_2025_demo.png') }}"
                            alt="{{ __('messages.author_image_alt') }}" class="about-author-img img-fluid">
                    </figure>
                </div>

                {{-- Right: title + description + CTA (col-7 on md+) --}}
                <div class="col-12 col-lg-7 little-lower order-1 order-lg-2">
                    <h2 class="about-title display-6 fw-bold mb-3 text-shadow"><i class="fa-regular fa-heart"></i>
                        {{ __('messages.about_title') }} <i class="fa-regular fa-heart"></i></h2>

                    <p class="about-text lead mb-4 text-shadow">
                        {{ __('messages.about_text') }}
                    </p>

                    <a href="#gallery" class="btn btn-lg btn-gradient--transparent text-size-3/2 text-shadow">
                        {{ __('messages.about_read_more') }}
                    </a>
                </div>
            </div>
        </div>
    </section>


    <hr>
    {{-- Dalej reszta treści strony... --}}
    <div class="jumbotron text-center mb-5">
        @php
            $n = 0;
        @endphp
        {{-- simple translation: --}}
        <h1>{{ __('messages.welcome') }}<i class="fa-solid fa-heart"></i>
            <i class="fa-brands fa-instagram"></i>
        </h1>

        {{-- interpolation: --}}
        <p>{{ __('messages.items_count', ['count' => $n]) }}</p>

        {{-- plural: --}}
        <p>{{ trans_choice('messages.apples', $n, ['count' => $n]) }}</p>
    </div>

    <div class="jumbotron text-center mb-5">
        <h1 class="display-4">Welcome to Handmade Jewelry Store!</h1>
        <p class="lead">Discover unique, handcrafted bracelets and necklaces made with love.</p>
        <hr class="my-4">
        <p>Explore our collection and find the perfect piece for you or your loved ones.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Shop Now</a>
    </div>

    <div class="jumbotron text-center mb-5">
        <h1 class="display-4">Welcome to Handmade Jewelry Store!</h1>
        <p class="lead">Discover unique, handcrafted bracelets and necklaces made with love.</p>
        <hr class="my-4">
        <p>Explore our collection and find the perfect piece for you or your loved ones.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Shop Now</a>
    </div>
@endsection
