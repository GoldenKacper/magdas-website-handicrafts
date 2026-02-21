// resources/js/admin/deleteModal.js
import $ from "jquery";
import { Modal } from "bootstrap";

export default function initDeleteModal(
    modalSelector = "#deleteConfirmationModal",
) {
    const modalEl = document.querySelector(modalSelector);
    if (!modalEl) return { show: () => {} };

    const $modal = $(modalEl);
    const bsModal = new Modal(modalEl, { backdrop: true, focus: true });

    // templates from data-* (rendered by Blade)
    const templates = {
        bodyDefault: modalEl.dataset.bodyDefault || "Are you sure?",
        errBadUrl: modalEl.dataset.errorBadUrl || "Bad URL",
        deletingText: modalEl.dataset.deletingText || "Deleting...",
        deleteText: modalEl.dataset.deleteText || "Delete",
        failedText: modalEl.dataset.failedText || "Delete failed",
    };

    let current = {
        url: null,
        itemName: null,
        deleteText: null,
        after: "reload",
        rowEl: null,
        onSuccess: null,
    };

    // set body text helper
    function setBodyText(itemName) {
        const text = itemName
            ? current.deleteText.replace(":item", itemName)
            : templates.bodyDefault;
        modalEl.querySelector("#delete-body-text").textContent = text;
    }

    function show(cfg = {}) {
        // cfg: { url, itemName, deleteText, after: 'reload'|'remove'|'callback', rowEl: DOM/jQuery, onSuccess: fn }
        current = Object.assign(current, cfg);
        if (!current.url) {
            modalEl.querySelector("#delete-error").classList.remove("d-none");
            modalEl.querySelector("#delete-error").textContent =
                templates.errBadUrl;
            return;
        }

        setBodyText(current.itemName);
        modalEl.querySelector("#delete-error").classList.add("d-none");
        modalEl.querySelector("#delete-error").textContent = "";

        // reset button text
        const confirmBtn = modalEl.querySelector("#delete-confirm");
        confirmBtn.textContent = templates.deleteText;
        confirmBtn.disabled = false;

        bsModal.show();
    }

    // confirm handler
    $modal.on("click", "#delete-confirm", function () {
        const btn = this;
        if (!current.url) {
            modalEl.querySelector("#delete-error").classList.remove("d-none");
            modalEl.querySelector("#delete-error").textContent =
                templates.errBadUrl;
            return;
        }

        const originalText = btn.textContent;
        btn.textContent = templates.deletingText;
        btn.disabled = true;

        axios
            .delete(current.url)
            .then((res) => {
                const data = res.data || {};
                if (data.success) {
                    // prefer server-set session flash + reload
                    if (current.after === "reload" || !current.after) {
                        bsModal.hide();
                        // small delay so modal hides before reload
                        setTimeout(() => location.reload(), 150);
                        return;
                    }

                    if (current.after === "remove" && current.rowEl) {
                        // If DataTable is present, use its API; otherwise remove row DOM
                        try {
                            // DataTable API: DataTable(selector) returns instance in your setup
                            const dt =
                                DataTable &&
                                DataTable(
                                    `#${current.rowEl.closest("table").id}`,
                                );
                            if (dt) {
                                dt.row(current.rowEl).remove().draw(false);
                            } else {
                                $(current.rowEl).remove();
                            }
                        } catch (e) {
                            $(current.rowEl).remove();
                        }
                        bsModal.hide();
                        if (typeof current.onSuccess === "function")
                            current.onSuccess(data);
                        return;
                    }

                    if (
                        current.after === "callback" &&
                        typeof current.onSuccess === "function"
                    ) {
                        bsModal.hide();
                        current.onSuccess(data);
                        return;
                    }

                    bsModal.hide();
                    if (typeof current.onSuccess === "function")
                        current.onSuccess(data);
                } else {
                    modalEl
                        .querySelector("#delete-error")
                        .classList.remove("d-none");
                    modalEl.querySelector("#delete-error").textContent =
                        data.message || templates.failedText;
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            })
            .catch((err) => {
                let message = templates.failedText;
                if (
                    err.response &&
                    err.response.data &&
                    err.response.data.message
                ) {
                    message = err.response.data.message;
                }
                modalEl
                    .querySelector("#delete-error")
                    .classList.remove("d-none");
                modalEl.querySelector("#delete-error").textContent = message;
                btn.textContent = originalText;
                btn.disabled = false;
            });
    });

    // cleanup on hide
    $modal.on("hidden.bs.modal", function () {
        modalEl.querySelector("#delete-error").classList.add("d-none");
        modalEl.querySelector("#delete-error").textContent = "";
        modalEl.querySelector("#delete-confirm").textContent =
            templates.deleteText;
        modalEl.querySelector("#delete-confirm").disabled = false;
        current = {
            url: null,
            itemName: null,
            deleteText: null,
            after: "reload",
            rowEl: null,
            onSuccess: null,
        };
    });

    return { show };
}
