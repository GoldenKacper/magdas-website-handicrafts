@extends('admin.layouts.auth-app')

@section('title', __('admin/messages.title_meta_register'))
@section('bodyDataPage', $page ?? 'auth')

@section('content')
    <x-admin.auth-section>
        <x-admin.auth-card :title="__('admin/messages.register')" :show="config('app.allow_registration') === true">
            <form method="POST" action="{{ route('register', ['locale' => app()->getLocale()]) }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-lg-3 col-md-4 col-form-label text-md-end"><i class="fa-solid fa-user"></i>
                        {{ __('admin/messages.name') }}</label>

                    <div class="col-lg-7 col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-lg-3 col-md-4 col-form-label text-md-end"><i
                            class="fa-solid fa-envelope me-1"></i> {{ __('admin/messages.email') }}</label>

                    <div class="col-lg-7 col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

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
                            name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-lg-3 col-md-4 col-form-label text-md-end"><i
                            class="fa-solid fa-unlock me-1"></i> {{ __('admin/messages.password_confirmation') }}</label>

                    <div class="col-lg-7 col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-lg-7 col-md-6 offset-lg-3 offset-md-4">
                        <button type="submit" class="btn btn-gradient">
                            {{ __('admin/messages.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </x-admin.auth-card>
    </x-admin.auth-section>
@endsection
