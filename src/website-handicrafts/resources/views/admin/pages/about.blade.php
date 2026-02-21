@extends('admin.layouts.app')

@section('title', __('admin/messages.title_meta_about'))
@section('bodyDataPage', $page ?? 'panel')


@section('content')
    <x-admin.panel-card title="{{ __('admin/messages.about_table_title') }}"
        subtitle="{{ __('admin/messages.about_table_subtitle') }}" icon="fa-solid fa-user-pen"
        additionOption="{{ __('admin/messages.table_button_add', ['item' => __('admin/messages.about_table_title')]) }}"
        additionId="add-about-button" additionUrl="{{ route('admin.about.store', ['locale' => app()->getLocale()]) }}"
        recordsCount="{{ $aboutsCount }}">
        <div class="table-responsive">
            <table id="about-datatable" class="table table-striped table-hover align-middle mb-0" data-datatable="about-data">
                <thead>
                    <tr>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.image') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.main_page') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.content') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.order') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.visible') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.locale') }}</th>
                        <th scope="col">{{ __('admin/messages.abouts_table_columns.options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abouts as $about)
                        @foreach ($about->translations as $translation)
                            <tr data-about-id="{{ $about->id }}" data-translation-id="{{ $translation->id }}">
                                <td>
                                    @php
                                        $imgPath = $about->about_author_image_url;
                                        $relPath = $about->about_author_image;
                                        $exists =
                                            $imgPath &&
                                            $relPath &&
                                            Storage::disk('public')->exists($about->about_author_image);
                                    @endphp

                                    @if ($exists)
                                        <img src="{{ asset($imgPath) }}" alt="Opinion image" class="img-thumbnail"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $translation->main_page }}</td>
                                <td>{{ $translation->content }}</td>
                                <td>{{ $translation->order }}</td>
                                <td>{{ $translation->visible }}</td>
                                <td>{{ $translation->locale }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button"
                                            class="btn btn-malinowy btn-sm mx-1 text-light add-about-translation-btn"
                                            title="{{ __('admin/messages.table_button_add', ['item' => __('admin/messages.translation')]) }}"
                                            data-store-url="{{ route('admin.about.translation.store', ['locale' => app()->getLocale(), 'about' => $about->id]) }}"
                                            data-item-name="{{ $translation->order }}"
                                            data-existing-locales='@json($about->translations->pluck('locale'))'><i
                                                class="fa-solid fa-plus"></i></button>

                                        <button type="button" class="btn btn-success btn-sm mx-1 text-light edit-about-btn"
                                            data-edit-url="{{ route('admin.about.translation.edit', ['locale' => app()->getLocale(), 'about' => $about->id, 'translation' => $translation->id]) }}"
                                            title="{{ __('admin/messages.table_button_edit') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm mx-1 text-light delete-about-btn"
                                            title="{{ __('admin/messages.table_button_delete') }}"
                                            data-delete-url="{{ route('admin.about.translation.destroy', ['locale' => app()->getLocale(), 'about' => $about->id, 'translation' => $translation->id]) }}"
                                            data-item-name="{{ e($translation->order) }}"
                                            data-delete-text="{{ __('admin/messages.opinions_delete_confirm') }}"
                                            data-after="reload">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-admin.panel-card>

    {{-- Addition Modal from a separate file --}}
    @include('admin.modals.create_about_modal')
@endsection

@push('scripts')
    <script>
        function initDataTable(tableId, dataName) {
            const table = document.querySelector(`#${tableId}[data-datatable="${dataName}"]`);
            if (!table) return;

            const appLocaleMeta = document.querySelector('meta[name="app-locale"]');
            const APP_LOCALE = appLocaleMeta ? appLocaleMeta.content : "en";
            const locale = APP_LOCALE || "en";
            const langUrl = getDataTablesLangUrl(locale);

            if (typeof DataTable === "undefined") {
                // jeśli DataTable z jakiegoś powodu nie jest załadowany — logujemy, ale nie blow up
                console.warn(
                    "DataTable is not available. Make sure admin.js imports datatables.net-bs5 before page modules.");
                return;
            }

            // Init DataTable
            new DataTable(table, {
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [3, "asc"]
                ],
                language: {
                    url: langUrl,
                },
                columnDefs: [
                    // IMAGE COLUMN (0)
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        width: "100px",
                    },

                    // VISIBLE COLUMN (1) boolean
                    {
                        targets: 1,
                        className: "text-center",
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge bg-success">✔</span>' :
                                '<span class="badge bg-secondary">✖</span>';
                        },
                    },

                    // VISIBLE COLUMN (4) boolean
                    {
                        targets: 4,
                        className: "text-center",
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge bg-success">✔</span>' :
                                '<span class="badge bg-secondary">✖</span>';
                        },
                    },

                    // OPTIONS COLUMN (6)
                    {
                        targets: 6,
                        orderable: false,
                        searchable: false,
                        className: "text-end",
                    },
                ],
            });
        }

        const getDataTablesLangUrl = (locale) => {
            switch (locale) {
                case "pl":
                    return "https://cdn.datatables.net/plug-ins/1.13.7/i18n/pl.json";
                case "en":
                    return "https://cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json";
                default:
                    return "https://cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json";
            }
        };


        document.addEventListener("DOMContentLoaded", () => {
            initDataTable("about-datatable", "about-data");
        });
    </script>
@endpush
