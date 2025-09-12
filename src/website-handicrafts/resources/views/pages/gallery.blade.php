@extends('layouts.app')

@section('title', __('messages.gallery_title_meta'))
@section('metaDescription', __('messages.gallery_description_meta'))
@section('metaKeywords', __('messages.gallery_keywords_meta'))
@section('metaRobots', 'index, follow')

@section('ogTitle', __('messages.gallery_og_title_meta'))
@section('ogDescription', __('messages.gallery_og_description_meta'))
@section('ogImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('ogType', 'website')

@section('twitterCard', 'summary_large_image')
@section('twitterSite', __('messages.twitter_site_meta'))
@section('twitterCreator', __('messages.twitter_creator_meta'))
@section('twitterTitle', __('messages.gallery_twitter_title_meta'))
@section('twitterDescription', __('messages.gallery_twitter_description_meta'))
@section('twitterImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('twitterImageAlt', __('messages.twitter_image_alt_meta'))

@section('bodyDataPage', $page ?? 'gallery')

@push('head')
    {{-- Important - this content have to be before vite --}}
    @php
        // List of translation keys we want available in JS on every page
        $i18n_keys = [
            'gallery_modal_close',
            'gallery_modal_loading',
            'gallery_modal_error',
            'gallery_modal_error_message',
        ];

        $i18n = [];
        foreach ($i18n_keys as $k) {
            $i18n[$k] = __('messages.' . $k); // trans() or __()
        }
    @endphp

    <script>
        // expose translations to JS
        window.LaravelTranslations = @json($i18n, JSON_UNESCAPED_UNICODE);
    </script>
@endpush

@section('content')

    {{-- Gallery Section --}}
    <section id="gallery" class="gallery-section py-4 py-lg-5"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_gallery_bg_10_09_2025_demo.webp') }}');"
        aria-label="{{ __('messages.gallery_section_alt') }}">


        <div class="container-fluid">

            {{-- ROWS --}}
            {{-- Gallery (dynamic) --}}
            @foreach ($categories as $cat)
                @php
                    $title = $cat?->name ?? ($cat->slug ?? 'Kategoria');
                @endphp

                @if ($cat->products->isEmpty())
                    @continue
                @endif

                <div class="gallery-row mb-5" id="{{ $cat->slug }}" data-gallery="{{ $cat->slug }}">
                    <h2 class="gallery-row-title display-6 fw-bold mb-4 mb-lg-4-5 text-shadow">
                        <i class="fa-solid fa-camera"></i> {{ $title }} <i class="fa-solid fa-camera"></i>
                    </h2>

                    <div class="gallery-viewport" tabindex="0" aria-roledescription="carousel"
                        aria-label="{{ $title }} carousel">
                        <div class="gallery-strip" data-auto="5000" data-visible-lg="5" role="group"
                            aria-label="{{ __('messages.gallery_scrollable_list_meta') }} — {{ $title }}"
                            data-gallery-track>

                            <ul class="gallery-track list-unstyled m-0 p-0" data-track>
                                @foreach ($cat->products as $p)
                                    <li class="gallery-item" data-idx="{{ $p->id }}">
                                        <a class="tile" data-id="{{ $p->id }}" data-type="{{ $p->slug }}"
                                            aria-label="{{ $p?->name }}">
                                            <span class="tile-media">
                                                <img src="{{ $p?->product_image_url }}"
                                                    alt="{{ $p?->product_image_alt ?? $p?->name }}" loading="lazy">
                                            </span>

                                            <span class="tile-overlay">
                                                <span class="tile-caption fw-bold"
                                                    title="{{ __('messages.gallery_title_show') }}">
                                                    {{ $p?->short_name ?? $p?->name }}
                                                </span>

                                                <span class="tile-actions">
                                                    <button class="tile-btn tile-open" type="button"
                                                        aria-label="{{ __('messages.gallery_title_previous') }}"
                                                        title="{{ __('messages.gallery_title_previous') }}">
                                                        <i class="fa-solid fa-arrow-left"></i>
                                                    </button>
                                                    <button class="tile-btn tile-go" type="button"
                                                        aria-label="{{ __('messages.gallery_title_next') }}"
                                                        title="{{ __('messages.gallery_title_next') }}">
                                                        <i class="fa-solid fa-arrow-right"></i>
                                                    </button>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </section>
@endsection
