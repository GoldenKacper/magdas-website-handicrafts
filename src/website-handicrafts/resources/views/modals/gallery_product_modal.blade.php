<div class="modal fade" id="galleryProductModal" tabindex="-1" aria-labelledby="galleryProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="galleryProductModalLabel">{{ $product['name'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('messages.gallery_modal_close') }}"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4 align-items-start">
                    {{-- Left side - Product's images --}}
                    <div class="col-12 col-lg-7">
                        <div class="pg" data-pg>
                            <div class="pg-viewport ratio ratio-1x1 rounded overflow-hidden" tabindex="0"
                                aria-roledescription="carousel" aria-live="polite">

                                <ul class="pg-track list-unstyled m-0 p-0">
                                    @foreach ($product['images'] as $src)
                                        <li class="pg-item">
                                            <img src="{{ $src }}" alt="{{ $product['name'] }}" loading="lazy"
                                                draggable="false">
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Arrows --}}
                                <button class="pg-arrow pg-prev" type="button"
                                    aria-label="{{ __('messages.gallery_title_previous') }}"
                                    title="{{ __('messages.gallery_title_previous') }}">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <button class="pg-arrow pg-next" type="button"
                                    aria-label="{{ __('messages.gallery_title_next') }}"
                                    title="{{ __('messages.gallery_title_next') }}">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>

                                {{-- Thumbnails --}}
                                <div class="pg-thumbs on-image"
                                    aria-label="{{ __('messages.gallery_modal_miniatures') }}">
                                    @foreach ($product['images'] as $src)
                                        <button class="pg-thumb @if ($loop->first) active @endif"
                                            type="button" data-idx="{{ $loop->index }}"
                                            aria-label="{{ __('messages.gallery_modal_miniatures_button', ['idx' => $loop->iteration]) }}">
                                            <img src="{{ $src }}"
                                                alt="{{ __('messages.gallery_modal_miniatures_button', ['idx' => $loop->iteration]) }}"
                                                loading="lazy" draggable="false">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right side - Product's details --}}
                    <div class="col-12 col-lg-5">
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <div class="small text-uppercase text-muted mb-1">
                                    {{ __('messages.gallery_modal_category') }}</div>
                                <div class="fw-semibold">{{ $product['category'] }}</div>
                            </div>
                            <div>
                                <div class="small text-uppercase text-muted mb-1">
                                    {{ __('messages.gallery_modal_description') }}</div>
                                <p class="mb-0">{{ $product['description'] }}</p>
                            </div>
                            <div>
                                <div class="small text-uppercase text-muted mb-1">
                                    {{ __('messages.gallery_modal_stock') }}</div>
                                <p class="mb-0">{{ $product['stock'] }}</p>
                            </div>
                            <div>
                                <div class="small text-uppercase text-muted mb-1">
                                    {{ __('messages.gallery_modal_price') }}</div>
                                <div class="display-6 fw-bold text-primary">{{ $product['price'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-gradient"
                    data-bs-dismiss="modal">{{ __('messages.gallery_modal_close') }}</button>
            </div>

        </div>
    </div>
</div>
