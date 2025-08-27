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
