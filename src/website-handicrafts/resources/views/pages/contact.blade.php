@extends('layouts.app')

@section('title', __('messages.contact_title_meta'))
@section('metaDescription', __('messages.contact_description_meta'))
@section('metaKeywords', __('messages.contact_keywords_meta'))
@section('metaRobots', 'index, follow')

@section('ogTitle', __('messages.contact_og_title_meta'))
@section('ogDescription', __('messages.contact_og_description_meta'))
@section('ogImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('ogType', 'website')

@section('twitterCard', 'summary_large_image')
@section('twitterSite', __('messages.twitter_site_meta'))
@section('twitterCreator', __('messages.twitter_creator_meta'))
@section('twitterTitle', __('messages.contact_twitter_title_meta'))
@section('twitterDescription', __('messages.contact_twitter_description_meta'))
@section('twitterImage', Vite::asset('resources/images/magdas_website_home_og_26_08_2025_demo.webp'))
@section('twitterImageAlt', __('messages.twitter_image_alt_meta'))

@section('bodyDataPage', $page ?? 'contact')


@push('head')
    {{-- Important - this content have to be before vite --}}
    @php
        // List of translation keys we want available in JS on every page
        $i18n_keys = [
            'contact_form_first_name',
            'contact_form_last_name',
            'contact_form_email',
            'contact_form_message',
            'validation_required',
            'contact_form_reset',
            'contact_form_send',
            'validation_min',
            'validation_max',
            'validation_email_invalid',
            'validation_all_valid',
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
    {{-- FAQ / Questions & Answers Section --}}
    <section id="faq" class="faq-section pb-5 pb-lg-5 pt-5 pt-lg-7" aria-label="{{ __('messages.faq_section_alt') }}"
        style="background-image: url('{{ Vite::asset('resources/images/magdas_website_faq_bg_02_09_2025_demo_v2.webp') }}');">

        <div class="container-fluid">
            <div class="min-vh-80 row justify-content-center mb-0 mb-lg-3 d-flex align-items-center">

                <div class="col-12 col-lg-6 ps-lg-5 pe-lg-4 mb-5 mb-lg-0">
                    {{-- Heading frosted panel --}}
                    <div class="justify-content-center text-center mb-3 mb-lg-5">
                        <h2 class="faq-title display-6 fw-bold mb-2 text-pale text-shadow"><i
                                class="fa-regular fa-question-circle"></i>
                            {{ __('messages.faq_title') }}
                        </h2>
                        <p class="faq-subtitle lead mb-4 text-shadow">
                            {{ __('messages.faq_subtitle') }}
                        </p>
                    </div>

                    {{-- frosted panel --}}
                    <div class="faq-panel p-3 p-lg-5 shadow-soft">
                        <div class="faq-grid row gy-3">

                            {{-- FAQ item --}}
                            @foreach ($faqs as $faq)
                                <div class="col-12">
                                    <div class="faq-item" data-faq-index="{{ $faq->id }}">
                                        <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                            aria-expanded="false" aria-controls="faq-panel-{{ $faq->id }}"
                                            id="faq-btn-{{ $faq->id }}">
                                            <span class="d-flex align-items-center gap-2">
                                                {!! $faq?->icon !!}
                                                <span class="faq-q-text fw-bold">{{ $faq?->question }}</span>
                                            </span>

                                            <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                        </button>

                                        <div id="faq-panel-{{ $faq->id }}" class="faq-answer" role="region"
                                            aria-labelledby="faq-btn-{{ $faq->id }}" hidden>
                                            <p>{{ $faq?->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 pe-lg-5 ps-lg-4 contact-panel-wrapper">
                    {{-- Heading Contact form panel --}}
                    <div class="contact-panel-header justify-content-center text-center mb-3 mb-lg-5">
                        <h2 class="contact-panel-title display-6 fw-bold mb-2 text-pale text-shadow"><i
                                class="fa-regular fa-envelope"></i>
                            {{ __('messages.contact_form_title') }}
                        </h2>
                        <p class="contact-panel-subtitle lead mb-4 text-shadow">
                            {{ __('messages.contact_form_subtitle') }}
                        </p>
                    </div>

                    {{-- Flash success --}}
                    @if (session('status'))
                        <div class="alert alert-success mb-4 rounded-4">{{ session('status') }}</div>
                    @endif

                    {{-- Contact form panel --}}
                    <form id="contact-form" class="contact-panel p-0"
                        action="{{ route('contact.send', ['locale' => session('locale', app()->getLocale())]) }}"
                        method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- First name --}}
                            <div class="col-12 col-md-6">
                                <label for="contact_first_name" class="form-label visually-hidden">
                                    {{ __('messages.contact_form_first_name') }}
                                </label>

                                <div class="input-icon">
                                    <span class="input-icon__icon" aria-hidden="true">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input id="contact_first_name" name="first_name" type="text"
                                        class="form-control input-icon__control"
                                        placeholder="{{ __('messages.contact_form_first_name') }}" required />
                                </div>
                                <div class="feedback @error('first_name') text-danger @else visually-hidden @enderror"
                                    id="contact_first_name_feedback">
                                    @error('first_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            {{-- Last name --}}
                            <div class="col-12 col-md-6">
                                <label for="contact_last_name" class="form-label visually-hidden">
                                    {{ __('messages.contact_form_last_name') }}
                                </label>

                                <div class="input-icon">
                                    <span class="input-icon__icon" aria-hidden="true">
                                        <i class="fa-solid fa-user-tag"></i>
                                    </span>
                                    <input id="contact_last_name" name="last_name" type="text"
                                        class="form-control input-icon__control"
                                        placeholder="{{ __('messages.contact_form_last_name') }}" />
                                </div>
                                <div class="feedback @error('last_name') text-danger @else visually-hidden @enderror"
                                    id="contact_last_name_feedback">
                                    @error('last_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <label for="contact_email" class="form-label visually-hidden">
                                    {{ __('messages.contact_form_email') }}
                                </label>

                                <div class="input-icon">
                                    <span class="input-icon__icon" aria-hidden="true">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input id="contact_email" name="email" type="email"
                                        class="form-control input-icon__control"
                                        placeholder="{{ __('messages.contact_form_email') }}" required />
                                </div>
                                <div class="feedback @error('email') text-danger @else visually-hidden @enderror"
                                    id="contact_email_feedback">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            {{-- Message (textarea) --}}
                            <div class="col-12">
                                <label for="contact_message" class="form-label visually-hidden">
                                    {{ __('messages.contact_form_message') }}
                                </label>

                                <div class="input-icon input-icon--textarea">
                                    <span class="input-icon__icon" aria-hidden="true">
                                        <i class="fa-solid fa-comment-dots"></i>
                                    </span>
                                    <textarea id="contact_message" name="message" class="form-control input-icon__control"
                                        placeholder="{{ __('messages.contact_form_message_placeholder') }}" rows="5" required></textarea>
                                </div>
                                <div class="feedback @error('message') text-danger @else visually-hidden @enderror"
                                    id="contact_message_feedback">
                                    @error('message')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-12 d-flex gap-2 justify-content-between flex-wrap">
                                <button type="reset"
                                    class="btn btn-gradient py-2 px-lg-4 order-0 order-lg-1 d-flex align-items-center justify-content-center"
                                    title="{{ __('messages.contact_form_reset_title') }}">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                    <span class="btn-text">&nbsp;{{ __('messages.contact_form_reset') }}</span>
                                </button>

                                <button type="submit"
                                    class="btn btn-gradient py-2 px-lg-4 order-1 order-lg-0 d-flex align-items-center justify-content-center"
                                    disabled title="{{ __('messages.contact_form_send_title') }}">
                                    <i class="fa-regular fa-paper-plane"></i>
                                    <span class="btn-text">&nbsp;{{ __('messages.contact_form_send') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
