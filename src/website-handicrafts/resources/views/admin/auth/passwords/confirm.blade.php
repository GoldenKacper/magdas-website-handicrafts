@extends('admin.layouts.auth-app')

@section('title', __('admin/messages.title_meta_confirm'))
@section('bodyDataPage', $page ?? 'auth')

@section('content')
    <x-admin.auth-section>
        <x-admin.auth-card :title="__('admin/messages.password_confirmation')">
            {{ __('admin/messages.please_confirm_your_password') }}

            <form method="POST"
                action="{{ route('password.confirm', ['locale' => session('locale', app()->getLocale())]) }}">
                @csrf

                <div class="row mb-3">
                    <label for="password" class="col-lg-3 col-md-4 col-form-label text-md-end"><i
                            class="fa-solid fa-lock me-1"></i>{{ __('admin/messages.password') }}</label>

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

                <div class="row mb-0">
                    <div class="col-lg-7 col-md-6 offset-lg-3 offset-md-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-gradient">
                            {{ __('admin/messages.password_confirmation') }}
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
