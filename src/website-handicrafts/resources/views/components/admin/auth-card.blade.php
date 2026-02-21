@if ($show)
    <div class="card {{ $class }}">
        @if ($title)
            <div class="card-header">
                {{ $title }}
            </div>
        @endif

        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
@endif
