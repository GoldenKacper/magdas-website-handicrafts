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

                            {{-- FAQ item (kopiuj/edytuj) --}}
                            <div class="col-12">
                                <div class="faq-item" data-faq-index="1">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-1" id="faq-btn-1">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-question faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Jak mogę złożyć zamówienie?</span>
                                        </span>

                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>

                                    <div id="faq-panel-1" class="faq-answer" role="region" aria-labelledby="faq-btn-1"
                                        hidden>
                                        <p>Możesz zamówić przez formularz kontaktowy lub bezpośrednio w sklepie — wybierz
                                            produkt, dodaj do koszyka i przejdź do płatności. W razie problemów napisz do
                                            nas.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Dodaj kolejne elementy FAQ --}}
                            <div class="col-12">
                                <div class="faq-item" data-faq-index="2">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-2" id="faq-btn-2">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-shipping-fast faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Ile trwa wysyłka?</span>
                                        </span>
                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>

                                    <div id="faq-panel-2" class="faq-answer" role="region" aria-labelledby="faq-btn-2"
                                        hidden>
                                        <p>Na ogół wysyłka trwa 2–5 dni roboczych. Dokładny termin zależy od opcji wysyłki i
                                            lokalizacji klienta.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- przykłady: 3,4 --}}
                            <div class="col-12">
                                <div class="faq-item" data-faq-index="3">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-3" id="faq-btn-3">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-rotate-right faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Czy mogę zwrócić produkt?</span>
                                        </span>
                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>
                                    <div id="faq-panel-3" class="faq-answer" role="region" aria-labelledby="faq-btn-3"
                                        hidden>
                                        <p>Tak — przyjmujemy zwroty w ciągu 14 dni od otrzymania, jeśli produkt jest w
                                            stanie nienaruszonym.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="faq-item" data-faq-index="4">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-4" id="faq-btn-4">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-hand-holding-heart faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Czy oferujesz personalizacje?</span>
                                        </span>
                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>
                                    <div id="faq-panel-4" class="faq-answer" role="region" aria-labelledby="faq-btn-4"
                                        hidden>
                                        <p>Tak — oferuję grawer, dobór kolorów i pudełek — skontaktuj się ze mną, żeby
                                            omówić szczegóły.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- przykłady: 5,6 --}}
                            <!-- FAQ item: Warranty -->
                            <div class="col-12">
                                <div class="faq-item" data-faq-index="5">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-5" id="faq-btn-5">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-award faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Czy produkty mają gwarancję?</span>
                                        </span>

                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>

                                    <div id="faq-panel-5" class="faq-answer" role="region" aria-labelledby="faq-btn-5"
                                        hidden>
                                        <p>Tak — wszystkie nasze wyroby objęte są 12-miesięczną gwarancją na wady
                                            produkcyjne. Jeśli coś
                                            się zdarzy, skontaktuj się z nami — omówimy naprawę lub wymianę.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ item: Sizing -->
                            <div class="col-12">
                                <div class="faq-item" data-faq-index="6">
                                    <button class="faq-question d-flex align-items-center justify-content-between w-100"
                                        aria-expanded="false" aria-controls="faq-panel-6" id="faq-btn-6">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-ruler faq-q-icon" aria-hidden="true"></i>
                                            <span class="faq-q-text fw-bold">Jak dobrać właściwy rozmiar
                                                bransoletki?</span>
                                        </span>

                                        <i class="fa-solid fa-chevron-down faq-chevron" aria-hidden="true"></i>
                                    </button>

                                    <div id="faq-panel-6" class="faq-answer" role="region" aria-labelledby="faq-btn-6"
                                        hidden>
                                        <p>Aby dobrać rozmiar: zmierz obwód nadgarstka miękką taśmą krawiecką lub nitką, a
                                            następnie dodaj
                                            ~1,5–2 cm luzu dla komfortu. W razie wątpliwości podaj nam pomiar — pomożemy
                                            dobrać idealny rozmiar.
                                        </p>
                                    </div>
                                </div>
                            </div>

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

                    {{-- Contact form panel --}}
                    <form id="contact-form" class="contact-panel p-0" action="#" method="POST" novalidate>
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
                                <div class="feedback visually-hidden" id="contact_first_name_feedback"></div>
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
                                <div class="feedback visually-hidden" id="contact_last_name_feedback"></div>
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
                                <div class="feedback visually-hidden" id="contact_email_feedback"></div>
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
                                <div class="feedback visually-hidden" id="contact_message_feedback"></div>
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
