@extends('layouts.app')

@section('title', __('messages.title_meta'))
@section('metaDescription', __('messages.description_meta'))
@section('metaKeywords', __('messages.keywords_meta'))
@section('metaRobots', 'index, follow')

@section('ogTitle', __('messages.og_title_meta'))
@section('ogDescription', __('messages.og_description_meta'))
@section('ogImage', Vite::asset('resources/images/magdas_website_home_og_25_09_2025.webp'))
@section('ogType', 'website')

@section('twitterCard', 'summary_large_image')
@section('twitterSite', __('messages.twitter_site_meta'))
@section('twitterCreator', __('messages.twitter_creator_meta'))
@section('twitterTitle', __('messages.twitter_title_meta'))
@section('twitterDescription', __('messages.twitter_description_meta'))
@section('twitterImage', Vite::asset('resources/images/magdas_website_home_og_25_09_2025.webp'))
@section('twitterImageAlt', __('messages.twitter_image_alt_meta'))

@section('bodyDataPage', $page ?? 'home')

@section('content')
    {{-- HERO --}}
    <section class="hero position-relative d-flex align-items-center"
        style="--hero-bg: url('{{ Vite::asset('resources/images/magdas_website_home_bg_27_08_2025_demo.png') }}');"
        role="img" aria-label="{{ __('messages.hero_image_alt', [], app()->getLocale()) }}">
        <div class="hearts">
            @for ($i = 0; $i < 8; $i++)
                <div class="heart heart-animation"></div>
            @endfor
        </div>

        {{-- overlay gradient (we keep overlay here so it always sits above the bg image) --}}
        <div class="hero-overlay" aria-hidden="true"></div>

        <div class="hero-content container text-center text-pale">
            <h1 class="display-4 fw-bold mb-3">{{ __('messages.hero_title') }}</h1>
            <p class="lead mb-4">{{ __('messages.hero_subtitle') }}</p>
            <a href="{{ route('gallery', ['locale' => session('locale', app()->getLocale())]) }}"
                class="btn btn-lg btn-gradient--transparent text-size-3/2">
                {{ __('messages.hero_cta') }}
            </a>
        </div>
    </section>

    {{-- Offer Section --}}
    <section class="mb-0 pb-4-5 pb-lg-7 bg-pale with-divider offer-section">
        <div class="container-fluid">
            <div class="mb-4 mb-lg-5">
                <h2 class="display-5 fw-bold text-center heading-underline">{{ __('messages.offer_heading') }}:</h2>
            </div>

            <div class="row g-3 g-lg-8 justify-content-center mx-lg-9">
                @foreach ($categories as $category)
                    <div class="col-12 col-sm-6 col-xl-4">
                        <a href="{{ route('gallery', ['locale' => session('locale', app()->getLocale())]) }}#{{ $category->slug }}"
                            class="offer-card p-3 p-lg-0" aria-label="{{ $category?->label_meta }}">
                            <span class="offer-media">
                                <img src="{{ $category?->image_url ?? Vite::asset('resources/images/magdas_website_offer_bracelet_31_08_2025_demo.png') }}"
                                    alt="{{ $category?->image_alt }}" loading="lazy">
                                <span class="offer-caption-overlay display-6 fw-bold">{{ $category?->name }}</span>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- About Me Section --}}
    <section id="about" class="about-section py-4 py-lg-5"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_home_about_me_bg_01_09_2025_demo_v2.webp') }}');"
        aria-label="{{ __('messages.about_section_alt') }}">

        <div class="container">
            <div class="row align-items-center gy-4">
                {{-- Left: author image (col-5 on md+, stacks on small) --}}
                <div class="col-12 col-lg-5 d-flex justify-content-center justify-content-md-start order-2 order-lg-1">
                    <figure class="about-figure mb-0">
                        <img src="{{ $aboutMe?->about_author_image_url ?? Vite::asset('resources/images/magdas_website_home_about_me_author_01_09_2025_demo.png') }}"
                            alt="{{ $aboutMe?->about_author_image_alt }}" loading="lazy"
                            class="about-author-img img-fluid">
                    </figure>
                </div>

                {{-- Right: title + description + CTA (col-7 on md+) --}}
                <div class="col-12 col-lg-7 little-lower order-1 order-lg-2">
                    <h2 class="about-title display-6 fw-bold mb-3 text-shadow"><i class="fa-regular fa-heart"></i>
                        {{ __('messages.about_title') }} <i class="fa-regular fa-heart"></i></h2>

                    <p class="about-text lead mb-4 text-shadow">
                        {{ $aboutMe?->content }}
                    </p>

                    <a href="{{ route('about', ['locale' => session('locale', app()->getLocale())]) }}"
                        class="btn btn-lg btn-gradient--transparent text-size-3/2 text-shadow">
                        {{ __('messages.about_read_more') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Opinions section --}}
    <section id="opinions" class="opinions-section bg-pale pb-3 pb-lg-5 pt-5 mb-3 mb-lg-0 mt-0 mt-lg-2">
        <div class="container-fluid">
            <div class="text-center mb-4">
                <h2 class="opinions-title display-6 fw-bold mb-2 opacity-anim"><i class="fa-regular fa-star"></i>
                    {{ __('messages.opinions_title') }} <i class="fa-regular fa-star"></i></h2>
                <p class="opinions-subtitle lead mb-4 opacity-anim">
                    {{ __('messages.opinions_subtitle') }}</p>
            </div>

            <div class="row g-3 g-lg-8 mx-lg-8 opinions-grid justify-content-center">
                {{-- Opinions --}}
                @foreach ($opinions as $opinion)
                    <div id="{{ $opinion->slug }}" class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                        <article class="opinion-card p-3 p-lg-3 h-100 text-center"
                            aria-label="{{ $opinion?->label_meta }}">
                            <div class="opinion-avatar mb-3">
                                <img src="{{ $opinion?->image_url ?? Vite::asset('resources/images/magdas_website_home_1_opinion_02_09_2025.png') }}"
                                    alt="{{ $opinion?->image_alt }}" class="rounded-circle img-fluid">
                            </div>
                            <h4 class="opinion-name mb-1">{{ $opinion?->first_name }}</h4>
                            <p class="opinion-text fst-italic mb-0">{{ $opinion?->content }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ / Questions & Answers Section --}}
    <section id="faq" class="faq-section pb-5 pb-lg-5 pt-5 pt-lg-7" aria-label="{{ __('messages.faq_section_alt') }}"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_faq_bg_02_09_2025_demo_v2.webp') }}');">

        <div class="container">
            <div class="row justify-content-center text-center mb-2 mb-lg-4">
                <div class="col-12 col-md-10">
                    <h2 class="faq-title display-6 fw-bold mb-2 text-pale text-shadow"><i
                            class="fa-regular fa-question-circle"></i>
                        {{ __('messages.faq_title') }}
                    </h2>
                    <p class="faq-subtitle lead mb-4 text-shadow">
                        {{ __('messages.faq_subtitle') }}
                    </p>
                </div>
            </div>

            <div class="row justify-content-center mb-0 mb-lg-3">
                <div class="col-12 col-lg-10">
                    {{-- frosted panel --}}
                    <div class="faq-panel p-3 p-lg-5 shadow-soft">
                        <div class="faq-grid row gy-3">

                            {{-- FAQ item --}}
                            @foreach ($faqs as $faq)
                                <div class="col-12">
                                    <div class="faq-item" data-faq-index="{{ $faq->id }}">
                                        <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                            aria-expanded="false" aria-controls="faq-panel-{{ $faq->id }}"
                                            id="faq-btn-{{ $faq->id }}">
                                            <span class="d-flex align-items-center gap-2">
                                                {!! $faq?->icon !!}
                                                <span class="faq-q-text fw-bold">{{ $faq?->question }}</span>
                                            </span>

                                            <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                        </button>

                                        <div id="faq-panel-{{ $faq->id }}" class="faq-answer" role="region"
                                            aria-labelledby="faq-btn-{{ $faq->id }}" hidden>
                                            <p>{{ $faq?->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
