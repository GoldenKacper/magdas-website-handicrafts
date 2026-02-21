import "../../../sass/admin/pages/panel.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import { Modal } from "bootstrap";

import initDeleteModal from "../components/deleteModal.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    //
    // Add opinion Modal
    //
    let addOpinionModalInstance = null;

    let current = {
        url: null,
        itemName: null,
        existingLocales: [],
    };

    // Function for showing the add opinion modal
    function showAddOpinionModal(cfg = {}) {
        // cfg: { url, itemName, existingLocales }
        current = Object.assign({}, cfg); // replace previous config
        if (!current.url) {
            console.error("Empty url in config!");
            return;
        }

        const $modal = $("#addOpinionModal");

        if ($modal.length === 0) {
            console.error("Modal #addOpinionModal not found");
            return;
        }

        // Bootstrap 5 wymaga ELEMENTU DOM, nie jQuery object
        const modalEl = $modal[0];

        let titleOpinion = $modal.data("title-opinion");
        let titleTranslation = $modal.data("title-translation");
        let existingTranslations = $modal.data("existing-translations");

        // singleton (nie twórz nowej instancji za każdym razem)
        if (!addOpinionModalInstance) {
            addOpinionModalInstance = new Modal(modalEl, {
                backdrop: true,
                focus: true,
            });

            // cleanup on hide: reset form, errors and show core-row again
            $modal.on("hidden.bs.modal", function () {
                $("#add-opinion-form")[0].reset();
                $("#add-opinion-errors").addClass("d-none").empty();

                // ensure core-row is visible again for next open
                $modal.find(".core-row").removeClass("d-none");
                $modal.find(".modal-title-text").text(titleOpinion); // default title

                $modal.find(".core-row #image").attr("required", true);
                // clear file input value explicitly
                $modal.find('input[type="file"]').val("");

                $("#locale option").prop("disabled", false);
                $("#existing-translations").addClass("d-none").empty();
            });
        }

        // reset formularza przed pokazaniem
        $("#add-opinion-form")[0].reset();
        $("#add-opinion-errors").addClass("d-none").empty();
        $modal.find(".core-row").removeClass("d-none"); // show image row by default (for "new opinion")
        $modal.find(".modal-title-text").text(titleOpinion); // default title
        $modal.find(".core-row #image").attr("required", false);

        // if itemName is provided (we're adding a translation), hide core-row
        if (current.itemName) {
            $modal.find(".core-row").addClass("d-none");
            titleTranslation = titleTranslation.replace(
                ":item",
                current.itemName,
            );
            $modal.find(".modal-title-text").text(titleTranslation);
            $modal.find(".core-row #image").attr("required", true);
        }

        $modal.find("form").attr("action", current.url);

        const $localeSelect = $("#locale");
        const $existingBox = $("#existing-translations");

        // reset
        $localeSelect.find("option").prop("disabled", false);
        $existingBox.addClass("d-none").empty();

        if (current.itemName && current.existingLocales?.length) {
            // blokowanie opcji
            current.existingLocales.forEach((locale) => {
                $localeSelect
                    .find(`option[value="${locale}"]`)
                    .prop("disabled", true);
            });

            // display existing translations
            existingTranslations = existingTranslations.replace(
                ":item",
                current.itemName,
            );
            $existingBox
                .removeClass("d-none")
                .html(
                    `<strong>${existingTranslations}:</strong> ${current.existingLocales.join(", ")}`,
                );
        }

        console.log("Showing add opinion modal");
        addOpinionModalInstance.show();
    }

    //
    // Edit opinion Modal
    //
    let editModalInstance = null;

    const $loader = $("#modal-loader");

    function showLoader() {
        $loader.removeClass("d-none");
        setTimeout(() => $loader.addClass("show"), 10);
    }

    function hideLoader() {
        $loader.removeClass("show");
        setTimeout(() => $loader.addClass("d-none"), 250);
    }

    function editOpinionModal($btn, url) {
        if (!url) {
            console.error("Missing data-edit-url");
            return;
        }

        $btn.prop("disabled", true);
        showLoader();

        axios
            .get(url)
            .then((response) => {
                // wrzuć HTML modala
                $("#modal-root-edit").html(response.data);

                const modalEl = document.getElementById("editOpinionModal");

                if (!modalEl) {
                    console.error(
                        "Modal #editOpinionModal not found in response",
                    );
                    return;
                }

                if (modalEl && modalEl.parentNode !== document.body) {
                    document.body.appendChild(modalEl); // move modal under <body>
                }

                editModalInstance = new Modal(modalEl, {
                    backdrop: true,
                    focus: true,
                });

                editModalInstance.show();
            })
            .catch((error) => {
                console.error("Error loading modal:", error);
                alert("Nie udało się załadować formularza. Spróbuj ponownie.");
            })
            .finally(() => {
                hideLoader();
                $btn.prop("disabled", false);
            });
    }

    //
    // Add opinion handling
    //
    $(document).on(
        "click",
        "#add-opinion-button, .add-opinion-translation-btn",
        function (e) {
            e.preventDefault();
            const $btn = $(this);
            const url = $btn.data("store-url");
            const name = $btn.data("item-name") || null;
            const existingLocales = $btn?.data("existing-locales") || [];

            showAddOpinionModal({ url, itemName: name, existingLocales });
        },
    );

    //
    // Edit opinion handling
    //
    $(document).on("click", ".edit-opinion-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        const url = $btn.data("edit-url");

        editOpinionModal($btn, url);
    });

    //
    // Delete opinion handling
    //
    // Initialize and handle the delete opinion modal
    const deleteModal = initDeleteModal("#deleteConfirmationModal");

    $(document).on("click", ".delete-opinion-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        const url = $btn.data("delete-url");
        const name = $btn.data("item-name");
        const text = $btn.data("delete-text");
        const after = $btn.data("after") || "reload"; // or 'remove'
        const rowEl = $btn.closest("tr")[0]; // DOM element

        deleteModal.show({
            url,
            itemName: name,
            deleteText: text,
            after,
            rowEl, // required for 'remove'
        });
    });
});
