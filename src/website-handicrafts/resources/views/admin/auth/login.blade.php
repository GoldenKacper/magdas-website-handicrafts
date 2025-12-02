@extends('admin.layouts.auth-app')

@section('title', __('admin/messages.title_meta_login'))
@section('bodyDataPage', $page ?? 'auth')


@section('content')
    <x-admin.auth-section>
        <x-admin.auth-card :title="__('admin/messages.login')">
            <form method="POST" action="{{ route('login', ['locale' => session('locale', app()->getLocale())]) }}">
                @csrf

                <div class="row mb-3">
                    <label for="email" class="col-lg-3 col-md-4 col-form-label text-md-end"><i
                            class="fa-solid fa-envelope me-1"></i> {{ __('admin/messages.email') }}</label>

                    <div class="col-lg-7 col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-lg-3 col-md-4 col-form-label text-md-end"><i
                            class="fa-solid fa-lock me-1"></i> {{ __('admin/messages.password') }}</label>

                    <div class="col-lg-7 col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-7 col-md-6 offset-lg-3 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('admin/messages.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-lg-7 col-md-6 offset-lg-3 offset-md-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-gradient">
                            {{ __('admin/messages.login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link"
                                href="{{ route('password.request', ['locale' => session('locale', app()->getLocale())]) }}">
                                {{ __('admin/messages.forgot_password') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </x-admin.auth-card>
    </x-admin.auth-section>
@endsection
