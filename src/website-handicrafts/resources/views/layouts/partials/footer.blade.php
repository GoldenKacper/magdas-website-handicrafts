<footer class="footer bg-pale mt-0 pt-5 pt-lg-7" role="contentinfo" aria-label="Stopka strony">
    <div class="container">
        <div class="row gy-4 justify-content-start">
            {{-- About --}}
            <div class="footer-scroll-animation order-animation-0 col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">{{ __('messages.footer_about_title') }}</h4>
                <p class="footer-text mb-2">
                    {{ __('messages.footer_about_text_1') }} <a href="#"
                        class="footer-link gradient-animated-footer"
                        data-text="{{ __('messages.footer_about_link_1') }}">{{ __('messages.footer_about_link_1') }}</a>.
                </p>
                <p class="footer-text mb-0">{{ __('messages.footer_about_text_2a') }} <a href="#faq"
                        class="footer-link gradient-animated-footer"
                        data-text="{{ __('messages.footer_about_link_2') }}">{{ __('messages.footer_about_link_2') }}</a>
                    {{ __('messages.footer_about_text_2b') }}.
                </p>
            </div>

            <hr class="d-block d-sm-none">

            {{-- Social --}}
            <div class="footer-scroll-animation order-animation-1 col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">{{ __('messages.footer_social_title') }}</h4>

                <ul class="footer-social list-unstyled d-flex gap-2 mb-3"
                    aria-label="Linki do mediów społecznościowych">
                    <li>
                        <a class="social-link" href="#" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-link" href="#" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-link" href="#" target="_blank" rel="noopener noreferrer"
                            aria-label="X / Twitter">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-link" href="#" target="_blank" rel="noopener noreferrer"
                            aria-label="Pinterest">
                            <i class="fa-brands fa-pinterest"></i>
                        </a>
                    </li>
                </ul>

                <p class="small text-muted mb-0">{{ __('messages.footer_opinions_and_gallery') }}</p>
            </div>

            <hr class="d-block d-sm-none">

            {{-- Contact --}}
            <div class="footer-scroll-animation order-animation-2 col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">{{ __('messages.footer_contact_title') }}</h4>

                <ul class="list-unstyled footer-contact mb-4 mb-lg-3">
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-regular fa-envelope me-3" aria-hidden="true"></i>
                            <a href="#" class="footer-link gradient-animated-footer"
                                data-text="{{ __('messages.footer_contact_form') }}">
                                {{ __('messages.footer_contact_form') }}
                            </a>
                        </div>

                    </li>
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-regular fa-envelope-open me-3" aria-hidden="true"></i>
                            <a href="mailto:magda.handicrafts@gmail.com" class="footer-link gradient-animated-footer"
                                data-text="{{ __('messages.footer_mail') }}">
                                {{ __('messages.footer_mail') }}
                            </a>
                        </div>

                    </li>
                    <li>
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-solid fa-phone me-3" aria-hidden="true"></i>
                            <a href="tel:+48123456789" class="footer-link gradient-animated-footer"
                                data-text="{{ __('messages.footer_phone_number') }}">
                                {{ __('messages.footer_phone_number') }}
                            </a>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- bottom bar --}}
    <div class="footer-bottom mt-4 mt-lg-7 py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 text-center text-md-start small">
                    <a href="#" class="footer-link small">© {{ date('Y') }}
                        {{ __('messages.footer_copyright') }}</a>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end small">
                    <a href="#" class="footer-link small me-3">{{ __('messages.footer_privacy_policy') }}</a>
                    <a href="#" class="footer-link small">{{ __('messages.footer_terms_of_service') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
