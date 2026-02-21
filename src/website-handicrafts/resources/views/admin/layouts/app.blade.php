<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.layouts.partials.head')
</head>

<body data-page="@yield('bodyDataPage')">
    <div id="app" class="d-flex">
        {{-- @include('admin.layouts.partials.navbar') --}}
        @include('admin.layouts.partials.sidebar')

        {{-- Main content container --}}
        <main class="flex-grow-1">
            <div class="container-fluid ultra-wide px-0">
                @include('admin.layouts.partials.delete_modal')

                {{-- Placeholder for modal --}}
                <div id="modal-root-edit"></div>

                <div id="modal-loader" class="modal-loader d-none">
                    <div class="spinner-border" role="status"></div>
                </div>

                {{-- flash messages --}}
                <div class="flash-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
                    @if (session('success'))
                        <div class="alert alert-success flash-message" role="alert">
                            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger flash-message" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info flash-message" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ session('info') }}
                        </div>
                    @endif
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    @include('admin.layouts.partials.scripts')
</body>

</html>
