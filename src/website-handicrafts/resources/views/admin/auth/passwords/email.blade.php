@extends('admin.layouts.auth-app')

@section('title', __('admin/messages.title_meta_email'))
@section('bodyDataPage', content: $page ?? 'auth')

@section('content')
    <x-admin.auth-section>
        <x-admin.auth-card :title="__('admin/messages.reset_password')">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email', ['locale' => session('locale', app()->getLocale())]) }}">
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

                <div class="row mb-0">
                    <div class="col-lg-7 col-md-6 offset-lg-3 offset-md-4">
                        <button type="submit" class="btn btn-gradient">
                            {{ __('admin/messages.send_password_reset_link') }}
                        </button>
                    </div>
                </div>
            </form>
        </x-admin.auth-card>
    </x-admin.auth-section>
@endsection
