import $ from "jquery";
window.$ = window.jQuery = $;

export default function initDefaultDataTable(tableId, dataName) {
    const table = document.querySelector(`#${tableId}[data-datatable="${dataName}"]`);
    if (!table) return;

    const appLocaleMeta = document.querySelector('meta[name="app-locale"]');
    const APP_LOCALE = appLocaleMeta ? appLocaleMeta.content : "en";
    const locale = APP_LOCALE || "en";
    const langUrl = getDataTablesLangUrl(locale);

    if (typeof DataTable === "undefined") {
        // jeśli DataTable z jakiegoś powodu nie jest załadowany — logujemy, ale nie blow up
        console.warn("DataTable is not available. Make sure admin.js imports datatables.net-bs5 before page modules.");
        return;
    }

    // Inicjalizacja DataTable
    new DataTable(table, {
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[0, "asc"]],
        language: {
            url: langUrl,
        },
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
