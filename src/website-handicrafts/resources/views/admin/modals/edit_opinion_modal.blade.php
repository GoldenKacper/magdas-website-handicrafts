<x-admin.modal-frame id="editOpinionModal">
    {{-- action will be replaced by javascript --}}
    <form id="add-opinion-form" method="POST"
        action="{{ route('admin.opinion.translation.update', ['locale' => app()->getLocale(), 'opinion' => $opinion->id, 'translation' => $opinion->translation->id]) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PATCH')

        <div class="modal-header">
            <h5 class="modal-title">
                <i class="fa-solid fa-star me-1"></i>
                <span class="modal-title-text">
                    {{ __('admin/messages.opinions_edit_translation', ['item' => $opinion->translation->first_name]) ?? 'Edytuj tłumaczenie opinii' }}
                </span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            {{-- error (for axios) --}}
            <div id="add-opinion-errors" class="alert alert-danger d-none"></div>

            {{-- Added later by js --}}
            <div id="existing-translations" class="alert alert-info">
                <strong>{{ __('admin/messages.opinions_existing_translations', ['item' => $opinion->translation->first_name]) ?? 'Istniejące tłumaczenia' }}</strong>:
                @foreach ($existingTranslations as $locale)
                    <span class="badge bg-secondary">{{ $locale }}</span>
                @endforeach
            </div>

            {{-- === TRANSLATION === --}}
            <div class="row mb-3 translation-row">
                <label for="first_name" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.first_name') ?? 'Imię' }}
                </label>
                <div class="col-lg-7">
                    <input type="text" id="first_name" name="first_name" class="form-control"
                        value="{{ $opinion->translation->first_name }}" required>
                </div>
            </div>

            <div class="row mb-3 translation-row">
                <label for="country_code" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.country_code') ?? 'Kraj' }}
                </label>
                <div class="col-lg-3">
                    <input type="text" id="country_code" name="country_code" class="form-control" maxlength="2"
                        placeholder="PL" value="{{ $opinion->translation->country_code }}">
                </div>

                <label for="locale" class="col-lg-2 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.locale') ?? 'Język' }}
                </label>
                <div class="col-lg-2">
                    <select name="locale" id="locale" class="form-select">
                        <option value="pl" @if ($opinion->translation->locale === 'pl') selected @endif disabled>pl
                        </option>
                        <option value="en" @if ($opinion->translation->locale === 'en') selected @endif disabled>en
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 translation-row">
                <label for="content" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.content') ?? 'Treść' }}
                </label>
                <div class="col-lg-7">
                    <textarea id="content" name="content" rows="4" class="form-control" required>{{ $opinion->translation->content }}</textarea>
                </div>
            </div>

            <div class="row mb-3 translation-row">
                <label for="rating" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.rating') ?? 'Ocena' }}
                </label>
                <div class="col-lg-3">
                    <select name="rating" id="rating" class="form-select">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @if ($opinion->translation->rating === $i) selected @endif>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <label for="order" class="col-lg-2 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.order') ?? 'Kolejność' }}
                </label>
                <div class="col-lg-2">
                    <input type="number" name="order" id="order" class="form-control"
                        value="{{ $opinion->translation->order }}" min="1" max="99">
                </div>
            </div>

            <div class="row mb-3 translation-row">
                <div class="col-lg-7 offset-lg-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="visible" id="visible" value="1"
                            @if ($opinion->translation->visible) checked @endif>
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
                    <input type="text" name="image_alt" id="image_alt" class="form-control"
                        value="{{ $opinion->translation->image_alt }}">
                </div>
            </div>

            <div class="row mb-3 translation-row">
                <label for="label_meta" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.label_meta') ?? 'Etykieta meta' }}
                </label>
                <div class="col-lg-7">
                    <input type="text" name="label_meta" id="label_meta" class="form-control"
                        value="{{ $opinion->translation->label_meta }}">
                </div>
            </div>

            {{-- IMAGE --}}
            <div class="row mb-3 core-row">
                <label for="image" class="col-lg-3 col-form-label text-end">
                    {{ __('admin/messages.opinions_table_columns.image') ?? 'Zdjęcie' }}
                </label>
                <div class="col-lg-7">
                    @if (!empty($opinion?->image_url))
                        <div class="d-flex align-items-center mb-2 panel-thumb-row">
                            <img src="{{ $opinion->image_url }}" alt="preview" class="panel-thumb me-3">
                            <span class="panel-thumb-text">
                                {{ __('admin/messages.opinions_edit_image_info') ?? 'Zmiana zdjęcia wpłynie na wszystkie tłumaczenia.' }}
                            </span>
                        </div>
                    @endif

                    <input type="file" name="image" id="image" class="form-control mt-1" accept="image/*">
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
