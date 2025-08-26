<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- CSRF token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Title & description (fallbacks) --}}
<title>@yield('title', config('app.name', 'Laravel'))</title>
<meta name="author" content="@yield('metaAuthor', config('app.author', 'Unknown'))">
<meta name="description" content="@yield('metaDescription', 'Handmade jewelry — bracelets & necklaces')">
<meta name="keywords" content="@yield('metaKeywords', 'handmade, jewelry, bracelets, necklaces')">
<meta name="robots" content="@yield('metaRobots', 'index, follow')">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph -->
<meta property="og:title" content="@yield('ogTitle', View::yieldContent('title', config('app.name', 'Laravel')))">
<meta property="og:description" content="@yield('ogDescription', View::yieldContent('metaDescription', 'Handmade jewelry — bracelets & necklaces'))">
<meta property="og:image" content="@yield('ogImage', asset('default-image.jpg'))">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="@yield('ogType', 'article')">
<meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">

<!-- Twitter Cards -->
<meta name="twitter:card" content="@yield('twitterCard', 'summary_large_image')">
<meta name="twitter:site" content="@yield('twitterSite', '@TwojaStrona')">
<meta name="twitter:creator" content="@yield('twitterCreator', '@AutorTreści')">
<meta name="twitter:title" content="@yield('twitterTitle', View::yieldContent('title', config('app.name', 'Laravel')))">
<meta name="twitter:description" content="@yield('twitterDescription', View::yieldContent('metaDescription', 'Handmade jewelry — bracelets & necklaces'))">
<meta name="twitter:image" content="@yield('twitterImage', asset('default-image.jpg'))">
<meta name="twitter:image:alt" content="@yield('twitterImageAlt', 'Default description for Twitter image')">


<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

{{-- Optional favicon --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

{{-- Vite-managed assets (CSS + JS entry) --}}
@vite(['resources/js/app.js'])

{{-- Place for extra head content (meta tags, additional CSS, third-party SDKs) --}}
@stack('head')
