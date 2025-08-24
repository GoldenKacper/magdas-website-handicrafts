{{-- resources/views/layouts/partials/head.blade.php --}}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- CSRF token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Title & description (fallbacks) --}}
<title>{{ $title ?? config('app.name', 'Laravel') }}</title>
<meta name="author" content="{{ $metaAuthor ?? 'Your Name' }}">
<meta name="description" content="{{ $metaDescription ?? 'Handmade jewelry — bracelets & necklaces' }}">
<meta name="keywords" content="{{ $metaKeywords ?? 'handmade, jewelry, bracelets, necklaces' }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $title ?? config('app.name', 'Laravel') }}">
<meta property="og:description" content="{{ $metaDescription ?? 'Handmade jewelry — bracelets & necklaces' }}">
<meta property="og:image" content="{{ $metaImage ?? asset('default-image.jpg') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">
<meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">

<!-- Twitter Cards analogicznie -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@TwojaStrona">
<meta name="twitter:creator" content="@AutorTreści"> <!-- optional -->
<meta name="twitter:title" content="{{ $title ?? config('app.name', 'Laravel') }}">
<meta name="twitter:description" content="{{ $metaDescription ?? 'Handmade jewelry — bracelets & necklaces' }}">
<meta name="twitter:image" content="{{ $metaImage ?? asset('default-image.jpg') }}">
<meta name="twitter:image:alt" content="{{ $metaImageAlt ?? 'Default description for Twitter image' }}">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

{{-- Optional favicon --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

{{-- Vite-managed assets (CSS + JS entry) --}}
@vite(['resources/js/app.js'])

{{-- Place for extra head content (meta tags, additional CSS, third-party SDKs) --}}
@stack('head')
