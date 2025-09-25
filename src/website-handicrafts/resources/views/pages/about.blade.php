@extends('layouts.app')

@section('title', __('messages.about_title_meta'))
@section('metaDescription', __('messages.about_description_meta'))
@section('metaKeywords', __('messages.about_keywords_meta'))
@section('metaRobots', 'index, follow')

@section('ogTitle', __('messages.about_og_title_meta'))
@section('ogDescription', __('messages.about_og_description_meta'))
@section('ogImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('ogType', 'website')

@section('twitterCard', 'summary_large_image')
@section('twitterSite', __('messages.twitter_site_meta'))
@section('twitterCreator', __('messages.twitter_creator_meta'))
@section('twitterTitle', __('messages.about_twitter_title_meta'))
@section('twitterDescription', __('messages.about_twitter_description_meta'))
@section('twitterImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('twitterImageAlt', __('messages.twitter_image_alt_meta'))

@section('bodyDataPage', $page ?? 'about')

@section('content')
    {{-- About Me Section --}}
    <section id="about" class="about-section py-4 py-lg-5"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_home_about_me_bg_01_09_2025_demo_v2.webp') }}');"
        aria-label="{{ __('messages.about_section_alt') }}">

        <div class="container-fluid">
            <div class="row align-items-center">
                {{-- Title + descriptions + CTA --}}
                <div
                    class="min-vh-80 offset-0 offset-lg-4 col-12 col-lg-8 ps-lg-4 pe-lg-5 d-flex flex-column justify-content-evenly align-items-center">
                    <div>
                        <h2 class="about-title display-6 fw-bold mb-3 mb-lg-4 text-shadow"><i class="fa-regular fa-heart"></i>
                            {{ __('messages.about_title') }} <i class="fa-regular fa-heart"></i></h2>

                        {{-- First element (index 0) --}}
                        <p class="about-text about-text--left lead text-shadow">
                            {{ $aboutMe->translationWithFallback->first()?->content ?? '' }}
                        </p>
                    </div>

                    {{-- Subsequent elements from index 1 --}}
                    @for ($i = 1; $i < $aboutMe->translationWithFallback->count(); $i++)
                        @php
                            $translation = $aboutMe->translationWithFallback->get($i);
                            // even -> right, odd -> left (because the first in the loop = right)
                            $class = $i % 2 === 1 ? 'about-text--right' : 'about-text--left';
                        @endphp
                        <div>
                            <p class="about-text {{ $class }} lead text-shadow">
                                {{ $translation?->content ?? '' }}
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <figure class="about-figure">
            <img src="{{ $aboutMe?->about_author_image_url ?? Vite::asset('resources/images/magdas_website_home_about_me_author_01_09_2025_demo.png') }}"
                alt="{{ $aboutMe->translationWithFallback->first()?->about_author_image_alt }}"
                class="about-author-img img-fluid">
        </figure>

    </section>
@endsection
