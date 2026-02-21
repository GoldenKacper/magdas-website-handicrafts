@extends('admin.layouts.auth-app')

@section('title', __('admin/messages.title_meta_verify_email'))
@section('bodyDataPage', $page ?? 'auth')

@section('content')
    <x-admin.auth-section>
        <x-admin.auth-card :title="__('admin/messages.verify_email')">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('admin/messages.verification_link_sent') }}
                </div>
            @endif

            {{ __('admin/messages.check_email_for_verification') }}
            {{ __('admin/messages.did_not_receive_email') }},
            <form class="d-inline" method="POST"
                action="{{ route('verification.resend', ['locale' => session('locale', app()->getLocale())]) }}">
                @csrf
                <button type="submit"
                    class="btn btn-link p-0 m-0 align-baseline">{{ __('admin/messages.click_here_to_request_another') }}</button>.
            </form>
        </x-admin.auth-card>
    </x-admin.auth-section>
@endsection
