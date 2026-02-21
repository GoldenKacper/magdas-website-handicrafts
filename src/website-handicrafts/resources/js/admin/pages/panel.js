import "../../../sass/admin/pages/panel.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import initDefaultDataTable from "../components/datatable.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    initDefaultDataTable("datatable", "data");
});
