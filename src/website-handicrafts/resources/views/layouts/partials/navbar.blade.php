<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
    <div class="container-fluid mx-4">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center me-4"
            href="{{ route('home', ['locale' => session('locale', app()->getLocale())]) }}">
            <img src="{{ Vite::asset('resources/images/magdas_website_logo_25_08_2025_demo_v2.png') }}"
                alt="{{ __('messages.logo_img_alt') }}" class="img-fluid-logo">
        </a>

        {{-- Toggle for mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('messages.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Links --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav custom-nav">
                <li class="nav-item">
                    <a class="nav-link text-center"
                        href="{{ route('home', ['locale' => session('locale', app()->getLocale())]) }}">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center" href="#about">{{ __('messages.about') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center" href="#gallery">{{ __('messages.gallery') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center" href="#contact">{{ __('messages.contact') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-social ms-4">
                <li class="nav-item"><a class="nav-link text-center" href="#"><i
                            class="fa-brands fa-facebook"></i></a></li>
                <li class="nav-item"><a class="nav-link text-center" href="#"><i
                            class="fa-brands fa-instagram"></i></a></li>
                <li class="nav-item"><a class="nav-link text-center" href="#"><i
                            class="fa-brands fa-twitter"></i></a></li>
                <li class="nav-item"><a class="nav-link text-center" href="#"><i
                            class="fa-brands fa-pinterest"></i></a></li>
            </ul>
            <ul class="navbar-nav ms-4">
                {{-- Change language dropdown --}}
                <li class="nav-item dropdown">
                    <a id="languageDropdown" class="nav-link dropdown-toggle text-center" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="{{ route('lang.switch', 'pl') }}">
                            🇵🇱 <span title="Polski">Polski</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                            🇬🇧 <span title="English">English</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
