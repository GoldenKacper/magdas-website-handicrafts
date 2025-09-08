@extends('layouts.error_app')

@section('title', __('messages.page_not_found'))

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center vh-100 text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <h2 class="mb-3">{{ __('messages.page_not_found') }}</h2>
        <p class="mb-4">{{ __('messages.page_not_found_description') }}</p>
        <a href="{{ route('home', ['locale' => session('locale', app()->getLocale())]) }}" class="btn btn-primary btn-lg">
            {{ __('messages.back_to_home') }}
        </a>
    </div>
@endsection
