import "../../../sass/admin/pages/panel.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import { Modal } from "bootstrap";

import initDeleteModal from "../components/deleteModal.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    //
    // Add about Modal
    //
    let addAboutModalInstance = null;

    let current = {
        url: null,
        itemName: null,
    };

    // Function for showing the add about modal
    function showAddAboutModal(cfg = {}) {
        // cfg: { url, itemName }
        current = Object.assign({}, cfg); // replace previous config
        if (!current.url) {
            console.error("Empty url in config!");
            return;
        }

        const $modal = $("#addAboutModal");

        if ($modal.length === 0) {
            console.error("Modal #addAboutModal not found");
            return;
        }

        // Bootstrap 5 wymaga ELEMENTU DOM, nie jQuery object
        const modalEl = $modal[0];

        let titleAbout = $modal.data("title-about");
        let titleTranslation = $modal.data("title-translation");

        // singleton (nie twórz nowej instancji za każdym razem)
        if (!addAboutModalInstance) {
            addAboutModalInstance = new Modal(modalEl, {
                backdrop: true,
                focus: true,
            });

            // cleanup on hide: reset form, errors and show core-row again
            $modal.on("hidden.bs.modal", function () {
                $("#add-about-form")[0].reset();
                $("#about-errors").addClass("d-none").empty();

                // ensure core-row is visible again for next open
                $modal.find(".core-row").removeClass("d-none");
                $modal.find(".modal-title-text").text(titleAbout); // default title

                $modal.find(".core-row #image").attr("required", true);

                // clear file input value explicitly
                $modal.find('input[type="file"]').val("");
            });
        }

        // reset formularza przed pokazaniem
        $("#add-about-form")[0].reset();
        $("#about-errors").addClass("d-none").empty();
        $modal.find(".core-row").removeClass("d-none"); // show image row by default (for "new about")
        $modal.find(".modal-title-text").text(titleAbout); // default title
        $modal.find(".core-row #image").attr("required", true);

        // if itemName is provided (we're adding a translation), hide core-row
        if (current.itemName) {
            $modal.find(".core-row").addClass("d-none");
            titleTranslation = titleTranslation.replace(
                ":item",
                current.itemName,
            );
            $modal.find(".modal-title-text").text(titleTranslation);
            $modal.find(".core-row #image").attr("required", false);
        }

        $modal.find("form").attr("action", current.url);

        // reset
        console.log("Showing add about modal");
        addAboutModalInstance.show();
    }

    //
    // Edit about Modal
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

    function editAboutModal($btn, url) {
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

                const modalEl = document.getElementById("editAboutModal");

                if (!modalEl) {
                    console.error(
                        "Modal #editAboutModal not found in response",
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
    // Add about handling
    //
    $(document).on(
        "click",
        "#add-about-button, .add-about-translation-btn",
        function (e) {
            e.preventDefault();
            const $btn = $(this);
            const url = $btn.data("store-url");
            const name = $btn.data("item-name") || null;

            showAddAboutModal({ url, itemName: name });
        },
    );

    //
    // Edit about handling
    //
    $(document).on("click", ".edit-about-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        const url = $btn.data("edit-url");

        editAboutModal($btn, url);
    });

    //
    // Delete about handling
    //
    // Initialize and handle the delete about modal
    const deleteModal = initDeleteModal("#deleteConfirmationModal");

    $(document).on("click", ".delete-about-btn", function (e) {
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
