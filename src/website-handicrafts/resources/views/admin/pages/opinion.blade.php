@extends('admin.layouts.app')

@section('title', __('admin/messages.title_meta_opinion'))
@section('bodyDataPage', $page ?? 'panel')


@section('content')
    <x-admin.panel-card title="{{ __('admin/messages.opinions_table_title') }}"
        subtitle="{{ __('admin/messages.opinions_table_subtitle') }}" icon="fa-solid fa-star"
        additionOption="{{ __('admin/messages.table_button_add', ['item' => __('admin/messages.opinions_table_title')]) }}"
        additionId="add-opinion-button" additionUrl="{{ route('admin.opinion.store', ['locale' => app()->getLocale()]) }}">
        <div class="table-responsive">
            <table id="opinion-datatable" class="table table-striped table-hover align-middle mb-0"
                data-datatable="opinion-data">
                <thead>
                    <tr>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.image') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.first_name') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.country_code') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.content') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.order') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.visible') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.locale') }}</th>
                        <th scope="col">{{ __('admin/messages.opinions_table_columns.options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opinions as $opinion)
                        @foreach ($opinion->translations as $translation)
                            <tr data-opinion-id="{{ $opinion->id }}" data-translation-id="{{ $translation->id }}">
                                <td>
                                    @php
                                        $imgPath = $opinion->image_url;
                                        $relPath = $opinion->image;
                                        $exists =
                                            $imgPath && $relPath && Storage::disk('public')->exists($opinion->image);
                                    @endphp

                                    @if ($exists)
                                        <img src="{{ asset($imgPath) }}" alt="Opinion image" class="img-thumbnail"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $translation->first_name }}</td>
                                <td>{{ $translation->country_code }}</td>
                                <td>{{ $translation->content }}</td>
                                <td>{{ $translation->order }}</td>
                                <td>{{ $translation->visible }}</td>
                                <td>{{ $translation->locale }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button"
                                            class="btn btn-malinowy btn-sm mx-1 text-light add-opinion-translation-btn"
                                            title="{{ __('admin/messages.table_button_add', ['item' => __('admin/messages.translation')]) }}"
                                            data-store-url="{{ route('admin.opinion.translation.store', ['locale' => app()->getLocale(), 'opinion' => $opinion->id]) }}"
                                            data-item-name="{{ e($translation->first_name) }}"
                                            data-existing-locales='@json($opinion->translations->pluck('locale'))'><i
                                                class="fa-solid fa-plus"></i></button>

                                        <button type="button"
                                            class="btn btn-success btn-sm mx-1 text-light edit-opinion-btn"
                                            data-edit-url="{{ route('admin.opinion.translation.edit', ['locale' => app()->getLocale(), 'opinion' => $opinion->id, 'translation' => $translation->id]) }}"
                                            title="{{ __('admin/messages.table_button_edit') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger btn-sm mx-1 text-light delete-opinion-btn"
                                            title="{{ __('admin/messages.table_button_delete') }}"
                                            data-delete-url="{{ route('admin.opinion.translation.destroy', ['locale' => app()->getLocale(), 'opinion' => $opinion->id, 'translation' => $translation->id]) }}"
                                            data-item-name="{{ e($translation->first_name) }}"
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
    @include('admin.modals.create_opinion_modal')
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
                    [4, "asc"]
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

                    // VISIBLE COLUMN (5) boolean
                    {
                        targets: 5,
                        className: "text-center",
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge bg-success">✔</span>' :
                                '<span class="badge bg-secondary">✖</span>';
                        },
                    },

                    // OPTIONS COLUMN (7)
                    {
                        targets: 7,
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
            initDataTable("opinion-datatable", "opinion-data");
        });
    </script>

    <script>
        (function() {
            // import axios from "axios";
            // window.axios = axios;

            // // Required by Laravel for AJAX CSRF protection:
            // axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
            // const token = document.querySelector('meta[name="csrf-token"]');
            // if (token) {
            //     axios.defaults.headers.common["X-CSRF-TOKEN"] =
            //         token.getAttribute("content");
            // }

            // // użyj globalnego axios jeśli istnieje, inaczej window.axios
            // const http = window.axios || axios;



            // // Obsługa submit formularza przez axios
            // document.addEventListener('submit', function(e) {
            //     const form = e.target;
            //     if (form && form.id === 'add-opinion-form') {
            //         e.preventDefault();

            //         const submitBtn = document.getElementById('add-opinion-submit');
            //         const spinner = submitBtn.querySelector('.spinner-border');

            //         // przygotowanie FormData (obsługa pliku)
            //         const formData = new FormData(form);

            //         // jeśli checkbox visible nie jest zaznaczony, Laravel nie otrzyma pola => ustaw 0 explicite
            //         if (!formData.has('visible')) {
            //             formData.append('visible', 0);
            //         }

            //         // disable UI
            //         submitBtn.disabled = true;
            //         spinner.classList.remove('d-none');

            //         // headers CSRF (jeśli nie masz globalnego axios config)
            //         const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            //         const headers = csrfTokenMeta ? {
            //             'X-CSRF-TOKEN': csrfTokenMeta.content
            //         } : {};

            //         http.post(form.action, formData, {
            //                 headers: Object.assign({
            //                     'Accept': 'application/json',
            //                     'Content-Type': undefined // multipart -> axios ustawi boundary
            //                 }, headers)
            //             })
            //             .then(function(response) {
            //                 // sukces: zamknij modal, odśwież datatable / zrób reload strony lub dopisz wiersz
            //                 const modalEl = document.getElementById('addOpinionModal');
            //                 const modalInstance = bootstrap.Modal.getInstance(modalEl);
            //                 if (modalInstance) modalInstance.hide();

            //                 // tu możesz odświeżyć tabelę — jeśli korzystasz z DataTables:
            //                 try {
            //                     // jeżeli masz instancję DataTable globalnie dostępną -> reload
            //                     if (window.opinionDataTable) {
            //                         window.opinionDataTable.ajax.reload();
            //                     } else {
            //                         // fallback: proste przeładowanie strony
            //                         window.location.reload();
            //                     }
            //                 } catch (err) {
            //                     window.location.reload();
            //                 }
            //             })
            //             .catch(function(error) {
            //                 // obsługa walidacji 422
            //                 const errorsBox = document.getElementById('add-opinion-errors');
            //                 errorsBox.classList.remove('d-none');
            //                 errorsBox.innerHTML = '';

            //                 if (error.response && error.response.status === 422 && error.response.data
            //                     .errors) {
            //                     const errs = error.response.data.errors;
            //                     const ul = document.createElement('ul');
            //                     Object.keys(errs).forEach(key => {
            //                         errs[key].forEach(msg => {
            //                             const li = document.createElement('li');
            //                             li.textContent = msg;
            //                             ul.appendChild(li);
            //                         });
            //                     });
            //                     errorsBox.appendChild(ul);
            //                 } else {
            //                     // ogólny komunikat
            //                     errorsBox.textContent = 'Wystąpił błąd podczas zapisu. Spróbuj ponownie.';
            //                 }
            //             })
            //             .finally(function() {
            //                 submitBtn.disabled = false;
            //                 spinner.classList.add('d-none');
            //             });
            //     }
            // });
        })();
    </script>
@endpush
