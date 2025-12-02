@php
    $locale = session('locale', app()->getLocale());
@endphp

<!-- Desktop sidebar (visible >= lg) -->
<aside id="sidebar-desktop" class="admin-sidebar d-none d-lg-flex flex-column">
    <div class="sidebar-top px-3 py-1">
        <a class="navbar-brand d-flex align-items-center py-0 logo"
            href="{{ route('admin.home', ['locale' => $locale]) }}" aria-label="{{ __('messages.logo_img_alt') }}">
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
    </div>

    <hr>

    <nav class="sidebar-middle flex-grow-1 px-2 py-1">
        <ul class="nav nav-pills flex-column mb-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('login') ? 'active-pill' : '' }}"
                        href="{{ route('login', ['locale' => $locale]) }}"
                        data-text="{{ __('admin/messages.login') }}">{{ __('admin/messages.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('register') ? 'active-pill' : '' }}"
                        href="{{ route('register', ['locale' => $locale]) }}"
                        data-text="{{ __('admin/messages.register') }}">{{ __('admin/messages.register') }}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('admin.home') ? 'active-pill' : '' }}"
                        href="{{ route('admin.home', ['locale' => $locale]) }}"
                        data-text="{{ __('admin/messages.home') }}"><i class="fa-solid fa-ranking-star me-2"></i>
                        {{ __('admin/messages.home') }}</a>
                </li>

                <hr>
                {{-- sample group / divider --}}
                <li class="nav-item">
                    <div class="sidebar-section-title text-uppercase text-muted small px-3 mb-2">
                        {{ __('admin/messages.management_content') }}
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav" href="#"
                        data-text="{{ __('admin/messages.products') }}"><i class="fa-solid fa-box-open me-2"></i>
                        {{ __('admin/messages.products') }}</a>
                    {{-- <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active-pill' : '' }}"
                        href="{{ route('admin.products.index', ['locale' => $locale]) }}">
                        {{ __('admin/messages.products') }}
                    </a> --}}
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav  {{ request()->routeIs('admin.opinion.index') ? 'active-pill' : '' }}"
                        href="{{ route('admin.opinion.index', ['locale' => $locale]) }}"
                        data-text="{{ __('admin/messages.opinions') }}"><i class="fa-solid fa-star me-2"></i>
                        {{ __('admin/messages.opinions') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav" href="#"
                        data-text="{{ __('admin/messages.faqs') }}"><i class="fa-solid fa-circle-question me-2"></i>
                        {{ __('admin/messages.faqs') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav {{ request()->routeIs('admin.about.index') ? 'active-pill' : '' }}"
                        href="{{ route('admin.about.index', ['locale' => $locale]) }}"
                        data-text="{{ __('admin/messages.about_me') }}"><i class="fa-solid fa-user-pen me-2"></i>
                        {{ __('admin/messages.about_me') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center gradient-animated-nav" href="#"
                        data-text="{{ __('admin/messages.translations') }}"><i class="fa-solid fa-flag me-2"></i>
                        {{ __('admin/messages.translations') }}</a>
                </li>

                {{-- Another element can be pushed here --}}
                @stack('sidebar-items')
            @endguest
        </ul>
    </nav>

    <div class="sidebar-bottom px-3 py-3">
        @auth
            <div class="dropdown user-dropdown w-100">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="sidebarUserDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="http://picsum.photos/seed/{{ rand(0, 1000000) }}/40" alt="placeholder" width="40"
                        height="40" class="rounded-circle me-2" />
                    <div class="d-flex flex-column text-start">
                        <strong class="username">{{ Auth::user()->name }}</strong>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end w-100 mt-2 shadow bg-pale" aria-labelledby="sidebarUserDesktop">
                    <li class="text-center">
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout', ['locale' => $locale]) }}"
                            onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();">
                            {{ __('admin/messages.logout') }}
                        </a>
                        <form id="logout-sidebar-form" action="{{ route('logout', ['locale' => $locale]) }}" method="POST"
                            class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>

            {{-- language dropdown (small icons + text) --}}
            <div class="mt-3">
                <div class="dropdown">
                    <a class="btn btn-sm w-100 dropdown-toggle bg-transparent text-start" href="#"
                        id="sidebarLangDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-globe me-2"></i> <span
                            class="d-none d-md-inline">{{ strtoupper($locale) }}</span>
                    </a>
                    <ul class="dropdown-menu w-100 bg-pale" aria-labelledby="sidebarLangDesktop">
                        <li><a class="dropdown-item" href="{{ route('admin.lang.switch', 'pl') }}">🇵🇱 Polski</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.lang.switch', 'en') }}">🇬🇧 English</a></li>
                    </ul>
                </div>
            </div>
        @endauth
    </div>
</aside>

<!-- Mobile: use bootstrap offcanvas -->
<nav class="d-lg-none px-2 py-2 border-bottom bg-pale">
    <div class="d-flex align-items-center justify-content-between">
        <a class="navbar-brand logo" href="{{ route('admin.home', ['locale' => $locale]) }}"
            aria-label="{{ __('messages.logo_img_alt') }}">
            <span class="logo__wrap">
                <img class="logo__wordmark img-fluid-logo"
                    src="{{ Vite::asset('resources/images/magdas_website_logo_25_09_2025_part_1.webp') }}"
                    alt="{{ __('messages.logo_img_alt') }}" />
            </span>
        </a>

        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas"
            aria-label="{{ __('messages.open_sidebar') }}">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">{{ config('app.name') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
            aria-label="{{ __('messages.close') }}"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        {{-- reuse main sidebar markup inside offcanvas for consistency --}}
        <div class="p-3">
            <a class="d-flex align-items-center py-0 logo" href="{{ route('admin.home', ['locale' => $locale]) }}"
                aria-label="{{ __('messages.logo_img_alt') }}">
                <span class="logo__wrap">
                    <img class="logo__wordmark img-fluid-logo"
                        src="{{ Vite::asset('resources/images/magdas_website_logo_25_09_2025_part_1.webp') }}"
                        alt="{{ __('messages.logo_img_alt') }}" />
                </span>
            </a>
        </div>

        <nav class="flex-grow-1 px-2">
            <ul class="nav nav-pills flex-column mb-0">
                @guest
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active-pill' : '' }}"
                            href="{{ route('login', ['locale' => $locale]) }}">{{ __('admin/messages.login') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('register') ? 'active-pill' : '' }}"
                            href="{{ route('register', ['locale' => $locale]) }}">{{ __('admin/messages.register') }}</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.home') ? 'active-pill' : '' }}"
                            href="{{ route('admin.home', ['locale' => $locale]) }}">{{ __('admin/messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Produkty</a>
                        {{-- <a class="nav-link"
                            href="{{ route('admin.products.index', ['locale' => $locale]) }}">{{ __('admin/messages.products') }}</a> --}}
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Zamówienia</a>
                        {{-- <a class="nav-link"
                            href="{{ route('admin.orders.index', ['locale' => $locale]) }}">{{ __('admin/messages.orders') }}</a> --}}
                    </li>
                    @stack('sidebar-items')
                @endguest
            </ul>
        </nav>

        <div class="p-3 border-top">
            @auth
                <div class="d-flex align-items-center mb-2">
                    <img src="http://picsum.photos/seed/{{ rand(0, 1000000) }}/40" alt="placeholder" width="40"
                        height="40" class="rounded-circle me-1" />
                    <div>
                        <strong>{{ Auth::user()->name }}</strong><br />
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                    <a class="btn btn-danger" href="{{ route('logout', ['locale' => $locale]) }}"
                        onclick="event.preventDefault(); document.getElementById('logout-offcanvas-form').submit();">{{ __('admin/messages.logout') }}</a>
                    <form id="logout-offcanvas-form" action="{{ route('logout', ['locale' => $locale]) }}"
                        method="POST" class="d-none">@csrf</form>

                    <div class="dropdown mt-2">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="offcanvasLang"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-globe"></i> {{ strtoupper($locale) }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="offcanvasLang">
                            <li><a class="dropdown-item" href="{{ route('admin.lang.switch', 'pl') }}">🇵🇱 Polski</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.lang.switch', 'en') }}">🇬🇧 English</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>

@push('scripts')
    <!-- Close offcanvas when any internal anchor clicked (UX) -->
    <script>
        document.addEventListener('click', function(e) {
            const offcanvas = document.getElementById('sidebarOffcanvas');
            if (!offcanvas) return;

            // if bootstrap is not available globally – do nothing
            if (!window.bootstrap || !window.bootstrap.Offcanvas) return;

            const bsOff = window.bootstrap.Offcanvas.getInstance(offcanvas);
            // if clicked a nav link inside offcanvas -> close
            if (e.target.closest('.offcanvas-body a.nav-link')) {
                if (bsOff) {
                    bsOff.hide();
                }
            }
        });
    </script>
@endpush
