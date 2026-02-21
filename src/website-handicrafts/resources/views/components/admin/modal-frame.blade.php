@props([
    'id' => 'modalId',
])

<div
    {{ $attributes->merge([
        'class' => 'modal fade',
        'id' => $id,
        'tabindex' => '-1',
        'aria-hidden' => 'true',
    ]) }}>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content py-2">
            <div class="overflow-auto">

                {{ $slot }}

            </div>
        </div>
    </div>
</div>
