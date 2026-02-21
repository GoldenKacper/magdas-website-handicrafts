<div id="modal-root">
    <x-admin.modal-frame id="addAboutModal" data-title-about="{{ __('admin/messages.about_add_opinion') }}"
        data-title-translation="{{ __('admin/messages.about_add_translation') }}"
        data-existing-translations="{{ __('admin/messages.about_existing_translations') }}">

        {{-- action will be replaced by javascript --}}
        <form id="add-about-form" method="POST" action="#" enctype="multipart/form-data">

            @csrf

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user-pen me-1"></i>
                    <span class="modal-title-text">
                        {{ __('admin/messages.about_add_opinion') ?? 'Dodaj wpis do sekcji o mnie' }}
                    </span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- błędy (pod axios / ajax) --}}
                <div id="about-errors" class="alert alert-danger d-none"></div>

                {{-- === TRANSLATION === --}}
                <div class="row mb-3 translation-row">
                    <label for="order" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.abouts_table_columns.order') ?? 'Kolejność' }}
                    </label>
                    <div class="col-lg-2">
                        <input type="number" name="order" id="order" class="form-control" value="99"
                            min="1", max="99">
                    </div>

                    <label for="locale" class="col-lg-2 col-form-label text-end">
                        {{ __('admin/messages.abouts_table_columns.locale') ?? 'Język' }}
                    </label>
                    <div class="col-lg-3">
                        <select name="locale" id="locale" class="form-select">
                            <option value="pl">pl</option>
                            <option value="en">en</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <label for="content" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.abouts_table_columns.content') ?? 'Treść' }}
                    </label>
                    <div class="col-lg-7">
                        <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="row mb-3 translation-row">
                    <div class="col-lg-4 offset-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="main_page" id="main_page"
                                value="1" checked>
                            <label class="form-check-label" for="main_page">
                                {{ __('admin/messages.abouts_table_columns.main_page') ?? 'Strona główna' }}
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="visible" id="visible" value="1"
                                checked>
                            <label class="form-check-label" for="visible">
                                {{ __('admin/messages.abouts_table_columns.visible') ?? 'Widoczna' }}
                            </label>
                        </div>
                    </div>
                </div>

                {{-- META --}}
                <div class="row mb-3 translation-row">
                    <label for="image_alt" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.abouts_table_columns.image_alt') ?? 'Alternatywny tekst zdjęcia' }}
                    </label>
                    <div class="col-lg-7">
                        <input type="text" name="image_alt" id="image_alt" class="form-control">
                    </div>
                </div>

                {{-- IMAGE --}}
                <div class="row mb-3 core-row">
                    <label for="image" class="col-lg-3 col-form-label text-end">
                        {{ __('admin/messages.abouts_table_columns.image') ?? 'Zdjęcie' }}
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
