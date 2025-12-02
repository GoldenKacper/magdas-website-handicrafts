<nav class="navbar navbar-expand-lg navbar-light bg-pale sticky-top justify-content-center">
    <div class="container-fluid mx-4">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center me-4 py-0 logo"
            href="{{ route('home', ['locale' => session('locale', app()->getLocale())]) }}"
            aria-label="{{ __('messages.logo_img_alt') }}">
            <span class="logo__wrap">
                {{-- Malin --}}
                <img class="logo__wordmark"
                    src="{{ Vite::asset('resources/images/magdas_website_logo_25_09_2025_part_1.webp') }}"
                    alt="{{ __('messages.logo_img_alt') }}" />

                {{-- Raspberry --}}
                <img class="logo__berry"
                    src="{{ Vite::asset('resources/images/magdas_website_logo_25_09_2025_part_2.webp') }}"
                    alt="{{ __('messages.logo_img_alt') }}" />

                {{-- tagline --}}
                <img class="logo__tagline"
                    src="{{ Vite::asset('resources/images/magdas_website_logo_25_09_2025_part_3.webp') }}"
                    alt="{{ __('messages.logo_img_alt') }}" />
            </span>
        </a>

        {{-- Toggle for mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('messages.toggle_navigation') }}">
            <span class="hamburger" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>


        {{-- Links --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav custom-nav pt-3 pt-lg-0">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('login') ? 'active-pill' : '' }}"
                                href="{{ route('login', ['locale' => session('locale', app()->getLocale())]) }}"
                                data-text="{{ __('admin/messages.login') }}">{{ __('admin/messages.login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('register') ? 'active-pill' : '' }}"
                                href="{{ route('register', ['locale' => session('locale', app()->getLocale())]) }}"
                                data-text="{{ __('admin/messages.register') }}">{{ __('admin/messages.register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('admin.home') ? 'active-pill' : '' }}"
                            href="{{ route('admin.home', ['locale' => session('locale', app()->getLocale())]) }}"
                            data-text="{{ __('admin/messages.home') }}">{{ __('admin/messages.home') }}</a>
                    </li>
                    <li class="nav-item dropdown text-center">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-center py-0" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-pale" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                                href="{{ route('logout', ['locale' => session('locale', app()->getLocale())]) }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('admin/messages.logout') }}
                            </a>

                            <form id="logout-form"
                                action="{{ route('logout', ['locale' => session('locale', app()->getLocale())]) }}"
                                method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            <ul class="navbar-nav ms-lg-4">
                {{-- Change language dropdown --}}
                <li class="nav-item dropdown text-center">
                    <a id="languageDropdown" class="nav-link dropdown-toggle text-center py-0" href="#"
                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-pale" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="{{ route('admin.lang.switch', 'pl') }}">
                            🇵🇱 <span title="Polski">Polski</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.lang.switch', 'en') }}">
                            🇬🇧 <span title="English">English</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
