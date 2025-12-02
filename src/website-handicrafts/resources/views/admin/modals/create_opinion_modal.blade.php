<div id="modal-root">
    <x-admin.modal-frame id="addOpinionModal" data-title-opinion="{{ __('admin/messages.opinions_add_opinion') }}"
        data-title-translation="{{ __('admin/messages.opinions_add_translation') }}"
        data-existing-translations="{{ __('admin/messages.opinions_existing_translations') }}">

        {{-- action will be replaced by javascript --}}
        <form id="add-opinion-form" method="POST" action="#" enctype="multipart/form-data">

            @csrf

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-star me-1"></i>
                    <span class="modal-title-text">
                        {{ __('admin/messages.opinions_add_opinion') ?? 'Dodaj opinię' }}
                    </span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- błędy (pod axios / ajax) --}}
                <div id="add-opinion-errors" class="alert alert-danger d-none"></div>

                <div id="existing-translations" class="alert alert-info d-none"></div>

                {{-- === TRANSLATION === --}}
                <div class="row mb-3 translation-row">
                    <label for="first_name" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.first_name') ?? 'Imię' }}
                    </label>
                    <div class="col-lg-7">
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <label for="country_code" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.country_code') ?? 'Kraj' }}
                    </label>
                    <div class="col-lg-3">
                        <input type="text" id="country_code" name="country_code" class="form-control" maxlength="2"
                            placeholder="PL">
                    </div>

                    <label for="locale" class="col-lg-2 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.locale') ?? 'Język' }}
                    </label>
                    <div class="col-lg-2">
                        <select name="locale" id="locale" class="form-select">
                            <option value="pl">pl</option>
                            <option value="en">en</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <label for="content" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.content') ?? 'Treść' }}
                    </label>
                    <div class="col-lg-7">
                        <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <label for="rating" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.rating') ?? 'Ocena' }}
                    </label>
                    <div class="col-lg-3">
                        <select name="rating" id="rating" class="form-select">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <label for="order" class="col-lg-2 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.order') ?? 'Kolejność' }}
                    </label>
                    <div class="col-lg-2">
                        <input type="number" name="order" id="order" class="form-control" value="99"
                            min="1", max="99">
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <div class="col-lg-7 offset-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="visible" id="visible" value="1"
                                checked>
                            <label class="form-check-label" for="visible">
                                {{ __('admin/messages.opinions_table_columns.visible') ?? 'Widoczna' }}
                            </label>
                        </div>
                    </div>
                </div>

                {{-- META --}}
                <div class="row mb-3 translation-row">
                    <label for="image_alt" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.image_alt') ?? 'Alternatywny tekst zdjęcia' }}
                    </label>
                    <div class="col-lg-7">
                        <input type="text" name="image_alt" id="image_alt" class="form-control">
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <label for="label_meta" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.label_meta') ?? 'Etykieta meta' }}
                    </label>
                    <div class="col-lg-7">
                        <input type="text" name="label_meta" id="label_meta" class="form-control">
                    </div>
                </div>

                {{-- IMAGE --}}
                <div class="row mb-3 core-row">
                    <label for="image" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.opinions_table_columns.image') ?? 'Zdjęcie' }}
                    </label>
                    <div class="col-lg-7">
                        <input type="file" name="image" id="image" class="form-control" accept="image/*"
                            required>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('admin/messages.modal_button_cancel') ?? 'Anuluj' }}
                </button>
                <button type="submit" class="btn btn-gradient">
                    {{ __('admin/messages.modal_button_save') ?? 'Zapisz' }}
                </button>
            </div>

        </form>

    </x-admin.modal-frame>
</div>
