@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'noPadding' => false,
    'additionOption' => false,
    'additionId' => null,
    'additionUrl' => null,
    'recordsCount' => null,
])

<div class="admin-card card shadow-sm border-0 m-4">

    {{-- HEADER --}}
    @if ($title || $subtitle || $icon)
        <div class="card-header bg-white border-0 pb-0">
            <div class="d-flex align-items-center gap-2">

                @if ($icon)
                    <span class="admin-card-icon me-2">
                        <i class="{{ $icon }}"></i>
                    </span>
                @endif

                <div>
                    @if ($title)
                        <h2 class="card-title mb-1">{{ $title }}</h2>
                    @endif

                    @if ($subtitle)
                        <p class="card-subtitle text-muted">{{ $subtitle }}</p>
                    @endif
                </div>

                @if ($additionOption)
                    <button type="button" @if ($additionId) id="{{ $additionId }}" @endif
                        @if ($recordsCount !== null && $recordsCount >= 1) disabled @endif class="btn btn-secondary ms-auto text-light"
                        title="{{ $additionOption }}"
                        @if ($additionUrl) data-store-url="{{ $additionUrl }}" @endif><i
                            class="fa-solid fa-plus"></i></button>
                @endif

            </div>
        </div>

        <hr>
    @endif

    {{-- BODY --}}
    <div class="card-body {{ $noPadding ? 'p-0' : '' }}">
        {{ $slot }}
    </div>

</div>
