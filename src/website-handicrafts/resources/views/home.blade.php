@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center mb-5">
        @php
            $n = 0;
        @endphp
        {{-- simple translation: --}}
        <h1>{{ __('messages.welcome') }}</h1>

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

    <div class="jumbotron text-center mb-5">
        <h1 class="display-4">Welcome to Handmade Jewelry Store!</h1>
        <p class="lead">Discover unique, handcrafted bracelets and necklaces made with love.</p>
        <hr class="my-4">
        <p>Explore our collection and find the perfect piece for you or your loved ones.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Shop Now</a>
    </div>
@endsection
