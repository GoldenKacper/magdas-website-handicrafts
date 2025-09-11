<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-locale="{{ app()->getLocale() }}">

<head>
    @include('layouts.partials.preloader-assets')
    @include('layouts.partials.head')
</head>

<body data-page="@yield('bodyDataPage')">
    <div id="app">
        @include('layouts.partials.preloader')
        @include('layouts.partials.navbar')

        {{-- Main content container --}}
        <main>
            <div class="container-fluid ultra-wide px-0">
                {{-- Placeholder for modal --}}
                <div id="modal-root"></div>

                {{-- flash messages --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info" role="alert">
                        {{ session('info') }}
                    </div>
                @endif

                @yield('content')

                @include('layouts.partials.footer')
            </div>
        </main>
    </div>

    @include('layouts.partials.scripts')
</body>

</html>
