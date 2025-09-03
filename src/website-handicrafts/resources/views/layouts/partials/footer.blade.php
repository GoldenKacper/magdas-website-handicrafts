<footer class="footer bg-pale mt-0 mt-lg-3 pt-5" role="contentinfo" aria-label="Stopka strony">
    <div class="container">
        <div class="row gy-4 justify-content-start">
            {{-- About --}}
            <div class="col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">O mnie</h4>
                <p class="footer-text mb-2">
                    Rękodzieło z sercem — tworzone z dbałością o detale.
                    <a href="#" class="footer-link gradient-animated-footer" data-text="Poznaj moją historię">Poznaj
                        moją
                        historię</a>.
                </p>
                <p class="footer-text mb-0">
                    Masz pytania? Zajrzyj do <a href="#faq" class="footer-link gradient-animated-footer"
                        data-text="FAQ">FAQ</a> —
                    może tam już
                    znajdziesz
                    odpowiedź.
                </p>
            </div>

            <hr class="d-block d-sm-none">

            {{-- Social --}}
            <div class="col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">Media społecznościowe</h4>

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

                <p class="small text-muted mb-0">Zajrzyj też do naszych opinii i galerii — znajdziesz tam realne
                    realizacje.</p>
            </div>

            <hr class="d-block d-sm-none">

            {{-- Contact --}}
            <div class="col-12 col-md-6 col-lg-4">
                <h4 class="footer-title fw-bold h5 mb-3">Skontaktuj się</h4>

                <ul class="list-unstyled footer-contact mb-4 mb-lg-3">
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-regular fa-envelope me-3" aria-hidden="true"></i>
                            <a href="#" class="footer-link gradient-animated-footer"
                                data-text="Formularz kontaktowy">
                                Formularz kontaktowy
                            </a>
                        </div>

                    </li>
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-regular fa-envelope-open me-3" aria-hidden="true"></i>
                            <a href="mailto:magda.handicrafts@gmail.com" class="footer-link gradient-animated-footer"
                                data-text="magda.handicrafts@gmail.com">
                                magda.handicrafts@gmail.com
                            </a>
                        </div>

                    </li>
                    <li>
                        <div class="d-inline-flex align-items-center">
                            <i class="fa-solid fa-phone me-3" aria-hidden="true"></i>
                            <a href="tel:+48123456789" class="footer-link gradient-animated-footer"
                                data-text="+48 123 456 789">
                                +48 123 456 789
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
                    <a href="#" class="footer-link small">© {{ date('Y') }} Kacper Jagodziński. Wszelkie prawa
                        zastrzeżone.</a>

                </div>
                <div class="col-12 col-md-6 text-center text-md-end small">
                    <a href="#" class="footer-link small me-3">Polityka prywatności</a>
                    <a href="#" class="footer-link small">Regulamin</a>
                </div>
            </div>
        </div>
    </div>
</footer>
